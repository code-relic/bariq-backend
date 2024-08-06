<?php

namespace Modules\Teams\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Teams\Http\Requests\CreateTeamRequest;
use Modules\Teams\Http\Requests\UpdateTeamRequest;
use Modules\Teams\Models\Team;
use OpenApi\Attributes as OA;

class TeamsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    #[OA\Get(
        tags: ["Teams"],
        path: "/api/v1/teams",
        parameters: [
            new OA\Parameter(
                name: "page",
                in: "query",
                description: "Page number for pagination",
                required: false,
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(response: 200, description: "Teams retrieved successfully", content: new OA\JsonContent()),
            new OA\Response(response: 401, description: "Unauthorized", content: new OA\JsonContent())
        ]
    )]
    public function index()
    {
        $teams = Team::paginate(15);

        return response()->json($teams);
    }

    /**
     * Store a newly created resource in storage.
     */
    #[OA\Post(
        tags: ["Teams"],
        path: "/api/v1/teams",
        requestBody: new OA\RequestBody(
            description: "Team data",
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "name", type: "string")
                ],
                required: ["name"]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: "Team created successfully", content: new OA\JsonContent()),
            new OA\Response(response: 422, description: "Unprocessable Entity", content: new OA\JsonContent()),
            new OA\Response(response: 401, description: "Unauthorized", content: new OA\JsonContent())
        ]
    )]
    public function store(CreateTeamRequest $request)
    {
        $validated = $request->validated();

        $team = Team::create([
            "name" => $validated["name"],
            "owner_id" => Auth::user()->id,
            "plans_id" => 0
        ]);

        return response()->json($team, 201);
    }

    /**
     * Show the specified resource.
     */
    #[OA\Get(
        tags: ["Teams"],
        path: "/api/v1/teams/{id}",
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                description: "ID of the team to retrieve",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(response: 200, description: "Team retrieved successfully", content: new OA\JsonContent()),
            new OA\Response(response: 404, description: "Team not found", content: new OA\JsonContent()),
            new OA\Response(response: 401, description: "Unauthorized", content: new OA\JsonContent())
        ]
    )]
    public function show($id)
    {
        $team = Team::findOrFail($id);

        return response()->json($team);
    }

    /**
     * Update the specified resource in storage.
     */
    #[OA\Patch(
        tags: ["Teams"],
        path: "/api/v1/teams/{id}",
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                description: "ID of the team to update",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        requestBody: new OA\RequestBody(
            description: "Team data to update",
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "name", type: "string")
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Team updated successfully", content: new OA\JsonContent()),
            new OA\Response(response: 422, description: "Unprocessable Entity", content: new OA\JsonContent()),
            new OA\Response(response: 401, description: "Unauthorized", content: new OA\JsonContent()),
            new OA\Response(response: 404, description: "Team not found", content: new OA\JsonContent()),
        ]
    )]
    public function update(UpdateTeamRequest $request, $id)
    {
        $team = Team::findOrFail($id);
        $team->update($request->validated());

        return response()->json($team);
    }

    /**
     * Remove the specified resource from storage.
     */
    #[OA\Delete(
        tags: ["Teams"],
        path: "/api/v1/teams/{id}",
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                description: "ID of the team to delete",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(response: 204, description: "Team deleted successfully"),
            new OA\Response(response: 404, description: "Team not found", content: new OA\JsonContent()),
            new OA\Response(response: 401, description: "Unauthorized", content: new OA\JsonContent())
        ]
    )]    
    public function destroy($id)
    {
        $team = Team::findOrFail($id);
        $team->delete();

        return response()->json(null, 204);
    }
}
