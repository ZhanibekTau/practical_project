<?php

namespace App\Http\Requests\Attributes;

use App\Http\Requests\BaseFormRequest;

class CreateFormRequest extends BaseFormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'type' => 'required|in:text,date,number,select'
        ];
    }
}
