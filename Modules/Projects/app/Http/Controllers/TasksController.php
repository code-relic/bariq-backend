<?php

namespace Modules\Projects\Http\Controllers;

use OpenApi\Attributes as OA;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Modules\Projects\Models\Tasks;
use Modules\Projects\Http\Requests\StoreTaskRequest;
use Modules\Projects\Http\Requests\UpdateTasksRequest;
use Modules\Projects\Models\Project;

class TasksController extends Controller
{
    #[OA\Post(
        path: "/api/v1/projects/{id}/tasks",
        summary: "Create a new task for a project",
        description: "Creates a new task associated with a specific project",
        tags: ["Tasks"],
        security: [[new OA\SecurityScheme(
            securityScheme: "bearerAuth",
            type: "http",
            name: "Authorization",
            in: "header",
            scheme: "bearer"
        )]],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                description: "ID of the related project",
                schema: new OA\Schema(type: "integer")
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                type: "object",
                properties: [
                    new OA\Property(property: "title", type: "string", description: "Title of the task"),
                    new OA\Property(property: "description", type: "string", description: "Description of the task"),
                    new OA\Property(property: "docs", type: "file", description: "Documentation file"),
                    new OA\Property(property: "lists_id", type: "integer", description: "ID of the related list")
                ],
                required: ["title", "projects_teams_id"]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "Created",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "id", type: "string", description: "ULID of the created task"),
                        new OA\Property(property: "title", type: "string", description: "Title of the created task"),
                        new OA\Property(property: "description", type: "string", description: "Description of the created task"),
                        new OA\Property(property: "docs", type: "file", description: "Documentation file"),
                        new OA\Property(property: "lists_id", type: "integer", description: "ID of the related list")
                    ]
                )
            ),
            new OA\Response(response: 422, description: "Unprocessable Entity"),
            new OA\Response(response: 500, description: "Internal Server Error")
        ]
    )]
    public function store(StoreTaskRequest $request, $id)
    {
        $validatedData = $request->validated();
        $validatedData["projects_id"] = $id;

        $validatedData["projects_teams_id"] = Project::find($validatedData["projects_id"])["teams_id"];
        Tasks::create($validatedData);

        return response()->json(['message' => 'Task created successfully'], 201);
    }

    #[OA\Patch(
        path: "/api/v1/projects/{project_id}/tasks/{task_id}",
        summary: "Update a task",
        description: "Update a specific task within a project",
        operationId: "updateTask",
        tags: ["Tasks"],
        parameters: [
            new OA\Parameter(name: "project_id", in: "path", required: true, schema: new OA\Schema(format: "uuid")),
            new OA\Parameter(name: "task_id", in: "path", required: true, schema: new OA\Schema(format: "uuid"))
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(mediaType: "application/json", schema: new OA\Schema(
                properties: [
                    new OA\Property(property: "title", type: "string", maxLength: 255, nullable: true),
                    new OA\Property(property: "description", type: "string", maxLength: 1200, nullable: true),
                    new OA\Property(property: "start_date", type: "string", format: "date", nullable: true),
                    new OA\Property(property: "end_date", type: "string", format: "date", nullable: true),
                    new OA\Property(property: "docs", type: "string", maxLength: 2000, nullable: true)
                ]
            ))
        ),
        responses: [
            new OA\Response(response: 200, description: "Successful operation", content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "message", type: "string"),
                    new OA\Property(property: "success", type: "boolean")
                ]
            )),
            new OA\Response(response: 400, description: "Bad request", content: new OA\JsonContent()),
            new OA\Response(response: 401, description: "Unauthorized", content: new OA\JsonContent()),
            new OA\Response(response: 403, description: "Forbidden", content: new OA\JsonContent()),
            new OA\Response(response: 500, description: "Internal server error", content: new OA\JsonContent())
        ]
    )]
    public function update(UpdateTasksRequest $request, $_, $id)
    {
        $task = Tasks::findOrFail($id);

        $validatedData = $request->validated();

        $task->update($validatedData);
    }

    #[OA\Delete(
        path: "/api/v1/projects/{project_id}/tasks/{task_id}",
        summary: "Delete a task",
        description: "Delete a specific task within a project",
        operationId: "deleteTask",
        tags: ["Tasks"],
        parameters: [
            new OA\Parameter(name: "project_id", in: "path", required: true, schema: new OA\Schema(format: "uuid")),
            new OA\Parameter(name: "task_id", in: "path", required: true, schema: new OA\Schema(format: "uuid"))
        ],
        responses: [
            new OA\Response(response: 400, description: "Bad request", content: new OA\JsonContent()),
            new OA\Response(response: 401, description: "Unauthorized", content: new OA\JsonContent()),
            new OA\Response(response: 403, description: "Forbidden", content: new OA\JsonContent()),
            new OA\Response(response: 404, description: "Task not found", content: new OA\JsonContent()),
            new OA\Response(response: 500, description: "Internal server error", content: new OA\JsonContent())
        ]
    )]
    public function delete($_, $task)
    {
        Tasks::destroy($task);

        return response()->json([
            'message' => 'Task deleted successfully',
            'success' => true
        ], 200);
    }
}
