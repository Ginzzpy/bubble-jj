<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminLoginController extends Controller
{
    public function loginForm(Request $request)
    {
        return spaRender($request, 'pages.auth.admin');
    }
}
