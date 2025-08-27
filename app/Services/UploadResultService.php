<?php

namespace App\Services;

use App\Models\DataJJ;
use App\Models\Order;
use getID3;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use RealRashid\SweetAlert\Facades\Alert;

class UploadResultService
{
  public static function handle(Request $request, Order $order)
  {
    try {
      // Validasi file video dan bukti transfer
      $request->validate([
        'file_result'   => 'required|mimes:mp4,avi,mpeg,quicktime,wmv|max:2548', // max 2.5MB
        'proof_payment' => 'required|image|max:2048', // max 2MB
      ]);

      $videoFile = $request->file('file_result');
      $proofFile = $request->file('proof_payment');

      // Analisis durasi video
      $getID3 = new getID3();
      $fileInfo = $getID3->analyze($videoFile->getPathname());
      $duration = $fileInfo['playtime_seconds'] ?? 0;

      if ($duration > 60) {
        Alert::toast('Durasi video terlalu panjang. Maksimal 60 detik.', 'error');
        return redirect()->back()->withInput();
      }

      // Upload video
      $videoPath = $videoFile->store('jj', 'public');

      // Upload bukti transfer
      $proofPath = $proofFile->store('bukti_trf', 'public');

      // Update proof_payment & status di table orders
      $order->update([
        'proof_payment' => $proofPath,
        'status'        => 'approved',
      ]);

      // Jika ingin menyimpan juga ke table data_jj
      DataJJ::updateOrCreate(
        [
          'viewer_id' => $order->viewer_id,
          'username1' => $order->viewer->username1,
        ],
        [
          'username2'  => $order->viewer->username2,
          'filename'   => $videoPath,
          'duration'   => round($duration),
          'size'       => $videoFile->getSize(),
          'sts_active' => true,
        ]
      );

      Alert::toast('Video dan bukti transfer berhasil diupload!', 'success');
      return redirect()->route('order.index');
    } catch (ValidationException $e) {
      $message = implode(', ', $e->validator->errors()->all());
      Alert::toast('Validasi gagal: ' . $message, 'error');
      return redirect()->back()->withInput();
    } catch (\Throwable $e) {
      Alert::toast('Terjadi kesalahan: ' . $e->getMessage(), 'error');
      return redirect()->back()->withInput();
    }
  }
}
