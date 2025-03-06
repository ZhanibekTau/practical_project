<?php

namespace App\Repositories\Timesheets;

use App\Exceptions\AppException;
use App\Models\Timesheet;
use App\Repositories\Eloquent\IBaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;

class TimesheetsRepository implements IBaseRepository
{
    protected Timesheet $model;

    public function __construct(Timesheet $model)
    {
        $this->model = $model;
    }

    /**
     * @param array $attributes
     *
     * @return Timesheet
     */
    public function create(array $attributes): Timesheet
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
     * @return Timesheet|null
     */
    public function find(int $id): ?Timesheet
    {
        return $this->model->find($id)->first();
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        return $this->model->all()->toArray();
    }
}
