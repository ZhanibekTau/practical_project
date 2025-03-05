<?php

namespace App\Repositories\Attributes;

use App\Exceptions\AppException;
use App\Models\Attribute;
use App\Repositories\Eloquent\IBaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;

class AttributeRepository implements IBaseRepository {
    protected Attribute $model;

    /**
     * @param Attribute $model
     */
    public function __construct(Attribute $model)
    {
        $this->model = $model;
    }

    /**
     * @param array $attributes
     *
     * @return Model
     */
    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
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
     * @param array $attributes
     *
     * @return Model
     */
    public function firstOrCreate(array $attributes): Model
    {
        return $this->model->firstOrCreate([
            'name' => $attributes['name'],
            'type' => $attributes['type'],
        ], $attributes);
    }

    /**
     * @param int   $id
     * @param array $data
     *
     * @return int
     */
    public function updateById(int $id, array $data): int
    {
        $model = $this->model->find($id);
        if (empty($model)) {
            throw new AppException(
                message: "model with id: $id - not found",
            );
        }

        return $model->update($data);
    }
}
