<?php

namespace App\Http\Requests\Projects;

use App\Http\Requests\BaseFormRequest;

/**
 * @OA\Schema(
 *     schema="CreateFormRequest",
 *     required={"name", "status", "created_by", "attributes"},
 *     @OA\Property(property="name", type="string", example="Project Name", description="The name of the project"),
 *     @OA\Property(
 *         property="status",
 *         type="string",
 *         enum={"active", "completed", "planned"},
 *         example="active",
 *         description="Project status"
 *     ),
 *     @OA\Property(
 *         property="created_by",
 *         type="integer",
 *         example=1,
 *         description="ID of the user who created the project"
 *     ),
 *     @OA\Property(
 *         property="attributes",
 *         type="object",
 *         required={"id", "value"},
 *         @OA\Property(
 *             property="id",
 *             type="integer",
 *             example=10,
 *             description="ID of the attribute"
 *         ),
 *         @OA\Property(
 *             property="value",
 *             type="string",
 *             example="Attribute Value",
 *             description="Value of the attribute"
 *         )
 *     ),
 *     @OA\Property(
 *         property="status_for_bank",
 *         type="string",
 *         example="DELIVERED",
 *         description="Status of the project for the bank"
 *     )
 * )
 */
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
            'status' => 'required|in:active,completed,planned',
            'created_by' => 'required|exists:users,id',
            'attributes' => 'required|array',
            'attributes.id' => 'required|exists:attributes,id',
            'attributes.value' => 'required|string|max:255',
        ];
    }
}
