<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return response()->json([
                'title' => 'Dashboard',
                'content' => view('pages.admin.dashboard')->render()
            ]);
        } else {
            $data['view'] = 'pages.admin.dashboard';
            return view('layouts.content', $data);
        }
    }
}
