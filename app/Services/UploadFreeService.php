<?php

namespace App\Services;

use App\Models\DataJJ;
use App\Models\Menu;
use App\Models\Upload;
use getID3;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use RealRashid\SweetAlert\Facades\Alert;

class UploadFreeService
{
  public static function handle(Request $request, Menu $menu)
  {
    try {
      $request->validate([
        'file'  => 'required|mimetypes:video/mp4,video/avi,video/mpeg,video/quicktime,video/x-ms-wmv|max:2548', // max 2MB
        'notes' => 'nullable|string',
      ]);

      if ($request->hasFile('file')) {
        $file = $request->file('file');
        $getID3 = new getID3();
        $fileInfo = $getID3->analyze($file->getPathname());
        $duration = $fileInfo['playtime_seconds'] ?? 0;

        if ($duration > 60) {
          Alert::toast('Durasi video terlalu panjang. Maksimal 60 detik.', 'error');
          return redirect()->back()->withInput();
        }

        $path = $file->store('jj', 'public');

        DataJJ::create([
          'username1' => Auth::guard('viewer')->user()->username1,
          'username2' => Auth::guard('viewer')->user()->username2,
          'viewer_id'  => Auth::guard('viewer')->id(),
          'filename'   => $path,
          'duration'   => round($duration),
          'size'       => $file->getSize(),
          'sts_active' => true,
        ]);
      }

      Alert::toast('Video berhasil diupload!', 'success');
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
