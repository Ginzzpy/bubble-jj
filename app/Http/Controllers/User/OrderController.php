<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\UploadMenu;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function handleView(Request $request, String $slug)
    {
        $menu = UploadMenu::where('slug', $slug)->firstOrFail();
        $data['menu'] = $menu;

        return spaRender($request, 'pages.user.order.' . $slug, $data);
    }
}
