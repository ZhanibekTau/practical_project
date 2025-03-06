<?php

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Practical Project (API)",
 *      description="Service for practical use",
 *      @OA\ExternalDocumentation(
 *          description="GIT",
 *          url="https://github.com/ZhanibekTau/practical_project/blob/master/README.md"
 *      )
 * )
 * @OA\Tag(
 *     name="Practical project",
 *     description="API Endpoints of project"
 * )
 * @OA\SecurityScheme(
 *      securityScheme="BearerToken",
 *      type="http",
 *      scheme="passport laravel",
 *      bearerFormat="JWT",
 *      description="Enter 'Bearer' [space] and then your token. Example: 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...'"
 * )
 */
class MainController extends Controller
{

}
