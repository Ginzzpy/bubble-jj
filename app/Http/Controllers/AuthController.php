<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function userLoginForm(Request $request)
    {
        return spaRender($request, 'Masuk/Daftar', 'layouts.auth.content', 'pages.auth.user');
    }

    public function adminLoginForm(Request $request)
    {
        return spaRender($request, 'Masuk/Daftar', 'layouts.auth.content', 'pages.auth.admin');
    }
}
