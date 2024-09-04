<?php

namespace Modules\Projects\Http\Controllers;

use OpenApi\Attributes as OA;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Modules\Projects\Models\Tasks;
use Modules\Projects\Http\Requests\StoreTaskRequest;
use Modules\Projects\Models\Project;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('projects::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('projects::create');
    }

    /**
     * Store a newly created resource in storage.
     */
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
        Log::info(Project::find($validatedData["projects_id"])["teams_id"]);

        $validatedData["projects_teams_id"] = Project::find($validatedData["projects_id"])["teams_id"];
        Tasks::create($validatedData);

        return response()->json(['message' => 'Task created successfully'], 201);
    }
    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('projects::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('projects::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
