<?php
/*
 * File name: EProviderTypeAPIController.php
 * Last modified: 2022.04.09 at 17:43:00
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2022
 */

namespace App\Http\Controllers\API;


use App\Criteria\EProviderTypes\EnabledCriteria;
use App\Http\Controllers\Controller;
use App\Repositories\EProviderTypeRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class EProviderTypeController
 * @package App\Http\Controllers\API
 */
class EProviderTypeAPIController extends Controller
{
    /** @var  EProviderTypeRepository */
    private $eProviderTypeRepository;

    public function __construct(EProviderTypeRepository $eProviderTypeRepo)
    {
        $this->eProviderTypeRepository = $eProviderTypeRepo;
        parent::__construct();
    }

    /**
     * Display a listing of the EProviderType.
     * GET|HEAD /e_provider_types
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $this->eProviderTypeRepository->pushCriteria(new RequestCriteria($request));
            $this->eProviderTypeRepository->pushCriteria(new EnabledCriteria());
            $this->eProviderTypeRepository->pushCriteria(new LimitOffsetCriteria($request));
            $eProviderTypes = $this->eProviderTypeRepository->all();
            $this->filterCollection($request, $eProviderTypes);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }
        return $this->sendResponse($eProviderTypes->toArray(), 'E Provider Types retrieved successfully');
    }
}
