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
Use \Firebase\JWT\Key;
use GuzzleHttp\Client;
use App\Traits\videoSdk;

class VideoSDKController extends Controller
{
   
    use videoSdk;


    public function MeetingCreate()
    {
        $URL = env("VIDEOSDK_API_ENDPOINT_Room","https://api.videosdk.live/v2/rooms");
        $this->get_token() ;
         $proccess = $this->proccessMetting($URL,$this->token);
        return $proccess;
    }

    public function MeetingId()
    {
        $URL = env("VIDEOSDK_API_ENDPOINT") . '/api/meetings';
        $proccess = $this->proccessMetting($URL,$this->token);
        return $proccess;
    }

    public function MeetingsValidation ()
    {
        $meetingId = "1n21-b6xt-eer912";
        $data = json_decode(file_get_contents('php://input'), true);
        $URL = env("VIDEOSDK_API_ENDPOINT") . '/api/meetings/' . $meetingId;
        $proccess = $this->proccessMetting($URL,$this->token);
        return $proccess;
    }

    




}
