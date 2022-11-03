<?php
/*
 * File name: EServiceAPIController.php
 * Last modified: 2022.04.13 at 08:14:30
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2022
 */

namespace App\Http\Controllers\API\EProvider;


use App\Criteria\EServices\EServicesOfEProviderCriteria;
use App\Criteria\EServices\NearCriteria;
use App\Http\Controllers\Controller;
use App\Repositories\EServiceRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class EServiceController
 * @package App\Http\Controllers\API
 */
class EServiceAPIController extends Controller
{
    /** @var  eServiceRepository */
    private $eServiceRepository;

    public function __construct(EServiceRepository $eServiceRepo)
    {
        parent::__construct();
        $this->eServiceRepository = $eServiceRepo;
    }

    /**
     * Display a listing of the EService.
     * GET|HEAD /eServices
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $this->eServiceRepository->pushCriteria(new RequestCriteria($request));
            $this->eServiceRepository->pushCriteria(new EServicesOfEProviderCriteria(auth()->id()));
            $this->eServiceRepository->pushCriteria(new NearCriteria($request));
            $eServices = $this->eServiceRepository->all();

            $this->availableEProvider($request, $eServices);
            $this->orderByRating($request, $eServices);
            $this->limitOffset($request, $eServices);
            $this->filterCollection($request, $eServices);
            $eServices = array_values($eServices->toArray());
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }
        return $this->sendResponse($eServices, 'E Services retrieved successfully');
    }

    /**
     * @param Request $request
     * @param Collection $eServices
     */
    private function availableEProvider(Request $request, Collection &$eServices)
    {
        if ($request->has('available_e_provider')) {
            $eServices = $eServices->filter(function ($element) {
                return $element->eProvider->available;
            });
        }
    }

    /**
     * @param Request $request
     * @param Collection $eServices
     */
    private function orderByRating(Request $request, Collection &$eServices)
    {
        if ($request->has('rating')) {
            $eServices = $eServices->sortBy('rate', SORT_REGULAR, true);
        }
    }
}
