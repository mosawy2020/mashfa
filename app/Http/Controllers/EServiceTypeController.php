<?php
/*
 * File name: EServiceController.php
 * Last modified: 2021.03.21 at 15:11:01
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2021
 */

namespace App\Http\Controllers;

use App\Criteria\EProviders\EProvidersOfUserCriteria;
use App\Criteria\EServices\EServicesOfUserCriteria;
use App\DataTables\EServiceDataTable;
use App\DataTables\EServiceTypeDataTable;
use App\Http\Requests\CreateEServiceRequest;
use App\Http\Requests\UpdateEServiceRequest;
use App\Models\EServiceType;
use App\Repositories\CategoryRepository;
use App\Repositories\CustomFieldRepository;
use App\Repositories\EProviderRepository;
use App\Repositories\EServiceRepository;
use App\Repositories\EServiceTypeRepository;
use App\Repositories\UploadRepository;
use Exception;
use Flash;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\View\View;
use Prettus\Repository\Exceptions\RepositoryException;
use Prettus\Validator\Exceptions\ValidatorException;

class EServiceTypeController extends Controller
{
    /** @var  EServiceRepository */
    private $eServiceRepository;

    /** @var  EServiceTypeRepository */

    private $eServiceTypeRepository;

    /**
     * @var CustomFieldRepository
     */
    private $customFieldRepository;

    /**
     * @var UploadRepository
     */
    private $uploadRepository;
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;
    /**
     * @var EProviderRepository
     */
    private $eProviderRepository;


    public function __construct(EServiceRepository $eServiceRepo, CustomFieldRepository $customFieldRepo, UploadRepository $uploadRepo
        , CategoryRepository                       $categoryRepo
        , EServiceTypeRepository                   $eServiceTypeRepo
        , EProviderRepository                      $eProviderRepo)
    {
        parent::__construct();
        $this->eServiceRepository = $eServiceRepo;
        $this->customFieldRepository = $customFieldRepo;
        $this->uploadRepository = $uploadRepo;
        $this->categoryRepository = $categoryRepo;
        $this->eProviderRepository = $eProviderRepo;
        $this->eServiceTypeRepository = $eServiceTypeRepo;
    }

    /**
     * Display a listing of the EService.
     *
     * @param EServiceDataTable $eServiceDataTable
     * @return Response
     */
    public function index(EServiceTypeDataTable $eServiceTypeDataTable , Request $request)
    {

        return $eServiceTypeDataTable->render('e_service_types.index');
    }
    public function namesindex( Request $request)
    {
        if ($request->ajax()) {
            return response()->json(['data' =>EServiceType::pluck("name","id")]) ;
        }
    }

    /**
     * Show the form for creating a new EService.
     *
     * @return Application|Factory|Response|View
     */
    public function create()
    {
        $category = $this->categoryRepository->pluck('name', 'id');
//        $Eservicestypes = EServiceType::pluck('name', 'id')->toArray();

//        $eProvider = $this->eProviderRepository->getByCriteria(new EProvidersOfUserCriteria(auth()->id()))->pluck('name', 'id');
//        $typesSelected = [];
        $hasCustomField = in_array($this->eServiceRepository->model(), setting('custom_field_models', []));
        if ($hasCustomField) {
            $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->eServiceRepository->model());
            $html = generateCustomField($customFields);
        }
        return view('e_service_types.create')->with("customFields", isset($html) ? $html : false)
//            ->with("Eservicestypes", $Eservicestypes)
            ->with("category", $category)
            ->with("categoriesSelected", []);
//            ->with("typesSelected", $typesSelected)->with("eProvider", $eProvider);
    }

    /**
     * Store a newly created EService in storage.
     *
     * @param CreateEServiceRequest $request
     *
     * @return Application|RedirectResponse|Redirector|Response
     */
    public function store(Request $request)
    {
        $input =  $request->validate(EServiceType::$rules);

          $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->eServiceRepository->model());
        try {
            $eService = $this->eServiceTypeRepository->create($input);
            $eService->customFieldsValues()->createMany(getCustomFieldsValues($customFields, $request));
            if (isset($input['image']) && $input['image'] && is_array($input['image'])) {
                foreach ($input['image'] as $fileUuid) {
                    $cacheUpload = $this->uploadRepository->getByUuid($fileUuid);
                    $mediaItem = $cacheUpload->getMedia('image')->first();
                    $mediaItem->copy($eService, 'image');
                }
            }
        } catch (ValidatorException $e) {
            Flash::error($e->getMessage());
        }

        Flash::success(__('lang.saved_successfully', ['operator' => __('lang.e_service')]));

        return redirect(route('eServiceTypes.index'));
    }

    /**
     * Display the specified EService.
     *
     * @param int $id
     *
     * @return Application|RedirectResponse|Redirector|Response
     * @throws RepositoryException
     */
    public function show(int $id)
    {
        $this->eServiceRepository->pushCriteria(new EServicesOfUserCriteria(auth()->id()));
        $eService = $this->eServiceRepository->findWithoutFail($id);

        if (empty($eService)) {
            Flash::error('E Service not found');

            return redirect(route('eServices.index'));
        }

        return view('e_services.show')->with('eService', $eService);
    }

    /**
     * Show the form for editing the specified EService.
     *
     * @param int $id
     *
     * @return Application|RedirectResponse|Redirector|Response
     * @throws RepositoryException
     */
    public function edit(int $id)
    {
        if($id==1) return  redirect()->back() ;
//        $this->eServiceTypeRepository->pushCriteria(new EServicesOfUserCriteria(auth()->id()));
        $eService = $this->eServiceTypeRepository->findWithoutFail($id);
//        $Eservicestypes = EServiceType::pluck('name', 'id')->toArray();

        if (empty($eService)) {
            Flash::error(__('lang.not_found', ['operator' => __('lang.e_service')]));

            return redirect(route('eServiceTypes.index'));
        }
        $category = $this->categoryRepository->pluck('name', 'id');
//        $eProvider = $this->eProviderRepository->getByCriteria(new EProvidersOfUserCriteria(auth()->id()))->pluck('name', 'id');

        $categoriesSelected = isset ($eService->categories) ? $eService->categories()->pluck('categories.id')->toArray() :
            [];

        $customFieldsValues = $eService->customFieldsValues()->with('customField')->get();
        $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->eServiceRepository->model());
        $hasCustomField = in_array($this->eServiceTypeRepository->model(), setting('custom_field_models', []));
        if ($hasCustomField) {
            $html = generateCustomField($customFields, $customFieldsValues);
        }

        return view('e_service_types.edit')->with('eService', $eService)->with("customFields", isset($html) ? $html : false)
            ->with("category", $category)
            ->with("typesSelected", [])
            ->with("categoriesSelected", $categoriesSelected) ;
//            ->with("eProvider", $eProvider);
    }

    /**
     * Update the specified EService in storage.
     *
     * @param int $id
     * @param UpdateEServiceRequest $request
     *
     * @return Application|RedirectResponse|Redirector|Response
     * @throws RepositoryException
     */
    public function update(int $id, Request $request)
    {
//        $this->eServiceRepository->pushCriteria(new EServicesOfUserCriteria(auth()->id()));
        $input =  $request->validate(EServiceType::$rules);
        $eService = $this->eServiceTypeRepository->findWithoutFail($id);

        if (empty($eService)) {
            Flash::error('E Service not found');
            return redirect(route('eServiceTypes.index'));
        }
        $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->eServiceRepository->model());
        try {
//            $input['categories'] = isset($input['categories']) ? $input['categories'] : [];
            $eService = $this->eServiceTypeRepository->update($input, $id);
            if (isset($input['image']) && $input['image'] && is_array($input['image'])) {
                foreach ($input['image'] as $fileUuid) {
                    $cacheUpload = $this->uploadRepository->getByUuid($fileUuid);
                    $mediaItem = $cacheUpload->getMedia('image')->first();
                    $mediaItem->copy($eService, 'image');
                }
            }
            foreach (getCustomFieldsValues($customFields, $request) as $value) {
                $eService->customFieldsValues()
                    ->updateOrCreate(['custom_field_id' => $value['custom_field_id']], $value);
            }
        } catch (ValidatorException $e) {
            Flash::error($e->getMessage());
        }

        Flash::success(__('lang.updated_successfully', ['operator' => __('lang.e_service')]));

        return redirect(route('eServiceTypes.index'));
    }

    /**
     * Remove the specified EService from storage.
     *
     * @param int $id
     *
     * @return Application|RedirectResponse|Redirector|Response
     * @throws RepositoryException
     */
    public function destroy(int $id)
    {
//        $this->eServiceRepository->pushCriteria(new EServicesOfUserCriteria(auth()->id()));
        $eService = $this->eServiceTypeRepository->findWithoutFail($id);

        if (empty($eService)) {
            Flash::error('E Service TYpe not found');

            return redirect(route('eServiceTypes.index'));
        }

        $this->eServiceTypeRepository->delete($id);

        Flash::success(__('lang.deleted_successfully', ['operator' => __('lang.e_service')]));

        return redirect(route('eServiceTypes.index'));
    }

    /**
     * Remove Media of EService
     * @param Request $request
     */
    public function removeMedia(Request $request)
    {
        $input = $request->all();
        $eService = $this->eServiceRepository->findWithoutFail($input['id']);
        try {
            if ($eService->hasMedia($input['collection'])) {
                $eService->getFirstMedia($input['collection'])->delete();
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }
}