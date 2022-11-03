<?php

namespace App\Http\Requests;

use App\Models\PatientMedicalFile;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePatientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return PatientMedicalFile::$rules;
    }

    /**
     * @param array $keys
     * @return array
     */
    // public function all($keys = NULL): array
    // {
    //     $input = parent::all();
    //     if (!isset($input['parent_id']) || $input['parent_id'] == 0) {
    //         $input['parent_id'] = null;
    //     }
    //     return $input;
    // }
}
