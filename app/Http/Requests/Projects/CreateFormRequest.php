<?php

namespace App\Http\Requests\Projects;

use App\Http\Requests\BaseFormRequest;

class CreateFormRequest extends BaseFormRequest {
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
            'status' => 'required|in:active,completed,planned',
            'attributes' => 'required|array',
            'attributes.id' => 'required|exists:attributes,id',
            'attributes.value' => 'required|string|max:255',
        ];
    }
}
