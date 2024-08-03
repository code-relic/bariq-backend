<?php

namespace Modules\Auth\Http\Controllers;
use Modules\Users\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use OpenApi\Attributes as OA;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    #[OA\Post(
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
            new OA\Response(response: 200, description: "Login successful"),
            new OA\Response(response: 401, description: "Unauthorized"),
            new OA\Response(response: 403, description: "Forbidden"),
            new OA\Response(response: 422, description: "Unprocessable Entity")
        ]
    )]
    public function login(Request $request)
    {
        {
            // Define the validation rules
            $rules = [
                'email' => 'required|email',
                'password' => 'required|min:5|max:40',
            ];
    
            // Perform the validation
            $validator = Validator::make($request->all(), $rules);
    
            // Check if the validation fails
            if ($validator->fails()) {
                // Return a JSON response with validation errors
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }
    
            // Attempt to authenticate the user
            if (!Auth::attempt($request->only('email', 'password'))) {
                return response()->json([
                    'message' => 'Invalid email or password'
                ], 401);
            }
    
            // Regenerate session ID
            $request->session()->regenerate();

            
            $myUser=Auth::user();
            if(!$myUser->is_2fa_enabled){
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
    }

    /**
     * Show the form for creating a new resource.
     */
    public function register(Request $request)

    {
        // Define the validation rules
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email',
            'password' => 'required|min:5|max:40',
        ];

        // Perform the validation
        $validator = Validator::make($request->all(), $rules);

        // Check if the validation fails
        if ($validator->fails()) {
            // Return a JSON response with validation errors
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        // If validation passes, proceed with registration logic
        $validatedData = $validator->validated();

        // You can then create the user or perform other actions
        // For example:
        User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'is_2fa_enabled'=>false
        ]);

        // Return a success response
        return response()->json([
            'message' => 'User registered successfully',
            'data' => $validatedData
        ], 201);
    }
 
}
