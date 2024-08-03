<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Auth\Models\TwoFactorMethods;

class TwoFactorAuthController extends Controller
{
    public function GetMethods(){
        return TwoFactorMethods::all();
    }
}
