<?php

namespace App\Services\Projects;

use App\Enums\AttributesEnum;
use App\Enums\ProjectsEnum;
use App\Exceptions\AppException;
use App\Repositories\Attributes\AttributeRepository;
use App\Repositories\Projects\ProjectRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;

class ProjectService
{
    protected ProjectRepository $projectRepository;
    protected AttributeRepository $attributeRepository;

    public function __construct(
        ProjectRepository $projectRepository,
        AttributeRepository $attributeRepository,
    ) {
        $this->projectRepository = $projectRepository;
        $this->attributeRepository = $attributeRepository;
    }

    /**
     * @param array $requestData
     *
     * @return array
     */
    public function getAllProjects(array $requestData): array
    {
        return $this->projectRepository->getProjects($requestData);
    }

    /**
     * @param array $requestData
     *
     * @return mixed[]
     */
    public function filterProjects(array $requestData): array
    {
        $data = $this->getEavAttributes($requestData);

        return $this->projectRepository->filter($data);
    }

    /**
     * @param array $data
     *
     * @return Model
     * @throws AppException
     */
    public function create(array $data): Model
    {
        try {
            $attributeData = $data['attributes'];
            $attributeId = $attributeData['id'];

            $this->validateAttributeValue($attributeId, $attributeData['value']);

            return $this->projectRepository->firstOrCreate($data);
        } catch (\Exception $e) {
            throw new AppException(
                message:$e->getMessage(),
                code:Response::HTTP_BAD_REQUEST,
                errors: [
                    "line" => $e->getLine(),
                    "details" => $e->getTrace(),
                ],
            );
        }
    }

    /**
     * @param int   $id
     * @param array $data
     *
     * @return Model
     * @throws AppException
     */
    public function update(int $id, array $data): Model
    {
        try {
            $attributeId = 0;

            if ($data['attributes']) {
                $attributeData = $data['attributes'];

                $attributeId = $attributeData['id'];
                $value = $attributeData['value'] ?? null;

                $this->validateAttributeValue($attributeId, $value);
            }

            return $this->projectRepository->update($id, $attributeId, $data);
        } catch (\Exception $e) {
            throw new AppException(
                message:$e->getMessage(),
                code:Response::HTTP_BAD_REQUEST,
                errors: [
                    "line" => $e->getLine(),
                    "details" => $e->getTrace(),
                ],
            );
        }
    }

    /**
     * @param int         $attributeId
     * @param string|null $value
     *
     * @return void
     * @throws AppException
     */
    private function validateAttributeValue(int $attributeId, ?string $value): void
    {
        $attribute = $this->attributeRepository->find($attributeId);
        if (!$attribute) {
            throw new AppException(
                message: "Attribute with id: $attributeId - not found",
                code: Response::HTTP_UNPROCESSABLE_ENTITY,
            );
        }
        if ($value === null) {
            return;
        }

        switch ($attribute->type) {
            case AttributesEnum::TEXT_TYPE:
                if (!is_string($value) || is_numeric($value) || strlen($value) > 255) {
                    throw new AppException(
                        message: "Invalid value for 'text' type attribute",
                        code: Response::HTTP_UNPROCESSABLE_ENTITY,
                    );
                }
                break;

            case AttributesEnum::DATE_TYPE:
                $format = 'Y-m-d';
                $date = \DateTime::createFromFormat($format, $value);
                if (!$date || $date->format($format) !== $value) {
                    throw new AppException(
                        message: "Invalid date format. Expected format: $format",
                        code: Response::HTTP_UNPROCESSABLE_ENTITY,
                    );
                }
                break;

            case AttributesEnum::NUMBER_TYPE:
                if (!is_numeric($value)) {
                    throw new AppException(
                        message: "Invalid value for 'number' type attribute",
                        code: Response::HTTP_UNPROCESSABLE_ENTITY,
                    );
                }
                break;

            case AttributesEnum::SELECT_TYPE:
                if (!in_array($value, AttributesEnum::ACCEPTED_SELECT_TYPES, true)) {
                    throw new AppException(
                        message: "Invalid value for 'select' type attribute. Allowed values: " . implode(', ', AttributesEnum::ACCEPTED_SELECT_TYPES),
                        code: Response::HTTP_UNPROCESSABLE_ENTITY,
                    );
                }
                break;

            default:
                throw new AppException(
                    message: "Unsupported attribute type: $attribute->type",
                    code: Response::HTTP_UNPROCESSABLE_ENTITY,
                );
        }
    }

    /**
     * @param array $requestData
     *
     * @return array
     */
    private function getEavAttributes(array $requestData): array
    {
        $eavAttributes = $this->attributeRepository->getAll()->pluck('name')->toArray();
        $data = [];

        foreach ($requestData["filters"] as $key => $value) {
            if(in_array($key, $eavAttributes)) {
                $data[ProjectsEnum::EAV_COLUMNS][$key] = $value;
            } else {
                $data[ProjectsEnum::REGULAR_COLUMNS][$key] = $value;
            }
        }

        return $data;
    }

    /**
     * @param array $data
     *
     * @return Model|null
     */
    public function attachUser(array $data): ?Model
    {
        return $this->projectRepository->attachUser($data);
    }

    /**
     * @param array $data
     *
     * @return int
     */
    public function detachUser(array $data): int
    {
        return $this->projectRepository->detachUser($data);
    }
}
