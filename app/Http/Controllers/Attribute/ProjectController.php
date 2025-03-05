<?php

namespace App\Http\Controllers\Attribute;

use App\Exceptions\AppException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Projects\UpdateFormRequest;
use App\Http\Requests\Projects\CreateFormRequest;
use App\Services\Projects\ProjectService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class ProjectController extends Controller
{
    /**
     * @param ProjectService $projectService
     */
    public function __construct(
        private ProjectService $projectService,
    ) {
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return $this->response($this->projectService->getAllProjects($request->all()));
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function filter(Request $request): JsonResponse
    {
        return $this->response($this->projectService->filterProjects($request->all()));
    }

    /**
     * @param CreateFormRequest $request
     *
     * @return JsonResponse
     * @throws AppException
     */
    public function create(CreateFormRequest $request): JsonResponse
    {
        $userId = ['created_by' => $request->header('User_id')];
        $params = array_merge($userId, $request->validated());

        $result = $this->projectService->create($params);

        return $this->response($result);
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
        $userId = ['updated_by' => $request->header('User_id')];
        $params = array_merge($userId, $request->validated());

        $result = $this->projectService->update($id, $params);

        return $this->response($result);
    }
}
