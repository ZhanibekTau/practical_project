<?php

namespace App\Http\Requests\Timesheets;

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
            'task_name' => 'sometimes|string|max:255',
            'date' => 'sometimes|string|max:255',
            'hours' => 'sometimes|integer|between:1,60',
            'user_id' => 'sometimes|integer|exists:users,id',
            'project_id' => 'sometimes|exists:projects,id',
        ];
    }
}
