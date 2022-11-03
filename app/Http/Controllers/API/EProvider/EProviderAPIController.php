<?php
/*
 * File name: EProviderAPIController.php
 * Last modified: 2022.04.08 at 09:32:35
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2022
 */

namespace App\Http\Controllers\API\EProvider;


use App\Criteria\EProviders\EProvidersOfUserCriteria;
use App\Http\Controllers\Controller;
use App\Repositories\EProviderRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class EProviderController
 * @package App\Http\Controllers\API
 */
class EProviderAPIController extends Controller
{
    /** @var  EProviderRepository */
    private $eProviderRepository;

    public function __construct(EProviderRepository $eProviderRepo)
    {
        $this->eProviderRepository = $eProviderRepo;
        parent::__construct();
    }

    /**
     * Display a listing of the EProvider.
     * GET|HEAD /eProviders
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $this->eProviderRepository->pushCriteria(new RequestCriteria($request));
            $this->eProviderRepository->pushCriteria(new EProvidersOfUserCriteria(auth()->id()));
            $this->eProviderRepository->pushCriteria(new LimitOffsetCriteria($request));
            $eProviders = $this->eProviderRepository->all();
            $this->filterCollection($request, $eProviders);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($eProviders->toArray(), 'E Providers retrieved successfully');
    }

    /**
     * Display the specified EProvider.
     * GET|HEAD /eProviders/{id}
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show(int $id, Request $request): JsonResponse
    {
        try {
            $this->eProviderRepository->pushCriteria(new RequestCriteria($request));
            $this->eProviderRepository->pushCriteria(new LimitOffsetCriteria($request));
            $eProvider = $this->eProviderRepository->findWithoutFail($id);
            if (empty($eProvider)) {
                return $this->sendError('EProvider not found');
            }
            $this->filterModel($request, $eProvider);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($eProvider->toArray(), 'EProvider retrieved successfully');
    }
}
