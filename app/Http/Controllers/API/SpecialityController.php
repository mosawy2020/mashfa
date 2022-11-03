<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\UploadRepository;
use App\Repositories\SpecialityRepository;
use App\Models\Speciality;
use Exception;
use Illuminate\Http\JsonResponse;
use App\Criteria\EProviders\AcceptedCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use App\Criteria\EProviders\EProvidersOfUserCriteria;
use Prettus\Repository\Exceptions\RepositoryException;


class SpecialityController extends Controller
{
    

 
	     private $SpecialityRepository;

	    /**
	     * @var UploadRepository
	     */
	    private $uploadRepository;

	    public function __construct(SpecialityRepository $SpecialityRepo, UploadRepository $uploadRepo)
	    {
	        $this->SpecialityRepository = $SpecialityRepo;
	        $this->uploadRepository = $uploadRepo;
	        parent::__construct();
	    }




     public function index(Request $request): JsonResponse
     {

        try {

            $Speciality = $this->SpecialityRepository->all();
            $this->filterCollection($request, $Speciality);

        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($Speciality->toArray(), __('lang.Api_Show_Speciality'));
      }




}//end of controllers
