<?php

namespace Modules\Teams\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Teams\Http\Requests\CreateTeamRequest;
use Modules\Teams\Http\Requests\UpdateTeamRequest;
use Modules\Teams\Models\Team;

class TeamsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teams = Team::all();

        return response()->json($teams);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateTeamRequest $request)
    {
        $validated = $request->validated();

        $team = Team::create([
            "name" => $validated["name"],
            "owner_id"=> Auth::user()->id,
        ]);

        return response()->json($team, 201);
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $team = Team::findOrFail($id);

        return response()->json($team);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTeamRequest $request, $id)
    {
        $team = Team::findOrFail($id);
        $team->update($request->validated());

        return response()->json($team);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $team = Team::findOrFail($id);
        $team->delete();

        return response()->json(null, 204);
    }
}
