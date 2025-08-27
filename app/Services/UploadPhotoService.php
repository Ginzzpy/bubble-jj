<?php

namespace App\Services;

use App\Models\File;
use App\Models\Menu;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use RealRashid\SweetAlert\Facades\Alert;

class UploadPhotoService
{
  public static function handle(Request $request, Menu $menu)
  {
    try {
      // Validasi
      $request->validate([
        'files'   => 'required|array|min:1',
        'files.*' => 'image',
        'notes'   => 'nullable|string',
      ]);

      // Insert upload record
      $order = Order::create([
        'viewer_id' => Auth::guard('viewer')->id(),
        'menu_id'   => $menu->id,
        'notes'     => $request->notes,
      ]);

      // Upload file
      if ($request->hasFile('files')) {
        foreach ($request->file('files') as $file) {
          $path = $file->store('orders/photos', 'public');

          File::create([
            'order_id' => $order->id,
            'filename'  => $path,
            'size'      => $file->getSize(),
            'duration'  => null,
          ]);
        }
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
