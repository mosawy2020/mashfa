<?php
/*
 * File name: EServiceRepository.php
 * Last modified: 2021.03.25 at 18:04:58
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2021
 */

namespace App\Repositories;

use App\Models\EService;
use App\Models\EServiceType;
use InfyOm\Generator\Common\BaseRepository;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;

/**
 * Class EServiceRepository
 * @package App\Repositories
 * @version January 19, 2021, 1:59 pm UTC
 *
 * @method EServiceType findWithoutFail($id, $columns = ['*'])
 * @method EServiceType find($id, $columns = ['*'])
 * @method EServiceType first($columns = ['*'])
 */
class EServiceTypeRepository extends BaseRepository implements CacheableInterface
{

    use CacheableRepository;

    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'price',
        'discount_price',
        'price_unit',
        'quantity_unit',
        'duration',
        'description',
        'featured',
        'available',
        'e_provider_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return EServiceType::class;
    }

    /**
     * @return array
     */
    public function groupedByEProviders(): array
    {
        $eServices = [];
        foreach ($this->all() as $model) {
            if (!empty($model->eProvider)) {
                $eServices[$model->eProvider->name][$model->id] = $model->name;
            }
        }
        return $eServices;
    }
}
