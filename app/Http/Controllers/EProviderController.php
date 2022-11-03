<?php
/*
 * File name: EProviderController.php
 * Last modified: 2021.11.04 at 11:59:07
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2021
 */

namespace App\Http\Controllers;

use App\Models\EProvider;
use App\Models\EService;
use App\Models\EServiceType;
use Flash;
use Exception;
use App\Models\Award;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Models\Experience;
use Illuminate\Http\Request;
use App\Models\EProvidersAward;
use App\Models\EproviderEservice;
use Illuminate\Routing\Redirector;
use App\Models\EProviderExperience;
use App\Repositories\TaxRepository;
use Illuminate\Support\Facades\Log;
use App\Repositories\UserRepository;
use App\Events\EProviderChangedEvent;
use Illuminate\Http\RedirectResponse;
use App\DataTables\EProviderDataTable;
use App\Repositories\UploadRepository;
use Illuminate\Contracts\View\Factory;
use App\Repositories\AddressRepository;
use App\Repositories\EServiceRepository;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use App\Repositories\EProviderRepository;
use App\Repositories\SpecialityRepository;
use App\Repositories\CustomFieldRepository;
use App\Http\Requests\CreateEProviderRequest;
use App\Http\Requests\UpdateEProviderRequest;
use App\Repositories\EProviderTypeRepository;
use App\DataTables\RequestedEProviderDataTable;
use App\Criteria\EProviderTypes\EnabledCriteria;
use Illuminate\Contracts\Foundation\Application;
use App\Criteria\Addresses\AddressesOfUserCriteria;
use App\Criteria\Users\EProvidersCustomersCriteria;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Criteria\EProviders\EProvidersOfUserCriteria;
use App\Http\Requests\CreateEserviceEproviderRequest;
use App\Http\Requests\UpdateEserviceEproviderRequest;
use Prettus\Repository\Exceptions\RepositoryException;

class EProviderController extends Controller
{
    /** @var  EProviderRepository */
    private $eProviderRepository;

    /**
     * @var CustomFieldRepository
     */
    private $customFieldRepository;

    /**
     * @var UploadRepository
     */
    private $uploadRepository;
    /**
     * @var EProviderTypeRepository
     */
    private $eProviderTypeRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var AddressRepository
     */
    private $addressRepository;
    /**
     * @var TaxRepository
     */
    private $taxRepository;

    private $eServiceRepository;
    private $SpecialityRepository;

    public function __construct(SpecialityRepository $SpecialityRepository , EServiceRepository $eServiceRepo,EProviderRepository $eProviderRepo, CustomFieldRepository $customFieldRepo, UploadRepository $uploadRepo
        , EProviderTypeRepository                   $eProviderTypeRepo
        , UserRepository                            $userRepo
        , AddressRepository                         $addressRepo
        , TaxRepository                             $taxRepo)
    {
        parent::__construct();
        $this->eProviderRepository = $eProviderRepo;
        $this->customFieldRepository = $customFieldRepo;
        $this->uploadRepository = $uploadRepo;
        $this->eProviderTypeRepository = $eProviderTypeRepo;
        $this->userRepository = $userRepo;
        $this->addressRepository = $addressRepo;
        $this->taxRepository = $taxRepo;
        $this->eServiceRepository = $eServiceRepo;
        $this->SpecialityRepository = $SpecialityRepository;

    }

    /**
     * Display a listing of the EProvider.
     *
     * @param EProviderDataTable $eProviderDataTable
     * @return mixed
     */
    public function index(EProviderDataTable $eProviderDataTable)
    {

        return $eProviderDataTable->render('e_providers.index');
    }

    /**
     * Display a listing of the EProvider.
     *
     * @param EProviderDataTable $eproviderDataTable
     * @return mixed
     */
    public function requestedEProviders(RequestedEProviderDataTable $requestedEProviderDataTable)
    {
        return $requestedEProviderDataTable->render('e_providers.requested');
    }

    /**
     * Show the form for creating a new EProvider.
     *
     * @return Application|Factory|Response|View
     */
    public function create()
    {
        $eProviderType = $this->eProviderTypeRepository->getByCriteria(new EnabledCriteria())->pluck('name', 'id');
        $user = $this->userRepository->getByCriteria(new EProvidersCustomersCriteria())->pluck('name', 'id');
        $address = $this->addressRepository->getByCriteria(new AddressesOfUserCriteria(auth()->id()))->pluck('address', 'id');
        $tax = $this->taxRepository->pluck('name', 'id');
        $aword = Award::pluck('title', 'id')->toArray();
        $Experience = Experience::pluck('title', 'id')->toArray();
        $speciality = $this->SpecialityRepository->pluck('name', 'id');
        $usersSelected = [];
        $addressesSelected = [];
        $taxesSelected = [];
        $hasCustomField = in_array($this->eProviderRepository->model(), setting('custom_field_models', []));
        if ($hasCustomField) {
            $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->eProviderRepository->model());
            $html = generateCustomField($customFields);
        }
        return view('e_providers.create')->with("customFields", isset($html) ? $html : false)->with('speciality' , $speciality)->with("aword", $aword)->with("Experience", $Experience)->with("eProviderType", $eProviderType)->with("user", $user)->with("usersSelected", $usersSelected)->with("address", $address)->with("addressesSelected", $addressesSelected)->with("tax", $tax)->with("taxesSelected", $taxesSelected);
    }

    /**
     * Store a newly created EProvider in storage.
     *
     * @param CreateEProviderRequest $request
     *
     * @return Application|RedirectResponse|Redirector|Response
     */
    public function store(CreateEProviderRequest $request)
    {
        $input = $request->all();
        if (auth()->user()->hasRole(['provider', 'customer'])) {
            $input['users'] = [auth()->id()];
        }
        $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->eProviderRepository->model());
        try {
            $eProvider = $this->eProviderRepository->create($input);

            foreach ($request['award_idss'] as $awards){

                $eProvider->e_provider_awords()->attach($awards);

            }// Insert to Many To Many experiences

            foreach ($request['experience_idss'] as $experiences){

                $eProvider->e_provider_experiences()->attach($experiences);

            }// Insert to Many To Many experiences

            $eProvider->customFieldsValues()->createMany(getCustomFieldsValues($customFields, $request));
            if (isset($input['image']) && $input['image'] && is_array($input['image'])) {
                foreach ($input['image'] as $fileUuid) {
                    $cacheUpload = $this->uploadRepository->getByUuid($fileUuid);
                    $mediaItem = $cacheUpload->getMedia('image')->first();
                    $mediaItem->copy($eProvider, 'image');
                }
            }
            event(new EProviderChangedEvent($eProvider, $eProvider));
        } catch (ValidatorException $e) {
            Flash::error($e->getMessage());
        }

        Flash::success(__('lang.saved_successfully', ['operator' => __('lang.e_provider')]));

        return redirect(route('eProviders.index'));
    }

    /**
     * Display the specified EProvider.
     *
     * @param int $id
     *
     * @return Application|RedirectResponse|Redirector|Response
     * @throws RepositoryException
     */
    public function show(int $id , Request $request)
    {
         $this->eProviderRepository->pushCriteria(new EProvidersOfUserCriteria(auth()->id()));
        $eProvider = $this->eProviderRepository->with("eproviderType")->findWithoutFail($id);
        if($request->ajax()){
         return  \response()->json(["eProvider" =>$eProvider])  ;
        }
        if (empty($eProvider)) {
            Flash::error(__('lang.not_found', ['operator' => __('lang.e_provider')]));

            return redirect(route('eProviders.index'));
        }

        return view('e_providers.show')->with('eProvider', $eProvider);
    }

    /**
     * Show the form for editing the specified EProvider.
     *
     * @param int $id
     *
     * @return Application|RedirectResponse|Redirector|Response
     * @throws RepositoryException
     */
    public function edit(int $id)
    {

        $speciality = $this->SpecialityRepository->pluck('name', 'id');
        $this->eProviderRepository->pushCriteria(new EProvidersOfUserCriteria(auth()->id()));
        $eProvider = $this->eProviderRepository->findWithoutFail($id);
        if($eProvider) {
            $eProvider_aword =$eProvider->load(['e_provider_awords','e_provider_experiences']);
        }

        if (empty($eProvider)) {
            Flash::error(__('lang.not_found', ['operator' => __('lang.e_provider')]));
            return redirect(route('eProviders.index'));
        }
        $eProviderType = $this->eProviderTypeRepository->getByCriteria(new EnabledCriteria())->pluck('name', 'id');
        $user = $this->userRepository->getByCriteria(new EProvidersCustomersCriteria())->pluck('name', 'id');
        $address = $this->addressRepository->getByCriteria(new AddressesOfUserCriteria(auth()->id()))->pluck('address', 'id');
        $tax = $this->taxRepository->pluck('name', 'id');
        $usersSelected = $eProvider->users()->pluck('users.id')->toArray();
        $addressesSelected = $eProvider->addresses()->pluck('addresses.id')->toArray();
        $taxesSelected = $eProvider->taxes()->pluck('taxes.id')->toArray();
        $aword = Award::pluck('title', 'id')->toArray();
        $Experience = Experience::pluck('title', 'id')->toArray();


        $customFieldsValues = $eProvider->customFieldsValues()->with('customField')->get();
        $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->eProviderRepository->model());
        $hasCustomField = in_array($this->eProviderRepository->model(), setting('custom_field_models', []));
        if ($hasCustomField) {
            $html = generateCustomField($customFields, $customFieldsValues);
        }

        return view('e_providers.edit')->with('eProvider', $eProvider)->with('speciality' , $speciality)->with('aword', $aword)->with('eProvider_aword', $eProvider_aword)->with('Experience', $Experience)->with("customFields", isset($html) ? $html : false)->with("eProviderType", $eProviderType)->with("user", $user)->with("usersSelected", $usersSelected)->with("address", $address)->with("addressesSelected", $addressesSelected)->with("tax", $tax)->with("taxesSelected", $taxesSelected);
    }

    /**
     * Update the specified EProvider in storage. Experience
     *
     * @param int $id
     * @param UpdateEProviderRequest $request
     *
     * @return Application|RedirectResponse|Redirector|Response
     * @throws RepositoryException
     */
    public function update(int $id, UpdateEProviderRequest $request)
    {
        // return $request;
        $this->eProviderRepository->pushCriteria(new EProvidersOfUserCriteria(auth()->id()));
        $oldEProvider = $this->eProviderRepository->findWithoutFail($id);

        if (empty($oldEProvider)) {
            Flash::error(__('lang.not_found', ['operator' => __('lang.e_provider')]));
            return redirect(route('eProviders.index'));
        }
        $input = $request->all();
        $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->eProviderRepository->model());
        try {
            $input['users'] = isset($input['users']) ? $input['users'] : [];
            $input['addresses'] = isset($input['addresses']) ? $input['addresses'] : [];
            $input['taxes'] = isset($input['taxes']) ? $input['taxes'] : [];
            $eProvider = $this->eProviderRepository->update($input, $id);
            
            if ($eProvider) { // check e_providers ids exists to deleted
                $EProvidersAward = EProvidersAward::where('e_provider_id' , $eProvider->id)->delete();
            }
            
            foreach ($request['award_idss'] as $awards){
                
                $EProvidersAward = EProvidersAward::updateOrCreate(
                  ['award_id' => $awards,'e_provider_id' => $eProvider['id'], ]);

            }// Insert Or Update to Many To Many experiences
            
            if ($eProvider) { // check e_providers ids exists to deleted
                $EProvidersAward = EProviderExperience::where('e_provider_id' , $eProvider->id)->delete();
            }
            
            foreach ($request['experience_idss'] as $experiences){

                $EProviderExperience = EProviderExperience::updateOrCreate(
                    ['experiences_id' => $experiences,'e_provider_id' => $eProvider['id'],]);

            }// Insert Or Update to Many To Many experiences

            if (isset($input['image']) && $input['image'] && is_array($input['image'])) {
                foreach ($input['image'] as $fileUuid) {
                    $cacheUpload = $this->uploadRepository->getByUuid($fileUuid);
                    $mediaItem = $cacheUpload->getMedia('image')->first();
                    $mediaItem->copy($eProvider, 'image');
                }
            }
            foreach (getCustomFieldsValues($customFields, $request) as $value) {
                $eProvider->customFieldsValues()
                    ->updateOrCreate(['custom_field_id' => $value['custom_field_id']], $value);
            }
            event(new EProviderChangedEvent($eProvider, $oldEProvider));
        } catch (ValidatorException $e) {
            Flash::error($e->getMessage());
        }

        Flash::success(__('lang.updated_successfully', ['operator' => __('lang.e_provider')]));

        return redirect(route('eProviders.index'));
    }

    /**
     * Remove the specified EProvider from storage.
     *
     * @param int $id
     *
     * @return Application|RedirectResponse|Redirector|Response
     * @throws RepositoryException
     */
    public function destroy(int $id)
    {
        if (config('installer.demo_app')) {
            Flash::warning('This is only demo app you can\'t change this section ');
            return redirect(route('eProviders.index'));
        }
        $this->eProviderRepository->pushCriteria(new EProvidersOfUserCriteria(auth()->id()));
        $eProvider = $this->eProviderRepository->findWithoutFail($id);

        if (empty($eProvider)) {
            Flash::error(__('lang.not_found', ['operator' => __('lang.e_provider')]));

            return redirect(route('eProviders.index'));
        }

        $this->eProviderRepository->delete($id);

        Flash::success(__('lang.deleted_successfully', ['operator' => __('lang.e_provider')]));

        return redirect(route('eProviders.index'));
    }

    /**
     * Remove Media of EProvider
     * @param Request $request
     */
    public function removeMedia(Request $request)
    {
        $input = $request->all();
        $eProvider = $this->eProviderRepository->findWithoutFail($input['id']);
        try {
            if ($eProvider->hasMedia($input['collection'])) {
                $eProvider->getFirstMedia($input['collection'])->delete();
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }



    protected function EditserviesProvider(int $id)  // EditserviesProvider
    {

         $eProvider = $this->eProviderRepository->findWithoutFail($id);
          if(is_null($eProvider)) {abort(404);} // check eProvider exists Or No exists ...
        $Eservicestypes = EServiceType::pluck('name', 'id')->toArray();
         $EproviderEservices = $eProvider->eServices();
        $typesSelected = [] ;
        return view('e_providers.add-serviec-provider')
           ->with('eProvider',$eProvider)->with('Eservicestypes', $Eservicestypes)
            ->with('EproviderEservices',$EproviderEservices)
            ->with('static_provider_id',$id)
            ->with('typesSelected',$typesSelected);

    }

    

    protected function UpdateEserviesProvider(int $id, UpdateEserviceEproviderRequest $request) // UpdateEserviesProvider
    {

   try {
         foreach ($request->validated() as $List_Class) {
                     EService::create($List_Class[0]);
                }

                Flash::success(__('lang.saved_successfully', ['operator' => __('lang.e_provider')]));

                return redirect(route('eProviders.index'));
            } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }


    protected function ShowEserviesProvider(int $id) // ShowEserviesProvider
    {
         $eProvider = $this->eProviderRepository->findWithoutFail($id);
          if(is_null($eProvider)) {abort(404);} // check eProvider exists Or No exists ...
         $Eservices = $this->eServiceRepository->pluck('name', 'id');
         $EproviderEservices = EproviderEservice::where('e_provider_id' , $eProvider->id)->select('*')->get();

        return view('e_providers.show_servies_provider')
           ->with('eProvider',$eProvider)->with('Eservices', $Eservices)->with('EproviderEservices',$EproviderEservices);

    }


    protected function StoreEserviesProvider(int $id, Request $request) // StoreEserviesProvider
    {

         $EproviderEservices = EproviderEservice::findOrFail($request->ids);

        try {


                    $EproviderEservices -> update([
                        'e_provider_id'=> $id,
                        'e_services_id'=> $request->e_services_id,
                        'price'=> $request->price,
                        'discount_price'=> $request->discount_price,
                        'price_unit'=> $request->price_unit,
                        'duration'=> $request->duration,
                        'quantity_unit'=> $request->quantity_unit,
                        'user_id'=> auth()->user()->id,

                    ]);


                Flash::success(__('lang.saved_successfully', ['operator' => __('lang.e_provider')]));

                return back();
            } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }



    public function DestroyEserviesProvider(int $id) // DestroyEserviesProvider
    {
       
        $EproviderEservices = EproviderEservice::findOrFail($id);

        if($EproviderEservices == true)
        {
            $EproviderEservices->delete();
        }


        Flash::success(__('lang.deleted_successfully', ['operator' => __('lang.e_provider')]));

        return back();
    }

    

    public function CheckDoctorName ($id) // Ajax Request Query Doctor ... 
    {

         $eProviders = $this->eProviderTypeRepository->where('id' , $id)->pluck('name'); 

         return response()->json($eProviders);
       
    }


    public function ShowService ($id)
    {

         $Eservices = EService::where("e_provider_id" , $id)->select("*")->with(['EServiceType'])->get();

         return view('e_providers.show-servies')
         ->with('Eservices', $Eservices);


    }






    
    
    

    


}// end of controllers
