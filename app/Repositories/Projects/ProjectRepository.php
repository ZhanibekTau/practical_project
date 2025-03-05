<?php

namespace App\Repositories\Projects;

use App\Exceptions\AppException;
use App\Models\Project;
use App\Repositories\Eloquent\IBaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ProjectRepository implements IBaseRepository
{
    protected Project $model;

    public function __construct(Project $model)
    {
        $this->model = $model;
    }

    /**
     * @param $id
     *
     * @return Model|null
     */
    public function find($id): ?Model
    {
        return $this->model->find($id);
    }

    /**
     * @param array $data
     *
     * @return Model
     */
    public function firstOrCreate(array $data): Model
    {
        return DB::transaction(function () use ($data) {
            $model = $this->model->where('name', $data['name'])->first();

            if ($model) {
                return $model->load('attributes.attribute');
            }

            $model = $this->model->create($data);

            $attributeData = $data['attributes'];
            $attributeValues = [
                'attribute_id' => $attributeData['id'],
                'value' => $attributeData['value'] ?? null,
                'entity_id' => $model->id,
                'entity_type' => get_class($model),
            ];

            $model->attributeValues()->create($attributeValues);

            return $model->load('attributes.attribute');
        });
    }

    /**
     * @param int   $id
     * @param int   $attributeId
     * @param array $data
     *
     * @return Model
     */
    public function update(int $id, int $attributeId, array $data): Model
    {
        return DB::transaction(function () use ($id, $attributeId, $data) {
            $model = $this->find($id);
            if (!$model) {
                throw new AppException(
                    message: "Project with id: $id - not found",
                    code: Response::HTTP_UNPROCESSABLE_ENTITY,
                );
            }

            $model->update($data);

            // Update attribute values if an attribute ID is provided
            if ($attributeId != 0 && !empty($data['attributes'])) {
                $attributeData = $data['attributes'];

                $attributeValues = [
                    'attribute_id' => $attributeData['id'],
                    'value' => $attributeData['value'] ?? null,
                    'entity_id' => $model->id,
                    'entity_type' => get_class($model),
                ];

                $existingAttribute = $model->attributeValues()->where([
                    ['attribute_id', $attributeId],
                    ['entity_id', $model->id],
                ])->first();

                if (!$existingAttribute) {
                    $model->attributeValues()->create($attributeValues);
                }
            }

            return $model->load('attributes.attribute');
        });
    }
}
