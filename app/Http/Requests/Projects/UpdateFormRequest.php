<?php

namespace App\Http\Requests\Projects;

use App\Http\Requests\BaseFormRequest;

/**
 * @OA\Schema(
 *     schema="UpdateFormRequest",
 *     required={"updated_by"},
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         example="Updated Project Name",
 *         description="The name of the project"
 *     ),
 *     @OA\Property(
 *         property="status",
 *         type="string",
 *         enum={"active", "completed", "planned"},
 *         example="active",
 *         description="Project status"
 *     ),
 *     @OA\Property(
 *         property="updated_by",
 *         type="integer",
 *         example=1,
 *         description="ID of the user who updated the project"
 *     ),
 *     @OA\Property(
 *         property="attributes",
 *         type="object",
 *         @OA\Property(
 *             property="id",
 *             type="integer",
 *             example=10,
 *             description="ID of the attribute"
 *         ),
 *         @OA\Property(
 *             property="value",
 *             type="string",
 *             example="Updated Attribute Value",
 *             description="Value of the attribute"
 *         )
 *     )
 * )
 */
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
            'updated_by' => 'required|exists:users,id',
            'attributes' => 'sometimes|array',
            'attributes.id' => 'sometimes|exists:attributes,id',
            'attributes.value' => 'sometimes|string|max:255',
        ];
    }
}
