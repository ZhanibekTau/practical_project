<?php

namespace App\Http\Controllers\Attribute;

use App\Exceptions\AppException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Projects\CreateFormRequest;
use App\Services\Projects\ProjectService;
use Illuminate\Http\JsonResponse;

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
     * @param CreateFormRequest $request
     *
     * @return JsonResponse
     * @throws AppException
     */
    public function create(CreateFormRequest $request): JsonResponse
    {
        $userId = ['user_id' => $request->header('User_id')];
        $params = array_merge($userId, $request->validated());

        $result = $this->projectService->create($params);

        return $this->response($result);
    }
}
