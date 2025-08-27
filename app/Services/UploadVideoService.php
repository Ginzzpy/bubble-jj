<?php

namespace App\Services;

use App\Models\File;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Upload;
use getID3;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use RealRashid\SweetAlert\Facades\Alert;

class UploadVideoService
{
  public static function handle(Request $request, Menu $menu)
  {
    try {
      // Validasi
      $request->validate([
        'file'  => 'required|mimetypes:video/mp4,video/avi,video/mpeg,video/quicktime,video/x-ms-wmv|max:153600', // max 150MB
        'notes' => 'nullable|string',
      ]);

      // Insert order record
      $order = Order::create([
        'viewer_id' => Auth::guard('viewer')->id(),
        'menu_id'   => $menu->id,
        'notes'     => $request->notes,
      ]);

      // Upload file
      if ($request->hasFile('file')) {
        $file = $request->file('file');
        $path = $file->store('orders/videos', 'public');

        $getID3 = new getID3();
        $fileInfo = $getID3->analyze($file->getPathname());
        $duration = isset($fileInfo['playtime_seconds']) ? round($fileInfo['playtime_seconds']) : null;

        File::create([
          'order_id' => $order->id,
          'filename'  => $path,
          'size'      => $file->getSize(),
          'duration'  => $duration,
        ]);
      }

      // Success
      Alert::toast('Success! Silakan tunggu admin memproses..', 'success');
      return redirect()->route('viewer.upload', $menu->slug);
    } catch (ValidationException $e) {
      // Error Validasi
      $message = implode(', ', $e->validator->errors()->all());

      Alert::toast('Validasi gagal: ' . $message, 'error');
      return redirect()->back()->withInput();
    } catch (\Throwable $e) {
      // General Error
      Alert::toast('Terjadi kesalahan: ' . $e->getMessage(), 'error');
      return redirect()->back()->withInput();
    }
  }
}
