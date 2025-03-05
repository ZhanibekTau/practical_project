<?php

namespace App\Services\Attributes;

use App\Exceptions\AppException;
use App\Repositories\Attributes\AttributeRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;

class AttributeService {
    protected AttributeRepository $attributeRepository;

    public function __construct(
        AttributeRepository $attributeRepository,
    ) {
        $this->attributeRepository = $attributeRepository;
    }

    /**
     * @param array $attributes
     *
     * @return Model
     * @throws AppException
     */
    public function firstOrCreate(array $attributes): Model
    {
        try {
            return $this->attributeRepository->firstOrCreate($attributes);
        } catch (\Exception $e) {
            throw new AppException(
                message:$e->getMessage(),
                code:Response::HTTP_BAD_REQUEST,
                errors: [
                    "line" => $e->getLine(),
                    "details" => $e->getTrace(),
                ]
            );
        }
    }

    /**
     * @param int   $id
     * @param array $attributes
     *
     * @return int
     * @throws AppException
     */
    public function updateById(int $id, array $attributes): int
    {
        try {
            return $this->attributeRepository->updateById($id, $attributes);
        } catch (\Exception $e) {
            throw new AppException(
                message:$e->getMessage(),
                code:Response::HTTP_BAD_REQUEST,
                errors: [
                    "line" => $e->getLine(),
                    "details" => $e->getTrace(),
                ]
            );
        }
    }
}
