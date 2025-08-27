<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function handleView(string $slug)
    {
        $menu = Menu::where('slug', $slug)->firstOrFail();
        $data['menu'] = $menu;

        switch ($menu->btn_link) {
            case 'viewer.upload.photo':
                return view('pages.viewer.upload.photo', $data);
            case 'viewer.upload.video':
                return view('pages.viewer.upload.video', $data);
            case 'viewer.upload.free':
                return view('pages.viewer.upload.free', $data);
            default:
                abort(404);
        }
    }

    public function handleUpload(Request $request, Order $order)
    {
        return \App\Services\UploadResultService::handle($request, $order);
    }
}
