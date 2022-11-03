<?php

namespace App\Http\Controllers\Api;

use App\Criteria\EServices\EServicesOfUserCriteria;
use App\Criteria\EServices\NearCriteria;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateEServiceRequest;
use App\Http\Requests\UpdateEServiceRequest;
use App\Models\EServiceType;
use App\Repositories\EProviderRepository;
use App\Repositories\EServiceRepository;
use App\Repositories\UploadRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Nwidart\Modules\Facades\Module;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Exceptions\RepositoryException;


class EServiceTypeAPIController extends Controller
{

    /** @var  eServiceRepository */
    private $eServiceRepository;
    /** @var UserRepository */
    private $userRepository;
    /**
     * @var UploadRepository
     */
    private $uploadRepository;

    public function __construct(EServiceRepository $eServiceRepo, UserRepository $userRepository, UploadRepository $uploadRepository)
    {
        parent::__construct();
        $this->eServiceRepository = $eServiceRepo;
        $this->userRepository = $userRepository;
        $this->uploadRepository = $uploadRepository;
    }

    /**
     * Display a listing of the EService.
     * GET|HEAD /eServices
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function indexy(Request $request): JsonResponse
    {
        try {
            $this->eServiceRepository->pushCriteria(new RequestCriteria($request));
            $this->eServiceRepository->pushCriteria(new EServicesOfUserCriteria(auth()->id()));
            $this->eServiceRepository->pushCriteria(new NearCriteria($request));
            $eServices = $this->eServiceRepository->all();

            $this->availableEServices($eServices);
            $this->availableEProvider($request, $eServices);
            $this->hasValidSubscription($request, $eServices);
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
     * @param Collection $eServices
     */
    private function availableEServices(Collection &$eServices)
    {
        $eServices = $eServices->where('available', true);
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
    private function hasValidSubscription(Request $request, Collection &$eServices)
    {
        if (Module::isActivated('Subscription')) {
            $eServices = $eServices->filter(function ($element) {
                return $element->eProvider->hasValidSubscription && $element->eProvider->accepted;
            });
        } else {
            $eServices = $eServices->filter(function ($element) {
                return $element->eProvider->accepted;
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

    /**
     * Display the specified EService.
     * GET|HEAD /eServices/{id}
     *
     * @param Request $request
     * @param int $id
     *
     * @return JsonResponse
     */


    public function index()
    {
        $types = EServiceType::all();
        return $this->sendResponse($types, "");

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $date = $request->validate(EServiceType::$rules);
        $e_service_type = EServiceType::create($date);
        $e_service_type->categories()->syncWithoutDetaching($request->categories);
        return $this->sendResponse($e_service_type, trans('lang.general_saved_successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        try {
            $this->eServiceRepository->pushCriteria(new RequestCriteria($request));
            $this->eServiceRepository->pushCriteria(new LimitOffsetCriteria($request));
        } catch (RepositoryException $e) {
            return $this->sendError($e->getMessage());
        }
        $type = EServiceType::with("eServices")
            ->findorfail($id);
        $eproviders = $type->eServices;
        $this->availableEProvider($request, $eproviders);
        $this->availableEServices($eproviders);
        $this->orderByRating($request, $eproviders);
        $this->limitOffset($request, $eproviders);
        $this->filterCollection($request, $eproviders);
        $eproviders = array_values($eproviders->toArray());
        $type->setRelation("eServices", collect($eproviders));

        return $this->sendResponse($type, trans(''));

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
