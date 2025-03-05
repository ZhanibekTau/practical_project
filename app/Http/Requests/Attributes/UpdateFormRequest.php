<?php

namespace App\Http\Requests\Attributes;

use App\Http\Requests\BaseFormRequest;

class UpdateFormRequest extends BaseFormRequest
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
            'name' => 'sometimes|string|max:255',
            'type' => 'sometimes|in:text,date,number,select'
        ];
    }
}
