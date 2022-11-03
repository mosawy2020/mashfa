<?php

namespace App\Http\Controllers;

use Flash;
use Exception;
use App\Models\Speciality;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\UploadRepository;
use App\DataTables\SpecialityDataTable;
use App\Repositories\SpecialityRepository;
use App\Repositories\CustomFieldRepository;
use App\Http\Requests\CreateSpecialityRequest;
use App\Http\Requests\UpdateSpecialityRequest;

class SpecialityController extends Controller
{
    
    private $customFieldRepository;

    /**
     * @var UploadRepository
     */

    private $uploadRepository; 
    private $SpecialityRepository;

    public function __construct(SpecialityRepository $SpecialityRepository , CustomFieldRepository $customFieldRepo, UploadRepository $uploadRepo)
    {
        parent::__construct();
        $this->customFieldRepository = $customFieldRepo;
        $this->uploadRepository = $uploadRepo;
        $this->SpecialityRepository = $SpecialityRepository;

    }


    public function index(SpecialityDataTable $SpecialityDataTable)
    {
        return $SpecialityDataTable->render('speciality.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $speciality = $this->SpecialityRepository->pluck('name', 'id');

        $hasCustomField = in_array($this->SpecialityRepository->model(), setting('custom_field_models', []));
        if ($hasCustomField) {
            $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->SpecialityRepository->model());
            $html = generateCustomField($customFields);
        }
        return view('speciality.create')->with("customFields", isset($html) ? $html : false)->with("speciality", $speciality);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateSpecialityRequest $request)
    {
   
        try {

                $input = $request->validated();
                $input['user_id'] = Auth::id();
                $this->SpecialityRepository->create($input);

                Flash::success(__('lang.saved_successfully', ['operator' => __('lang.speciality')]));

                return redirect(route('speciality.index'));
            } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        
        $speciality = Speciality::findOrFail($id);
        
        return view('speciality.show')->with('speciality', $speciality);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {

        $speciality = Speciality::findOrFail($id);

        return view('speciality.edit')->with('speciality', $speciality);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id , UpdateSpecialityRequest $request)
    {
          try {

                $speciality = $this->SpecialityRepository->findWithoutFail($id);
                $input = $request->validated();
                $speciality->update($input);
                
                Flash::success(__('lang.saved_successfully', ['operator' => __('lang.speciality')]));

                return redirect(route('speciality.index'));
            } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Speciality = Speciality::findOrFail($id);

        $Speciality->delete($id);

        Flash::success(__('lang.deleted_successfully'));

        return redirect(route('speciality.index'));
    }
}
