<?php

namespace App\Http\Controllers\Attribute;

use App\Exceptions\AppException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Attributes\CreateFormRequest;
use App\Http\Requests\Attributes\UpdateFormRequest;
use App\Services\Attributes\AttributeService;
use Illuminate\Http\JsonResponse;

class AttributeController extends Controller
{
    /**
     * @param AttributeService $attributeService
     */
    public function __construct(
        private AttributeService $attributeService,
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
        $params = $request->validated();
        $this->attributeService->firstOrCreate($params);

        return $this->response($params);
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
        $params = $request->validated();
        $this->attributeService->updateById($id, $params);

        return $this->response();
    }
}
