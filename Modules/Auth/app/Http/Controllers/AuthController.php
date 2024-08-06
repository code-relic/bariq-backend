<?php

namespace Modules\Auth\Http\Controllers;

use Modules\Users\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Modules\Auth\Http\Requests\LoginRequest;
use Modules\Auth\Http\Requests\RegisterRequest;
use OpenApi\Attributes as OA;


class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    #[OA\Post(
        tags: ["auth"],
        parameters: [
            new OA\Parameter(ref: "#/components/parameters/Accept")
        ],
        path: "/api/v1/auth/login",
        requestBody: new OA\RequestBody(
            description: "User login data",
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "email", type: "string", format: "email"),
                    new OA\Property(property: "password", type: "string")
                ],
                required: ["email", "password"]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Login successful", content: new OA\JsonContent()),
            new OA\Response(response: 401, description: "Unauthorized", content: new OA\JsonContent()),
            new OA\Response(response: 403, description: "Forbidden", content: new OA\JsonContent()),
            new OA\Response(response: 422, description: "Unprocessable Entity", content: new OA\JsonContent())
        ]
    )]
    public function login(LoginRequest $request)
    {

        // Attempt to authenticate the user
        if (!Auth::attempt($request->safe()->only(['email', 'password']))) {
            return response()->json([
                'message' => 'Invalid email or password'
            ], 401);
        }

        // Regenerate session ID
        $request->session()->regenerate();


        if (Auth::user()->is_2fa_enabled) {
            return response()->json([
                'message' => 'Two-factor authentication required',
                '2fa_required' => true,
            ], 403); // Use 403 Forbidden status
        }
        // Return a success response
        return response()->json([
            'message' => 'Login successful',
        ]);
    }
    #[OA\Post(
        path: "/api/v1/auth/register",
        requestBody: new OA\RequestBody(
            description: "User data",
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "email", type: "string", format: "email"),
                    new OA\Property(property: "name", type: "string"),
                    new OA\Property(property: "password", type: "string", format: "password")
                ],
                required: ["email", "name", "password"]
            )
        ),
        parameters: [
            new OA\Parameter(ref: "#/components/parameters/Accept")
        ],
        tags: ["auth"],
        responses: [
            new OA\Response(response: 200, description: "OK", content: new OA\JsonContent()),
            new OA\Response(response: 422, description: "Unprocessable Entity", content: new OA\JsonContent())
        ]
    )]

    public function register(RegisterRequest $request)

    {

        $validated = $request->validated();

        // You can then create the user or perform other actions
        // For example:
        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'is_2fa_enabled' => false
        ]);

        // Return a success response
        return response()->json([
            'message' => 'User registered successfully',
            'data' => $validated
        ], 201);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
