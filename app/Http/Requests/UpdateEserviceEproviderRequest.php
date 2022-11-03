<?php

namespace App\Http\Requests;

use App\Models\EService;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\EproviderEservice;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use InfyOm\Generator\Utils\ResponseUtil;

class UpdateEserviceEproviderRequest extends FormRequest
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

    public function prepareForValidation()
    {
        $lists = $this->List_Classes;
        foreach ($this->List_Classes as $key => $item) {
            if (isset($lists[$key]["featured"])) $lists[$key]["featured"] = $item ["featured"] [0];
            if (isset($lists[$key]["enable_booking"])) $lists[$key]["enable_booking"] = $item ["enable_booking"] [0];
            if (isset($lists[$key]["available"])) $lists[$key]["available"] = $item ["available"] [0];
        }
        $this->merge(["List_Classes" => $lists]);

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
        $att = [];
        foreach ($rules as $item => $value) {
            $att['List_Classes.*.' . $item] = $value;
        }
        return $att;

    }
}
