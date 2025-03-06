<?php

namespace App\Http\Controllers\Timesheets;

use App\Exceptions\AppException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Timesheets\CreateFormRequest;
use App\Http\Requests\Timesheets\UpdateFormRequest;
use App\Services\Timesheets\TimesheetService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TimesheetController extends Controller
{
    /**
     * @param TimesheetService $timesheetService
     */
    public function __construct(
        private TimesheetService $timesheetService,
    ) {

    }

    /**
     * @param CreateFormRequest $request
     *
     * @return JsonResponse
     */
    public function create(CreateFormRequest $request): JsonResponse
    {
       return $this->response($this->timesheetService->create($request->validated()));
    }

    /**
     * @param UpdateFormRequest $request
     * @param int               $id
     *
     * @return JsonResponse
     * @throws AppException
     */
    public function update(UpdateFormRequest $request, int $id): JsonResponse
    {
        return $this->response($this->timesheetService->update($id,$request->validated()));
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        return $this->response($this->timesheetService->delete($id));
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return $this->response($this->timesheetService->getAll());
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     * @throws AppException
     */
    public function show(int $id): JsonResponse
    {
        return $this->response($this->timesheetService->getById($id));
    }
}
