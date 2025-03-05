<?php

namespace App\Http\Requests;

use App\Exceptions\AppException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class BaseFormRequest extends FormRequest
{
    /**
     * @throws AppException
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->toArray();

        throw new AppException(
            __('validation.input_data_is_not_valid'),
            Response::HTTP_UNPROCESSABLE_ENTITY,
            null,
            $errors
        );
    }
}

