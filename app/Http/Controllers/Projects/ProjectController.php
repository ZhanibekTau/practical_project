<?php

namespace App\Http\Controllers\Projects;

use App\Exceptions\AppException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Projects\AddUserFormRequest;
use App\Http\Requests\Projects\CreateFormRequest;
use App\Http\Requests\Projects\UpdateFormRequest;
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
    ) {}

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return $this->response(
            $this->projectService->getAllProjects($request->all()),
        );
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function filter(Request $request): JsonResponse
    {
        return $this->response(
            $this->projectService->filterProjects($request->all()),
        );
    }

    /**
     * @param CreateFormRequest $request
     *
     * @return JsonResponse
     * @throws AppException
     */
    public function create(CreateFormRequest $request): JsonResponse
    {
        $result = $this->projectService->create($request->validated());

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
        $result = $this->projectService->update($id, $request->validated());

        return $this->response($result);
    }

    public function addUserToProject(AddUserFormRequest $request): JsonResponse
    {
        return $this->response($this->projectService->attachUser($request->validated()));
    }

    /**
     * @param AddUserFormRequest $request
     *
     * @return JsonResponse
     */
    public function deleteUserFromProject(AddUserFormRequest $request): JsonResponse
    {
        return $this->response($this->projectService->detachUser($request->validated()));
    }

}
