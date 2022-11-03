<?php
/*
 * File name: EServiceCast.php
 * Last modified: 2021.11.21 at 21:35:24
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2021
 */

namespace App\Casts;

use App\Models\EService;
use App\Models\EServiceType;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use InvalidArgumentException;

/**
 * Class EServiceCast
 * @package App\Casts
 */
class EServiceTypeCast implements CastsAttributes
{

    /**
     * @inheritDoc
     */
    public function get($model, string $key, $value, array $attributes): EServiceType
    {
        $decodedValue = json_decode($value, true);
        $eService = EServiceType::find($decodedValue['id']);
        // service exist in database
        if (!empty($eService)) {
            return $eService;
        }
        // if not exist the clone will loaded
        // create new service based on values stored on database
        $eService = new EServiceType($decodedValue);
        // push id attribute fillable array
        array_push($eService->fillable, 'id');
        // assign the id to service object
        $eService->id = $decodedValue['id'];
        dd($eService) ;
        return $eService;
    }

    /**
     * @inheritDoc
     */
    public function set($model, string $key, $value, array $attributes): array
    {
        if (!$value instanceof EServiceType) {
            throw new InvalidArgumentException('The given value is not an EServiceType instance.');
        }

        return [
            'e_service_type' => json_encode(
                [
                    'id' => $value['id'],
                    'name' => $value['name'],
                    'description' => $value['description'],
                ]
            )
        ];
    }
}
