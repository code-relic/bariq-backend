<?php

namespace Modules\Projects\Http\Controllers;

use Modules\Projects\Models\Project;
use App\Http\Controllers\Controller;
use Modules\Projects\Http\Requests\CreateProjectRequest;
use Modules\Projects\Http\Requests\UpdateProjectRequest;
use OpenApi\Attributes as OA;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    #[OA\Get(
        path: "/api/v1/projects",
        tags: ["Projects"],
        summary: "Get all projects",
        parameters: [
            new OA\Parameter(
                name: "page",
                in: "query",
                required: false,
                schema: new OA\Schema(type: "integer", default: 1)
            ),
            new OA\Parameter(
                name: "per_page",
                in: "query",
                required: false,
                schema: new OA\Schema(type: "integer", default: 15)
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Successful operation",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: "data",
                            type: "array",
                            items: new OA\Items(
                                properties: [
                                    new OA\Property(property: "id", type: "integer"),
                                    new OA\Property(property: "name", type: "string"),
                                    new OA\Property(property: "teams_id", type: "integer")
                                ]
                            )
                        ),
                        new OA\Property(
                            property: "meta",
                            properties: [
                                new OA\Property(property: "current_page", type: "integer"),
                                new OA\Property(property: "last_page", type: "integer"),
                                new OA\Property(property: "per_page", type: "integer"),
                                new OA\Property(property: "total", type: "integer")
                            ],
                            type: "object"
                        )
                    ]
                )
            )
        ]
    )]
    public function index()
    {
        $projects = Project::paginate(15);
        return response()->json($projects);
    }
    #[OA\Post(
        path: "/api/v1/projects",
        tags: ["Projects"],
        summary: "Create a new project",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["name", "teams_id"],
                properties: [
                    new OA\Property(property: "name", type: "string"),
                    new OA\Property(property: "teams_id", type: "integer"),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "Project created successfully",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "message", type: "string"),
                        new OA\Property(property: "teams_id", type: "integer")
                    ]
                )
            )
        ]
    )]


    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProjectRequest $request)
    {
        $project = Project::create($request->validated());

        return response()->json([
            'message' => 'Project created successfully',
            'project' => $project,
        ], 201);
    }
    #[OA\Get(
        path: "/api/v1/projects/{id}",
        tags: ["Projects"],
        summary: "Get a project by ID",
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Successful operation",
                content: new OA\JsonContent(properties: [
                    new OA\Property(property: "id", type: "integer"),
                    new OA\Property(property: "name", type: "string"),
                    new OA\Property(property: "teams_id", type: "integer")
                ])
            ),
            new OA\Response(
                response: 404,
                description: "Project not found",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "message", type: "string")
                    ]
                )
            )
        ]
    )]

    public function show($id)
    {
        $project = Project::findOrFail($id);
        return response()->json($project);
    }

    #[OA\Patch(
        path: "/api/v1/projects/{id}",
        tags: ["Projects"],
        summary: "Update a project",
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["name", "teams_id"],
                properties: [
                    new OA\Property(property: "name", type: "string"),
                    new OA\Property(property: "teams_id", type: "integer"),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "Project updated successfully",
                content: new OA\JsonContent(properties: [
                    new OA\Property(property: "id", type: "integer"),
                    new OA\Property(property: "name", type: "string"),
                    new OA\Property(property: "teams_id", type: "integer")
                ])
            ),
            new OA\Response(
                response: 404,
                description: "Project not found",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "message", type: "string")
                    ]
                )
            )
        ]
    )]

    public function update(UpdateProjectRequest $request, $id)
    {
        $project = Project::findOrFail($id);
        $project->update($request->validated());
        return response()->json($project);
    }
    #[OA\Delete(
        path: "/api/v1/projects/{id}",
        tags: ["Projects"],
        summary: "Delete a project",
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 204,
                description: "Project deleted successfully"
            ),
            new OA\Response(
                response: 404,
                description: "Project not found",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "message", type: "string")
                    ]
                )
            )
        ]
    )]
    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();

        return response()->json(null, 204);
    }
}
