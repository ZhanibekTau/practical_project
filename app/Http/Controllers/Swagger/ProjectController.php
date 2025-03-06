<?php

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;

/**
 * @OA\Schema(
 *      schema="Project",
 *      type="object",
 *      title="Project Model",
 *      description="Project data",
 *      required={"id", "name"},
 *      @OA\Property(
 *          property="id",
 *          type="integer",
 *          example=1,
 *          description="Project ID"
 *      ),
 *      @OA\Property(
 *          property="name",
 *          type="string",
 *          example="My First Project",
 *          description="Project name"
 *      ),
 *      @OA\Property(
 *          property="description",
 *          type="string",
 *          example="This is a sample project",
 *          description="Project description"
 *      ),
 *      @OA\Property(
 *          property="created_at",
 *          type="string",
 *          format="date-time",
 *          example="2023-10-01T12:00:00Z",
 *          description="Creation timestamp"
 *      ),
 *      @OA\Property(
 *          property="updated_at",
 *          type="string",
 *          format="date-time",
 *          example="2023-10-02T15:30:00Z",
 *          description="Last update timestamp"
 *      )
 *  ),
 *
 * @OA\Get(
 *       path="/practical_project/api/projects",
 *       tags={"Projects"},
 *       summary="Get list of all projects",
 *       security={{"BearerToken":{}}},
 *       @OA\Parameter(
 *           name="page",
 *           in="query",
 *           description="Page number for pagination",
 *           required=false,
 *           @OA\Schema(type="integer", example=1)
 *       ),
 *       @OA\Parameter(
 *           name="per_page",
 *           in="query",
 *           description="Number of items per page (or 'all' to fetch all items)",
 *           required=false,
 *           @OA\Schema(type="string", example="10", enum={"10", "20", "50", "100", "all"})
 *       ),
 *       @OA\Response(
 *            response=200,
 *            description="Success",
 *            @OA\JsonContent(
 *                @OA\Property(property="message", type="string", example="Success"),
 *                @OA\Property(property="status", type="integer", example=200),
 *                @OA\Property(
 *                    property="data",
 *                    type="array",
 *                    @OA\Items(
 *                        @OA\Property(property="id", type="integer", example=2),
 *                        @OA\Property(property="name", type="string", example="Samsung"),
 *                        @OA\Property(property="status", type="string", example="planned"),
 *                        @OA\Property(property="created_by", type="integer", example=1),
 *                        @OA\Property(property="updated_by", type="integer", nullable=true, example=1),
 *                        @OA\Property(property="created_at", type="string", format="date-time", example="2025-03-05T14:34:15.000000Z"),
 *                        @OA\Property(property="updated_at", type="string", format="date-time", example="2025-03-05T14:58:43.000000Z"),
 *                        @OA\Property(
 *                            property="attributes",
 *                            type="array",
 *                            @OA\Items(
 *                                @OA\Property(property="id", type="integer", example=2),
 *                                @OA\Property(property="attribute_id", type="integer", example=1),
 *                                @OA\Property(property="entity_type", type="string", example="App\\Models\\Project"),
 *                                @OA\Property(property="entity_id", type="integer", example=2),
 *                                @OA\Property(property="value", type="string", example="2025-10-29"),
 *                                @OA\Property(property="created_at", type="string", format="date-time", example="2025-03-05T14:34:15.000000Z"),
 *                                @OA\Property(property="updated_at", type="string", format="date-time", example="2025-03-05T14:34:15.000000Z"),
 *                                @OA\Property(
 *                                    property="attribute",
 *                                    type="object",
 *                                    @OA\Property(property="id", type="integer", example=1),
 *                                    @OA\Property(property="name", type="string", example="start_date"),
 *                                    @OA\Property(property="type", type="string", example="date"),
 *                                    @OA\Property(property="created_at", type="string", format="date-time", example="2025-03-05T14:33:13.000000Z"),
 *                                    @OA\Property(property="updated_at", type="string", format="date-time", example="2025-03-05T14:33:13.000000Z")
 *                               )
 *                           )
 *                       )
 *                   )
 *              )
 *          )
 *      ),
 *
 *       @OA\Response(
 *           response=400,
 *           description="Invalid parameters",
 *           @OA\JsonContent(
 *               @OA\Property(property="message", type="string", example="Invalid pagination parameters")
 *           )
 *       )
 *  ),
 *
 * @OA\Get(
 *       path="/practical_project/api/projects/filter",
 *       tags={"Projects"},
 *       summary="Filter projects by attributes",
 *       description="Filter projects using EAV attributes with various comparison operators such as eq, gt, lt, gte, lte, ne, like, in.",
 *       @OA\Parameter(
 *           name="filters[name][like]",
 *           in="query",
 *           description="Filter projects by name using 'LIKE' operator. Example: filters[name][like]=HP",
 *           required=false,
 *           @OA\Schema(type="string", example="HP")
 *       ),
 *       @OA\Parameter(
 *           name="filters[status][eq]",
 *           in="query",
 *           description="Exact match for status. Example: filters[status][eq]=active",
 *           required=false,
 *           @OA\Schema(type="string", example="active")
 *       ),
 *       @OA\Parameter(
 *           name="filters[id][gt]",
 *           in="query",
 *           description="Filter by ID greater than a value. Example: filters[id][gt]=10",
 *           required=false,
 *           @OA\Schema(type="integer", example=10)
 *       ),
 *       @OA\Parameter(
 *           name="filters[created_at][lte]",
 *           in="query",
 *           description="Filter by created_at date less than or equal to a specific date. Example: filters[created_at][lte]=2024-01-01",
 *           required=false,
 *           @OA\Schema(type="string", format="date", example="2024-01-01")
 *       ),
 *       @OA\Parameter(
 *           name="filters[category][in]",
 *           in="query",
 *           description="Filter by category in a list. Example: filters[category][in]=IT,Finance,Marketing",
 *           required=false,
 *           @OA\Schema(type="string", example="IT,Finance,Marketing")
 *       ),
 *       @OA\Response(
 *             response=200,
 *             description="Success",
 *             @OA\JsonContent(
 *                 @OA\Property(property="message", type="string", example="Success"),
 *                 @OA\Property(property="status", type="integer", example=200),
 *                 @OA\Property(
 *                     property="data",
 *                     type="array",
 *                     @OA\Items(
 *                         @OA\Property(property="id", type="integer", example=2),
 *                         @OA\Property(property="name", type="string", example="Samsung"),
 *                         @OA\Property(property="status", type="string", example="planned"),
 *                         @OA\Property(property="created_by", type="integer", example=1),
 *                         @OA\Property(property="updated_by", type="integer", nullable=true, example=1),
 *                         @OA\Property(property="created_at", type="string", format="date-time", example="2025-03-05T14:34:15.000000Z"),
 *                         @OA\Property(property="updated_at", type="string", format="date-time", example="2025-03-05T14:58:43.000000Z"),
 *                         @OA\Property(
 *                             property="attributes",
 *                             type="array",
 *                             @OA\Items(
 *                                 @OA\Property(property="id", type="integer", example=2),
 *                                 @OA\Property(property="attribute_id", type="integer", example=1),
 *                                 @OA\Property(property="entity_type", type="string", example="App\\Models\\Project"),
 *                                 @OA\Property(property="entity_id", type="integer", example=2),
 *                                 @OA\Property(property="value", type="string", example="2025-10-29"),
 *                                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-03-05T14:34:15.000000Z"),
 *                                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-03-05T14:34:15.000000Z"),
 *                                 @OA\Property(
 *                                     property="attribute",
 *                                     type="object",
 *                                     @OA\Property(property="id", type="integer", example=1),
 *                                     @OA\Property(property="name", type="string", example="start_date"),
 *                                     @OA\Property(property="type", type="string", example="date"),
 *                                     @OA\Property(property="created_at", type="string", format="date-time", example="2025-03-05T14:33:13.000000Z"),
 *                                     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-03-05T14:33:13.000000Z")
 *                                )
 *                            )
 *                        )
 *                    )
 *               )
 *           )
 *       ),
 *       @OA\Response(
 *           response=400,
 *           description="Invalid filter parameters",
 *           @OA\JsonContent(
 *               @OA\Property(property="message", type="string", example="Invalid filter operator provided")
 *           )
 *       )
 *  ),
 *
 *
 * @OA\Post(
 *       path="/practical_project/api/projects",
 *       tags={"Projects"},
 *       summary="Create a new project",
 *       @OA\RequestBody(
 *           required=true,
 *           @OA\JsonContent(ref="#/components/schemas/CreateFormRequest")
 *       ),
 *       @OA\Response(
 *              response=200,
 *              description="Success",
 *              @OA\JsonContent(
 *                  @OA\Property(property="message", type="string", example="Success"),
 *                  @OA\Property(property="status", type="integer", example=200),
 *                  @OA\Property(
 *                      property="data",
 *                      type="array",
 *                      @OA\Items(
 *                          @OA\Property(property="id", type="integer", example=2),
 *                          @OA\Property(property="name", type="string", example="Samsung"),
 *                          @OA\Property(property="status", type="string", example="planned"),
 *                          @OA\Property(property="created_by", type="integer", example=1),
 *                          @OA\Property(property="updated_by", type="integer", nullable=true, example=1),
 *                          @OA\Property(property="created_at", type="string", format="date-time", example="2025-03-05T14:34:15.000000Z"),
 *                          @OA\Property(property="updated_at", type="string", format="date-time", example="2025-03-05T14:58:43.000000Z"),
 *                          @OA\Property(
 *                              property="attributes",
 *                              type="array",
 *                              @OA\Items(
 *                                  @OA\Property(property="id", type="integer", example=2),
 *                                  @OA\Property(property="attribute_id", type="integer", example=1),
 *                                  @OA\Property(property="entity_type", type="string", example="App\\Models\\Project"),
 *                                  @OA\Property(property="entity_id", type="integer", example=2),
 *                                  @OA\Property(property="value", type="string", example="2025-10-29"),
 *                                  @OA\Property(property="created_at", type="string", format="date-time", example="2025-03-05T14:34:15.000000Z"),
 *                                  @OA\Property(property="updated_at", type="string", format="date-time", example="2025-03-05T14:34:15.000000Z"),
 *                                  @OA\Property(
 *                                      property="attribute",
 *                                      type="object",
 *                                      @OA\Property(property="id", type="integer", example=1),
 *                                      @OA\Property(property="name", type="string", example="start_date"),
 *                                      @OA\Property(property="type", type="string", example="date"),
 *                                      @OA\Property(property="created_at", type="string", format="date-time", example="2025-03-05T14:33:13.000000Z"),
 *                                      @OA\Property(property="updated_at", type="string", format="date-time", example="2025-03-05T14:33:13.000000Z")
 *                                 )
 *                             )
 *                         )
 *                     )
 *                )
 *            )
 *        ),
 *   ),
 *
 * @OA\Delete(
 *       path="/practical_project/api/projects/delete-user",
 *       tags={"Projects"},
 *       summary="Delete a user from a project",
 *       description="Remove a user from a specific project by providing the user and project IDs.",
 *       @OA\RequestBody(
 *           required=true,
 *           @OA\JsonContent(ref="#/components/schemas/AddUserFormRequest")
 *       ),
 *       @OA\Response(
 *           response=200,
 *           description="User deleted from project successfully",
 *           @OA\JsonContent(
 *               @OA\Property(property="message", type="string", example="User deleted from project successfully.")
 *           )
 *       ),
 *       @OA\Response(
 *           response=404,
 *           description="User or project not found",
 *           @OA\JsonContent(
 *               @OA\Property(property="message", type="string", example="User or project not found.")
 *           )
 *       ),
 *       @OA\Response(
 *           response=422,
 *           description="Validation failed",
 *           @OA\JsonContent(
 *               @OA\Property(property="message", type="string", example="Validation errors."),
 *               @OA\Property(property="errors", type="object")
 *           )
 *       )
 *  ),
 *
 * @OA\Put(
 *       path="/practical_project/api/projects/{id}",
 *       tags={"Projects"},
 *       summary="Update a project",
 *       @OA\Parameter(
 *           name="id",
 *           in="path",
 *           required=true,
 *           @OA\Schema(type="integer")
 *       ),
 *       @OA\RequestBody(
 *           required=true,
 *           @OA\JsonContent(ref="#/components/schemas/UpdateFormRequest")
 *       ),
 *      @OA\Response(
 *              response=200,
 *              description="Success",
 *              @OA\JsonContent(
 *                  @OA\Property(property="message", type="string", example="Success"),
 *                  @OA\Property(property="status", type="integer", example=200),
 *                  @OA\Property(
 *                      property="data",
 *                      type="array",
 *                      @OA\Items(
 *                          @OA\Property(property="id", type="integer", example=2),
 *                          @OA\Property(property="name", type="string", example="Samsung"),
 *                          @OA\Property(property="status", type="string", example="planned"),
 *                          @OA\Property(property="created_by", type="integer", example=1),
 *                          @OA\Property(property="updated_by", type="integer", nullable=true, example=1),
 *                          @OA\Property(property="created_at", type="string", format="date-time", example="2025-03-05T14:34:15.000000Z"),
 *                          @OA\Property(property="updated_at", type="string", format="date-time", example="2025-03-05T14:58:43.000000Z"),
 *                          @OA\Property(
 *                              property="attributes",
 *                              type="array",
 *                              @OA\Items(
 *                                  @OA\Property(property="id", type="integer", example=2),
 *                                  @OA\Property(property="attribute_id", type="integer", example=1),
 *                                  @OA\Property(property="entity_type", type="string", example="App\\Models\\Project"),
 *                                  @OA\Property(property="entity_id", type="integer", example=2),
 *                                  @OA\Property(property="value", type="string", example="2025-10-29"),
 *                                  @OA\Property(property="created_at", type="string", format="date-time", example="2025-03-05T14:34:15.000000Z"),
 *                                  @OA\Property(property="updated_at", type="string", format="date-time", example="2025-03-05T14:34:15.000000Z"),
 *                                  @OA\Property(
 *                                      property="attribute",
 *                                      type="object",
 *                                      @OA\Property(property="id", type="integer", example=1),
 *                                      @OA\Property(property="name", type="string", example="start_date"),
 *                                      @OA\Property(property="type", type="string", example="date"),
 *                                      @OA\Property(property="created_at", type="string", format="date-time", example="2025-03-05T14:33:13.000000Z"),
 *                                      @OA\Property(property="updated_at", type="string", format="date-time", example="2025-03-05T14:33:13.000000Z")
 *                                 )
 *                             )
 *                         )
 *                     )
 *                )
 *            )
 *        ),
 *   ),
 *
 * @OA\Post(
 *        path="/practical_projectapi/projects/add-user",
 *        tags={"Projects"},
 *        summary="Add a user to a project",
 *        @OA\RequestBody(
 *            required=true,
 *            @OA\JsonContent(ref="#/components/schemas/AddUserFormRequest")
 *        ),
 *        @OA\Response(
 *            response=200,
 *            description="User added to project successfully"
 *        )
 *    )
 */
class ProjectController extends Controller
{

}
