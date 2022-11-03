<?php
/*
 * File name: CategoryRepository.php
 * Last modified: 2021.01.31 at 14:03:57
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2021
 */

namespace App\Repositories;

use App\Models\PatientMedicalFile;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CategoryRepository
 * @package App\Repositories
 * @version January 19, 2021, 2:04 pm UTC
 *
 * @method Category findWithoutFail($id, $columns = ['*'])
 * @method Category find($id, $columns = ['*'])
 * @method Category first($columns = ['*'])
 */
class PatientMedicalRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'services',
        'diseases_suffers_from','married',
        'age','medications_takes',
        'file',
        'user_id',"history_operations",
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return PatientMedicalFile::class;
    }
}
