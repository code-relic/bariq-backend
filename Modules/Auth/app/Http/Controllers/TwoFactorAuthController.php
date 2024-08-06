<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Auth\Models\TwoFactorMethods;
use OpenApi\Attributes as OA;

class TwoFactorAuthController extends Controller
{
    #[OA\Get(
        path: "/api/v1/auth/2fa",
        tags: ["auth", "2fa"],
        responses: [
            new OA\Response(response: 200, description: "OK", content: new OA\JsonContent()),
            new OA\Response(response: 401, description: "Unauthorized", content: new OA\JsonContent())
        ]
    )]
    
    public function GetMethods(){
        return TwoFactorMethods::all();
    }
}
