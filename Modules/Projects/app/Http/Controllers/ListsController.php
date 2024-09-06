<?php

namespace Modules\Projects\Http\Controllers;

use OpenApi\Attributes as OA;
use App\Http\Controllers\Controller;
use Modules\Projects\Http\Requests\StoreListRequest;

use Modules\Projects\Transformers\ListResource;
use Illuminate\Http\Request;
use Modules\Projects\Models\Lists;

class ListsController extends Controller
{
    #[OA\Get(
        path: "/api/v1/projects/{project_id}/lists}",
        parameters: [
            new OA\Parameter(
                name: "project_id",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "string")
            ),
            new OA\Parameter(
                name: "list_id",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "string")
            ),
            new OA\Parameter(
                name: "per_page",
                in: "query",
                required: false,
                schema: new OA\Schema(type: "integer", default: 15)
            )
        ],
        tags: ["lists"],
        responses: [
            new OA\Response(
                response: 200,
                description: "List of resources",
                content: new OA\JsonContent()
            ),
            new OA\Response(response: 404, description: "Not Found")
        ]
    )]
    public function index(Request $request, $project_id, $list_id)
    {
        $perPage = $request->input('per_page', 15);
        $lists = Lists::where('projects_id', $project_id)
            ->where('id', $list_id)
            ->paginate($perPage);

        return response()->json(ListResource::collection($lists), 200);
    }

    #[OA\Post(
        path: "/api/v1/projects/{project_id}/lists",
        parameters: [
            new OA\Parameter(
                name: "project_id",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "string")
            )
        ],
        tags: ["lists"],
        requestBody: new OA\RequestBody(
            description: "Create a new list",
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "name", type: "string", nullable: true),
                    new OA\Property(property: "projects_teams_id", type: "string"),
                    new OA\Property(property: "views_id", type: "string")
                ],
                required: ["id", "projects_teams_id", "views_id"]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "List created successfully",
                content: new OA\JsonContent()
            ),
            new OA\Response(response: 422, description: "Unprocessable Entity")
        ]
    )]
    public function store(StoreListRequest $request, $project_id)
    {
        $list = Lists::create([
            'name' => $request->name ?? null,
            'projects_id' => $project_id,
            'projects_teams_id' => $request->projects_teams_id,
        ]);

        return response()->json(new ListResource($list), 201);
    }

    #[OA\Get(
        path: "/api/v1/projects/{project_id}/lists/{list_id}",
        parameters: [
            new OA\Parameter(
                name: "project_id",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "string")
            ),
            new OA\Parameter(
                name: "list_id",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "string")
            )
        ],
        tags: ["lists"],
        responses: [
            new OA\Response(
                response: 200,
                description: "List data",
                content: new OA\JsonContent()
            ),
            new OA\Response(response: 404, description: "Not Found")
        ]
    )]
    public function show($project_id, $list_id)
    {
        $list = Lists::where('id', $list_id)
            ->where('projects_id', $project_id)
            ->firstOrFail();

        return response()->json(new ListResource($list), 200);
    }

    #[OA\Put(
        path: "/api/v1/projects/{project_id}/lists/{list_id}",
        parameters: [
            new OA\Parameter(
                name: "project_id",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "string")
            ),
            new OA\Parameter(
                name: "list_id",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "string")
            )
        ],
        tags: ["lists"],
        requestBody: new OA\RequestBody(
            description: "Update list data",
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "name", type: "string", nullable: true),
                    new OA\Property(property: "projects_teams_id", type: "string"),
                    new OA\Property(property: "views_id", type: "string")
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "List updated successfully",
                content: new OA\JsonContent()
            ),
            new OA\Response(response: 422, description: "Unprocessable Entity"),
            new OA\Response(response: 404, description: "Not Found")
        ]
    )]
    public function update(Request $request, $project_id, $list_id)
    {
        $list = Lists::where('id', $list_id)
            ->where('projects_id', $project_id)
            ->firstOrFail();

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'projects_teams_id' => 'sometimes|integer|exists:teams,id',
            'views_id' => 'sometimes|integer|exists:views,id',
        ]);

        $list->update($validated);

        return response()->json(new ListResource($list), 200);
    }

    #[OA\Delete(
        path: "/api/v1/projects/{project_id}/lists/{list_id}",
        parameters: [
            new OA\Parameter(
                name: "project_id",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "string")
            ),
            new OA\Parameter(
                name: "list_id",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "string")
            )
        ],
        tags: ["lists"],
        responses: [
            new OA\Response(response: 200, description: "List deleted successfully"),
            new OA\Response(response: 404, description: "Not Found")
        ]
    )]
    public function destroy($project_id, $list_id)
    {
        $list = Lists::where('id', $list_id)
            ->where('projects_id', $project_id)
            ->firstOrFail();
        $list->delete();

        return response()->json(['message' => 'List deleted successfully'], 200);
    }
}
