<?php

namespace App\Repositories\Projects;

use App\Models\Project;
use App\Repositories\Eloquent\IBaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProjectRepository implements IBaseRepository
{
    protected Project $model;

    public function __construct(Project $model)
    {
        $this->model = $model;
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
            $model->users()->attach($data['user_id'], [
                'created_at' => now(),
                'updated_at' => now(),
            ]);

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
}
