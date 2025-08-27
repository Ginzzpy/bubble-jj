<?php

namespace App\Http\Controllers;

use App\Helpers\CacheHelper;
use App\Models\Order;
use App\Models\Upload;
use App\Models\Viewer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class ViewerController extends Controller
{
    public function index(Request $request)
    {
        $data['menus'] = CacheHelper::getMenu();

        if (request()->ajax() && request()->wantsJson()) {
            return $this->loadTable($request);
        }

        return view('pages.viewer.index', $data);
    }

    private function loadTable(Request $request,)
    {
        $orders = Order::with('menu', 'viewer');

        // Filter menu_id jika ada
        if ($request->filled('menu_id')) {
            $orders->where('menu_id', $request->menu_id);
        }

        // Filter status jika ada dan sesuai allowed statuses
        if ($request->filled('status')) {
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
            ->addColumn('action', function ($row) {
                $detailUrl = route('viewer.order.show', $row->id);
                $deleteUrl = route('viewer.order.destroy', $row->id);
                $csrf = csrf_token();
                return <<<HTML
                        <a href='{$detailUrl}' data-spa class='btn btn-sm btn-info'>Detail</a>
                        <form action="{$deleteUrl}" method="POST" onsubmit="return confirm('Apakah anda yakin ingin menghapus order ini?')" style="display:inline">
                            <input type="hidden" name="_token" value="{$csrf}">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="ti ti-trash-x"></i> Hapus
                            </button>
                        </form>
                    HTML;
            })
            ->rawColumns(['status', 'proof_payment', 'action'])
            ->make(true);
    }

    public function account()
    {
        $viewer = Auth::guard('viewer')->user();
        return view('pages.viewer.account', compact('viewer'));
    }

    public function show($id)
    {
        $order = Order::with(['menu', 'viewer'])->findOrFail($id);

        return view('pages.viewer.detail', compact('order'));
    }

    public function update(Request $request)
    {
        /** @var \App\Models\Viewer $viewer */
        $viewer = Auth::guard('viewer')->user();
        $viewerId = $viewer->id;

        $uniqueUsername1 = Rule::unique('data_viewers')->ignore($viewerId, 'id');
        $uniqueNoTelp   = Rule::unique('data_viewers')->ignore($viewerId, 'id');

        // Validasi input
        $validated = $request->validate([
            'username1' => ['required', 'string', $uniqueUsername1],
            'username2' => ['nullable', 'string'],
            'no_telp'   => ['required', 'string', $uniqueNoTelp],
            'password'  => ['nullable', 'string', 'min:6', 'confirmed'],
        ]);

        // Update data viewer
        $viewer->username1 = $validated['username1'];
        $viewer->username2 = $validated['username2'] ?? null;
        $viewer->no_telp   = $validated['no_telp'];

        if (!empty($validated['password'])) {
            $viewer->password = Hash::make($validated['password']);
        }

        $viewer->save();

        Alert::toast('Akun berhasil diperbarui!', 'success');
        return redirect()->back();
    }
}
