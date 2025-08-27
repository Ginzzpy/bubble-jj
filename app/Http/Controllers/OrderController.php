<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax() && $request->wantsJson()) {
            return $this->loadDatatables($request, ['pending']);
        }

        return view('pages.order.index');
    }

    public function history(Request $request)
    {
        if ($request->ajax() && $request->wantsJson()) {
            return $this->loadDatatables($request, ['approved', 'rejected']);
        }

        return view('pages.order.history');
    }

    private function loadDatatables(Request $request, array $statuses)
    {
        $orders = Order::with('menu', 'viewer')
            ->whereIn('status', $statuses);

        // Filter menu_id jika ada
        if ($request->filled('menu_id')) {
            $orders->where('menu_id', $request->menu_id);
        }

        // Filter status jika ada dan sesuai allowed statuses
        if ($request->filled('status') && in_array($request->status, $statuses)) {
            $orders->where('status', $request->status);
        }

        return DataTables::of($orders)
            ->addIndexColumn()
            ->editColumn('username', fn($row) => $row->viewer->username1)
            ->editColumn('jenis', fn($row) => $row->menu->title)
            ->editColumn('notes', function ($row) {
                if (!$row->notes) return '-';
                $words = explode(' ', $row->notes);
                $short = implode(' ', array_slice($words, 0, 5));
                if (count($words) > 5) {
                    $short .= '...';
                }
                return $short;
            })
            ->editColumn('status', function ($row) {
                $status = ucfirst($row->status);
                $badgeClass = match ($row->status) {
                    'approved' => 'bg-success',
                    'rejected' => 'bg-danger',
                    'pending'  => 'bg-warning',
                    default    => 'bg-secondary',
                };
                return "<span class='badge {$badgeClass}'>{$status}</span>";
            })
            ->addColumn('proof_payment', function ($row) {
                if ($row && $row->proof_payment) {
                    $url = asset('storage/' . $row->proof_payment);
                    return "<a href='{$url}' target='_blank'>
                    <img src='{$url}' alt='Bukti Transfer' style='height:40px; width:auto; border-radius:4px; object-fit:cover;'/>
                </a>";
                }
                return '-';
            })
            ->addColumn('reject_reason', function ($row) {
                if (!$row->reject_reason) return '-';
                $words = explode(' ', $row->reject_reason);
                $short = implode(' ', array_slice($words, 0, 5));
                if (count($words) > 5) {
                    $short .= '...';
                }
                return $short;
            })
            ->editColumn('created_at', fn($row) => $row->created_at->translatedFormat('d F Y H:i'))
            ->editColumn('reviewed_at', fn($row) => $row->updated_at->translatedFormat('d F Y H:i'))
            ->addColumn('action', function ($row) use ($statuses) {
                if (in_array('pending', $statuses)) {
                    $detailUrl = route('order.show', $row->id);
                    return "<a href='{$detailUrl}' data-spa class='btn btn-sm btn-info'>Detail</a>";
                } else {
                    $deleteUrl = route('admin.order.destroy', $row->id);
                    $csrf = csrf_token();
                    return <<<HTML
                        <form action="{$deleteUrl}" method="POST" onsubmit="return confirm('Apakah anda yakin ingin menghapus order ini?')" style="display:inline">
                            <input type="hidden" name="_token" value="{$csrf}">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="ti ti-trash-x"></i> Hapus
                            </button>
                        </form>
                    HTML;
                }
            })
            ->rawColumns(['status', 'proof_payment', 'action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Menu $menu)
    {
        switch ($menu->slug) {
            case 'photo':
                return \App\Services\UploadPhotoService::handle($request, $menu);
            case 'video':
                return \App\Services\UploadVideoService::handle($request, $menu);
            case 'free':
                return \App\Services\UploadFreeService::handle($request, $menu);
            default:
                abort(404, 'Menu tidak ditemukan');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load('menu', 'viewer', 'files');

        return view('pages.order.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    public function reject(Request $request, Order $order)
    {
        $request->validate([
            'reject_reason' => 'required|string|max:1000',
        ]);

        try {
            // Hapus semua file yang terkait dengan order
            $order->files()->each(function ($file) {
                if (\Illuminate\Support\Facades\Storage::disk('public')->exists($file->filename)) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($file->filename);
                }
                $file->delete();
            });

            // Update status order menjadi rejected dan simpan alasan
            $order->update([
                'status' => 'rejected',
                'reject_reason' => $request->reject_reason,
            ]);

            Alert::toast('Pesanan berhasil ditolak dan file terkait dihapus.', 'success');
            return redirect()->route('order.index');
        } catch (\Throwable $e) {
            Alert::toast('Terjadi kesalahan: ' . $e->getMessage(), 'error');
            return redirect()->back();
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Order::findOrFail($id);

        try {
            $order->files()->each(function ($file) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($file->filename);
                $file->delete();
            });

            $order->delete();

            Alert::toast('Riwayat order berhasil dihapus', 'success');
            return redirect()->back();
        } catch (\Throwable $e) {
            Alert::toast('Terjadi kesalahan: ' . $e->getMessage(), 'error');
            return redirect()->back();
        }
    }
}
