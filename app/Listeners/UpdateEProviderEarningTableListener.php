<?php
/*
 * File name: UpdateEProviderEarningTableListener.php
 * Last modified: 2022.04.06 at 05:58:17
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2022
 */

namespace App\Listeners;

use App\Repositories\EarningRepository;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class UpdateEProviderEarningTableListener
 * @package App\Listeners
 */
class UpdateEProviderEarningTableListener
{
    /**
     * @var EarningRepository
     */
    private $earningRepository;

    /**
     * EarningTableListener constructor.
     */
    public function __construct(EarningRepository $earningRepository)
    {

        $this->earningRepository = $earningRepository;
    }


    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle($event)
    {
        if ($event->newEProvider->accepted) {
            $uniqueInput = ['e_provider_id' => $event->newEProvider->id];
            try {
                $this->earningRepository->updateOrCreate($uniqueInput);
            } catch (ValidatorException $e) {
            }
        }
    }
}
