<?php

namespace App\Http\Requests\Projects;

use App\Http\Requests\BaseFormRequest;

/**
 * @OA\Schema(
 *     schema="AddUserFormRequest",
 *     required={"user_id", "project_id"},
 *     @OA\Property(
 *         property="user_id",
 *         type="integer",
 *         example=1,
 *         description="ID of the user to be added to the project"
 *     ),
 *     @OA\Property(
 *         property="project_id",
 *         type="integer",
 *         example=10,
 *         description="ID of the project where the user will be added"
 *     )
 * )
 */
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
