<?php

namespace App\Repositories\Timesheets;

use App\Exceptions\AppException;
use App\Models\Timesheet;
use App\Repositories\Eloquent\IBaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;

class TimesheetRepository implements IBaseRepository
{
    protected Timesheet $model;

    public function __construct(Timesheet $model)
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
     * @param array $attributes
     * @param int   $id
     *
     * @return bool
     * @throws AppException
     */
    public function update(array $attributes, int $id): bool
    {
        $model = $this->find($id);
        if (!$model) {
            throw new AppException(
                message: "Project with id: $id - not found",
                code: Response::HTTP_UNPROCESSABLE_ENTITY,
            );
        }

        return $model->update($attributes);
    }

    /**
     * @param int $id
     *
     * @return int
     */
    public function delete(int $id): int
    {
        return $this->model->destroy($id);
    }

    /**
     * @param int $id
     *
     * @return Model|null
     */
    public function find(int $id): ?Model
    {
        return $this->model->find($id);
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        return $this->model->all()->toArray();
    }
}
