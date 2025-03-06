<?php

namespace App\Http\Requests\Projects;

use App\Http\Requests\BaseFormRequest;

class AddUserFormRequest extends BaseFormRequest
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
            'user_id' => 'required|exists:users,id',
            'project_id' => 'required|exists:projects,id',
        ];
    }
}
