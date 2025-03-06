<?php

namespace App\Http\Requests\Timesheets;

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
            'task_name' => 'required|string|max:255',
            'date' => 'required|string|max:255',
            'hours' => 'required|integer|between:1,60',
            'user_id' => 'required|integer|exists:users,id',
            'project_id' => 'required|exists:projects,id',
        ];
    }
}
