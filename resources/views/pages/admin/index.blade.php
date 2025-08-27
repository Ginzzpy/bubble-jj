@extends('layouts.admin')
@section('title', 'Data Admin')
@push('style')
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables/datatables.min.css') }}">
@endpush

@section('content')
    <div class="row row-sm">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <div class="mb-3 row">
                        <div class="gap-3 col d-flex align-items-center">
                            <button type="button" class="btn btn-outline-primary d-flex align-items-center"
                                data-bs-toggle="modal" data-bs-target="#add-admin">
                                <i class="me-2 ti ti-user-plus"></i>
                                Tambah Data
                            </button>
                            <button type="button" id="refresh-btn" class="btn btn-success d-flex align-items-center">
                                <i class="me-2 ti ti-rotate"></i>
                                Refresh
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table-admin" class="table mb-0 table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Username</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('assets/libs/datatables/datatables.min.js') }}"></script>
    <script>
        $(function() {
            const table = $("#table-admin").DataTable({
                processing: false,
                serverSide: true,
                paging: true,
                searching: true,
                ordering: true,
                info: true,
                autoWidth: true,
                responsive: true,
                pageLength: 30,
                lengthMenu: [
                    [5, 15, 30, 50, 75, 100],
                    [5, 15, 30, 50, 75, 100],
                ],
                ajax: {
                    url: "{{ route('admin.index') }}",
                    error: function(xhr, error, thrown) {
                        console.error("DataTables Ajax error:", xhr.responseText);
                        Swal.fire({
                            toast: true,
                            position: "top-end",
                            icon: "error",
                            title: "Gagal memuat data",
                            showConfirmButton: false,
                            timer: 3000,
                        });
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'username',
                        name: 'username'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                order: [
                    [0, "desc"]
                ],
                language: {
                    url: "{{ asset('assets/js/i18n/id.json') }}"
                }
            });
            $("#refresh-btn").on('click', function() {
                table.ajax.reload();
            });
        });
    </script>
@endpush
