<?php
/*
 * File name: CreateEServiceRequest.php
 * Last modified: 2021.06.10 at 20:38:02
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2021
 */

namespace App\Http\Requests;

use App\Models\EProvider;
use App\Models\EService;
use App\Models\EServiceType;
use http\Env\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use InfyOm\Generator\Utils\ResponseUtil;

class CreateEServiceRequest extends FormRequest
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

    private $fail = false;

public function prepareForValidation()
{
    if (isset($this->e_service_type_id)) {
        $id = $this->e_service_type_id;
        $provider_type = @EProvider::find($this->e_provider_id)->eProviderType;
        $provider_type = $provider_type->name;
        $this->merge(["provider_type"=>$provider_type]) ;
        if ($provider_type == "Doctor" && $this->e_service_type_id != 1) $this->fail = true;
        $ser = EServiceType::find($id);
         $p = isset($ser)?$ser->eProviders()->pluck("e_provider_id")->toarray():[];
         $e = Auth::user()->eProviders()->pluck("id")->toarray();
        if(isset($this->e_provider_id)) $e+=[$this->e_provider_id] ;
         if (count(array_intersect($p, $e))) $this->fail = true;
    }
}

    /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     * @return void
     *
     * @throws ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        if ($this->isJson()) {
            $errors = array_values($validator->errors()->getMessages());
            $errorsResponse = ResponseUtil::makeError($errors);
            throw new ValidationException($validator, response()->json($errorsResponse));
        } else {
            throw (new ValidationException($validator))
                ->errorBag($this->errorBag)
                ->redirectTo($this->getRedirectUrl());
        }

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $rules = EService::$rules;
        if ($this->fail)
            $rules["e_service_type_id"] = ['required', 'exists:e_service_types,id', function ($attribute, $value, $fail) {
                $fail(trans("validation.exists", [$attribute]));
            }];
        return $rules;
    }
}
