<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\CreatePatientRequest;
use App\Repositories\PatientMedicalRepository;
use Illuminate\Http\Request;
use App\Models\PatientMedicalFile;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\PatientsMedicalFile;

class PatientMedicalFileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $PatientMedicalRepository;

    public function __construct(PatientMedicalRepository $PatientMedicalRepo)
    {
        $this->PatientMedicalRepository = $PatientMedicalRepo;
        parent::__construct();
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePatientRequest $request)
    {
        $input = $request->validated();
        $input['user_id'] = Auth::id();


        if ($request->hasFile('file')) {

                $imageName = time() . '.' . request()->file->getClientOriginalExtension();
                request()->file->storeAs('public/patientFiles/', $imageName);

                $data['file'] = asset('storage/patientFiles/' . $imageName);

            }

        $PatientMedicalsFile =   $this->PatientMedicalRepository->create($input);

            return response()->json([
                'success' => true,
                'message' => trans('lang.general_saved_successfully'),
                "data" => $PatientMedicalsFile,

            ], 200);

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {


        $user_id = auth()->user()->id; // Get is user
        $PatientMedicalsFile = PatientMedicalFile::where('user_id' , $user_id)->find($request->id);

            if (empty($PatientMedicalsFile)) {
                return $this->sendError(__("lang.data_false"));
            }

            return $this->sendResponse($PatientMedicalsFile->toArray(), __("lang.data_true_medical_file"));



        }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
