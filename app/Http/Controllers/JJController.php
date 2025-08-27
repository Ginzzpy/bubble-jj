<?php

namespace App\Http\Controllers;

use App\Models\DataJJ;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class JJController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax() && $request->wantsJson()) {
            return $this->loadTable($request, ['pending']);
        }

        return view('pages.jj.index');
    }

    private function loadTable()
    {
        $jj = DataJJ::with('viewer')->latest(); // load relasi viewer jika ada

        return DataTables::of($jj)
            ->addIndexColumn()
            ->editColumn('username1', fn($row) => $row->username1)
            ->editColumn('username2', fn($row) => $row->username2 ?? '-')
            ->editColumn('duration', fn($row) => $row->duration . ' detik')
            ->editColumn('size', fn($row) => number_format($row->size / 1024, 2) . ' KB')
            ->addColumn('file', function ($row) {
                if ($row->filename) {
                    $url = asset('storage/' . $row->filename);
                    return "<a href='{$url}' target='_blank'>
                        <video src='{$url}' alt='File' style='height:80px; width:auto; border-radius:4px; object-fit:cover;' />
                    </a>";
                }
                return '-';
            })
            ->addColumn('action', function ($row) {
                // $deleteUrl = route('jj.destroy', $row->id);
                $deleteUrl = route('dashboard');
                $csrf = csrf_token();
                return <<<HTML
                        <form action="{$deleteUrl}" method="POST" onsubmit="return confirm('Apakah anda yakin ingin menghapus data ini?')" style="display:inline">
                            <input type="hidden" name="_token" value="{$csrf}">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    HTML;
            })
            ->rawColumns(['file', 'action'])
            ->make(true);
    }
}
