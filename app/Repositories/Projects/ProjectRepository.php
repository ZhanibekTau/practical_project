<?php

namespace App\Repositories\Projects;

use App\Enums\ProjectsEnum;
use App\Exceptions\AppException;
use App\Models\Project;
use App\Repositories\Eloquent\IBaseRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

class ProjectRepository implements IBaseRepository
{
    protected Project $model;

    public function __construct(Project $model)
    {
        $this->model = $model;
    }

    /**
     * @param array $requestData
     *
     * @return array
     */
    public function getProjects(array $requestData): array
    {
        $perPage = isset($requestData['per_page']) && $requestData['per_page'] === 'all'
            ? $this->model->count()
            : ($requestData['per_page'] ?? 30);
        $page = $requestData['page'] ?? 1;

        return $this->model
            ->paginate($perPage, ['*'], 'page', $page)
            ->load('attributes.attribute')
            ->toArray();
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

    /**
     * @param array $data
     *
     * @return mixed[]
     */
    public function filter(array $data): array
    {
        $query = $this->model->newQuery()
        ->select('projects.*');

        if (!empty($data[ProjectsEnum::REGULAR_COLUMNS])) {
            foreach ($data[ProjectsEnum::REGULAR_COLUMNS] as $column => $value) {
                if (is_array($value)) {
                    $operator = key($value);
                    $val = $value[$operator];
                    $query = $this->getBuilder($operator, $query, "projects.$column", $val);
                } else {
                    $query->where("projects.$column", '=', $value);
                }
            }
        }

        if (!empty($data[ProjectsEnum::EAV_COLUMNS])) {
            $query->join('attribute_values', 'attribute_values.entity_id', '=', 'projects.id');
            $query->join('attributes', 'attributes.id', '=', 'attribute_values.attribute_id');
            foreach ($data[ProjectsEnum::EAV_COLUMNS] as $column => $value) {
                $query->where('attributes.name', $column);

                if (is_array($value)) {
                    $operator = key($value);
                    $val = $value[$operator];
                    $query = $this->getBuilder($operator, $query, 'attribute_values.value', $val);
                } else {
                    $query->where('attribute_values.value', '=', $value);
                }
            }
        }

        return $query->with('attributes.attribute')->get()->toArray();
    }

    /**
     * @param array $data
     *
     * @return Model|null
     */
    public function attachUser(array $data): ?Model
    {
        $model = $this->find($data['project_id']);
        return $model->users()->attach($data['user_id'], [
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now(),
        ]);
    }

    /**
     * @param array $data
     *
     * @return int
     */
    public function detachUser(array $data): int
    {
        $model = $this->find($data['project_id']);
        return $model->users()->detach($data['user_id']);
    }

    /**
     * @param string  $operator
     * @param Builder $query
     * @param string  $column
     * @param mixed   $value
     *
     * @return Builder
     */
    private function getBuilder(string $operator, Builder $query, string $column, mixed $value): Builder {
        return match ($operator) {
            'eq' => $query->where($column, '=', $value),
            'gt' => $query->where($column, '>', $value),
            'lt' => $query->where($column, '<', $value),
            'gte' => $query->where($column, '>=', $value),
            'lte' => $query->where($column, '<=', $value),
            'ne' => $query->where($column, '!=', $value),
            'like' => $query->where($column, 'LIKE', '%' . $value . '%'),
            'in' => $query->whereIn($column, explode(',', $value)),
            default => $query,
        };
    }
}
