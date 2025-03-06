<?php

namespace App\Services\Timesheets;

use App\Exceptions\AppException;
use App\Repositories\Timesheets\TimesheetRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;

class TimesheetService
{
    protected TimesheetRepository $timesheetsRepository;

    public function __construct(TimesheetRepository $timesheetsRepository)
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
     * @return Model|null
     * @throws AppException
     */
    public function getById(int $id): ?Model
    {
        try{
            return $this->timesheetsRepository->find($id);
        } catch (\Exception $e){
            throw new AppException($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
