<?php

namespace App\Http\Requests\Projects;

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
            'status' => 'sometimes|in:active,completed,planned',
            'attributes' => 'sometimes|array',
            'attributes.id' => 'sometimes|exists:attributes,id',
            'attributes.value' => 'sometimes|string|max:255',
        ];
    }
}
