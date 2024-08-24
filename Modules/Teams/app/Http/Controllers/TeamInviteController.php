<?php

namespace Modules\Teams\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Teams\Models\Team;
use Modules\Teams\Models\TeamInvite;
use Modules\Teams\Http\Requests\AcceptTeamInviteRequest;
use Modules\Teams\Http\Requests\SendTeamInviteRequest;
use OpenApi\Attributes as OA;

class TeamInviteController extends Controller
{
    /**
     * Send a team invite.
     */
    #[OA\Post(
        tags: ["Teams"],
        path: "/api/v1/team-invites/invite",
        requestBody: new OA\RequestBody(
            description: "Send invite data",
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "team_id", type: "integer"),
                    new OA\Property(property: "recipient_id", type: "integer")
                ],
                required: ["team_id", "recipient_id"]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Invite sent successfully", content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "message", type: "string"),
                    new OA\Property(property: "invite", type: "object", additionalProperties: true)
                ]
            )),
            new OA\Response(response: 400, description: "Invalid input", content: new OA\JsonContent()),
            new OA\Response(response: 401, description: "Unauthorized", content: new OA\JsonContent())
        ]
    )]
    public function sendInvite(SendTeamInviteRequest $request)
    {
        $validated = $request->validated();

        $team = Team::findOrFail($validated["team_id"]);

        // Check if user in team member
        $isMember = $team->members()->where('user_id', $request->user()->id)->exists();

        if (!$isMember) {
            return response()->json(['error' => 'You are not a member of this team'], 403);
        }

        // Check if the invite already exists
        $existingInvite = TeamInvite::where('team_id', $request->team_id)
            ->where('recipient_id', $validated["recipient_id"])
            ->where('status', 'pending')
            ->first();

        if ($existingInvite) {
            return response()->json(['error' => 'An invite has already been sent to this user'], 409);
        }

        // Create the invite
        $invite = TeamInvite::create([
            'team_id' => $validated["team_id"],
            'sender_id' => Auth::user()->id,
            'recipient_id' => $validated["recipient_id"],
            'status' => 'pending',
        ]);

        return response()->json(['message' => 'Invite sent successfully', 'invite' => $invite], 201);
    }

    /**
     * Accept a team invite.
     */
    #[OA\Post(
        tags: ["Teams"],
        path: "/api/v1/team-invites/accept",
        requestBody: new OA\RequestBody(
            description: "Accept invite data",
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "invite_id", type: "integer")
                ],
                required: ["invite_id"]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Invite accepted successfully", content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "message", type: "string")
                ]
            )),
            new OA\Response(response: 400, description: "Invalid input", content: new OA\JsonContent()),
            new OA\Response(response: 401, description: "Unauthorized", content: new OA\JsonContent())
        ]
    )]    
    public function acceptInvite(AcceptTeamInviteRequest $request)
    {
        $validated = $request->validated();

        $invite = TeamInvite::findOrFail($validated["invite_id"]);

        // Ensure the invite is for the requesting user
        if (Auth::user()->id !== $invite->recipient_id) {
            return response()->json(['error' => 'You are not authorized to accept this invite'], 403);
        }

        // Ensure the invite is still pending
        if ($invite->status !== 'pending') {
            return response()->json(['error' => 'This invite is no longer valid'], 409);
        }

        // Accept the invite
        $invite->update(['status' => 'accepted']);

        // Add the user to the team
        $invite->team->members()->attach($invite->recipient_id);

        return response()->json(['message' => 'Invite accepted successfully'], 200);
    }
}
