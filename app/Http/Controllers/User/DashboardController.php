<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\UploadMenu;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $data['menus'] = UploadMenu::rememberCache('menus_all', 3600, function () {
            return UploadMenu::all();
        });

        return spaRender($request, 'pages.user.dashboard', $data);
    }
}
