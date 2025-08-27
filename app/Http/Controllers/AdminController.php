<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (request()->ajax() && request()->wantsJson()) {
            return $this->loadTable($request);
        }

        return view('pages.admin.index');
    }

    private function loadTable(Request $request)
    {
        $data_admin = Admin::with('role')
            ->whereHas('role', function ($q) {
                $q->where('name', 'admin');
            })
            ->select(['id', 'username', 'created_at', 'updated_at']);

        return DataTables::of($data_admin)
            ->addIndexColumn()
            ->editColumn('created_at', function ($row) {
                return \Carbon\Carbon::parse($row->created_at)
                    ->locale('id')
                    ->translatedFormat('d F Y H:i');
            })
            ->editColumn('updated_at', function ($row) {
                return \Carbon\Carbon::parse($row->updated_at)
                    ->locale('id')
                    ->translatedFormat('d F Y H:i');
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('admin.edit', $row->id);
                $deleteUrl = route('admin.destroy', $row->id);

                return <<<HTML
                    <div class="d-flex align-items-center gap-3">
                        <a href="{$editUrl}" data-spa class="btn btn-sm btn-info">
                            <i class="ti ti-edit"></i>
                            Edit
                        </a>
                        <a href="{$deleteUrl}" data-spa class="btn btn-sm btn-danger">
                            <i class="ti ti-trash-x"></i>
                            Hapus
                        </a>
                    </div>
                HTML;
            })
            ->rawColumns(['action'])
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
