<?php

namespace App\Services\Timesheets;

use App\Exceptions\AppException;
use App\Repositories\Timesheets\TimesheetsRepository;
use Illuminate\Database\Eloquent\Model;

class TimesheetService
{
    protected TimesheetsRepository $timesheetsRepository;

    public function __construct(TimesheetsRepository $timesheetsRepository)
    {
        $this->timesheetsRepository = $timesheetsRepository;
    }

    /**
     * @param array $data
     *
     * @return Model
     */
    public function create(array $data): Model
    {
        return $this->timesheetsRepository->create($data);
    }

    /**
     * @param int   $id
     * @param array $data
     *
     * @return bool
     * @throws AppException
     */
    public function update(int $id, array $data): bool
    {
        return $this->timesheetsRepository->update($data, $id);
    }

    /**
     * @param int $id
     *
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->timesheetsRepository->delete($id);
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        return $this->timesheetsRepository->getAll();
    }

    /**
     * @param int $id
     *
     * @return Model
     */
    public function getById(int $id): Model
    {
        return $this->timesheetsRepository->find($id);
    }
}
