<?php

namespace App\Http\Controllers;

use Flash;
use Exception;
use App\Models\User;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Models\PatientMedicalFile;
use Illuminate\Support\Facades\Log;
use App\Repositories\UploadRepository;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\UpdatePatientRequest;
use App\Repositories\CustomFieldRepository;
use App\Repositories\PatientMedicalRepository;
use App\DataTables\PatientMedicalFileDataTable;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Repositories\BookingRepository;
use Illuminate\Support\Facades\DB;
use DateTimeImmutable;
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;
use GuzzleHttp\Client;
use App\Traits\videoSdk;
use Illuminate\Support\Facades\Auth;

class PatientMedicalFileController extends Controller
{
    
    private $customFieldRepository;
    private $PatientMedicalRepository;
    private $bookingRepository;

    /**
     * @var UploadRepository
     */
    private $uploadRepository; 
    use videoSdk;

    public function __construct(BookingRepository $bookingRepo,PatientMedicalRepository $categoryRepo, CustomFieldRepository $customFieldRepo, UploadRepository $uploadRepo)
    {
        parent::__construct();
        $this->bookingRepository = $bookingRepo;
        $this->PatientMedicalRepository = $categoryRepo;
        $this->customFieldRepository = $customFieldRepo;
        $this->uploadRepository = $uploadRepo;
    }

    
    public function index(PatientMedicalFileDataTable $PatientMedicalFile)
    {
        return $PatientMedicalFile->render('patients.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $PatientMedicalsFile = $this->PatientMedicalRepository->pluck('services', 'id');

        $hasCustomField = in_array($this->PatientMedicalRepository->model(), setting('custom_field_models', []));
        if ($hasCustomField) {
            $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->PatientMedicalRepository->model());
            $html = generateCustomField($customFields);
        }
        return view('patients.create')->with("customFields", isset($html) ? $html : false)->with("PatientMedicalFile", $PatientMedicalsFile);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UpdatePatientRequest $request)
    {
        //   return $request;

       // try {
        
        //     $PatientMedicalFile = new PatientMedicalFile;
        //     $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->PatientMedicalRepository->model());
            
        //     $PatientMedicalFile->services = $request->services;
        //     $PatientMedicalFile->diseases_suffers_from = $request->diseases_suffers_from;
        //     $PatientMedicalFile->married = $request->married;
        //     $PatientMedicalFile->age = $request->age;
        //     $PatientMedicalFile->medications_takes = $request->medications_takes;
        //     $PatientMedicalFile->history_operations = $request->history_operations;

        //     if($request->hasFile('file'))
        //     {

        //     $imageName = time() . '.' . request()->file->getClientOriginalExtension();
        //     request()->file->storeAs('public/patientFiles/',$imageName);
        
        //     $data['file'] =  asset('storage/patientFiles/'. $imageName);
        //     $PatientMedicalFile->file =  $data['file'];

        //     }

        //     $PatientMedicalFile->user_id = auth()->user()->id;
        //     $PatientMedicalFile->save();

        //     foreach (getCustomFieldsValues($customFields, $request) as $value) {
        //         $PatientMedicalFile->customFieldsValues()
        //             ->updateOrCreate(['custom_field_id' => $value['custom_field_id']], $value);
        //     }

        // } catch (ValidatorException $e) {
        //     Flash::error($e->getMessage());
        // }

        // Flash::success(__('lang.updated_successfully', ['operator' => __('lang.category')]));

        // return redirect(route('PatientMedical.index'));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PatientMedicalsFile  $PatientMedicalsFile
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    
        $PatientMedicalsFile = PatientMedicalFile::findOrFail($id);
        
        $Booking = DB::table('bookings')->where('user_id' , $PatientMedicalsFile->user_id)->select('*')->get();// This query user_id Reservations ....
     
        if (empty($PatientMedicalsFile)) {
            Flash::error('Patient Medicals File not found');

            return redirect(route('PatientMedical.index'));
        }

        return view('patients.show')->with('PatientMedicalFile', $PatientMedicalsFile)->with('Booking' , $Booking);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PatientMedicalsFile  $PatientMedicalsFile
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $PatientMedicalsFile = PatientMedicalFile::findOrFail($id);

        if (empty($PatientMedicalsFile)) {
            Flash::error(__('lang.not_found', ['operator' => __('lang.category')]));

            return redirect(route('patients.index'));
        }
       
        return view('patients.edit')->with('PatientMedicalFile', $PatientMedicalsFile);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PatientMedicalsFile  $PatientMedicalsFile
     * @return \Illuminate\Http\Response
     */
    public function update($id, UpdatePatientRequest $request)
    {
      
        try {
            
            $PatientMedicalsFile = PatientMedicalFile::findOrFail($id);
            $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->PatientMedicalRepository->model());

            $input = $request->validated();
            $input['user_id'] = Auth::id();

            if($request->hasFile('file'))
            {
                $imageName = time() . '.' . request()->file->getClientOriginalExtension();
                request()->file->storeAs('public/patientFiles/',$imageName);
                $input['file'] =  asset('storage/patientFiles/'. $imageName);
            }

            $PatientMedicalsFile->update($input);


            foreach (getCustomFieldsValues($customFields, $request) as $value) {
                $PatientMedicalsFile->customFieldsValues()
                    ->updateOrCreate(['custom_field_id' => $value['custom_field_id']], $value);
            }


        } catch (ValidatorException $e) {
            Flash::error($e->getMessage());
        }

        Flash::success(__('lang.updated_successfully', ['operator' => __('lang.category')]));

        return redirect(route('PatientMedical.index'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PatientMedicalsFile  $PatientMedicalsFile
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $PatientMedicalsFile = PatientMedicalFile::findOrFail($id);

        $PatientMedicalsFile->delete($id);

        Flash::success(__('lang.deleted_successfully', ['operator' => __('Patient Medicals File')]));

        return redirect(route('PatientMedical.index'));
    }



   


}// end of controllers
