@extends('layouts.admin')
@section('title', 'Riwayat Orderan')
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
                            <button type="button" id="refresh-btn" class="btn btn-success d-flex align-items-center">
                                <i class="me-2 ti ti-rotate"></i>
                                Refresh
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col d-flex align-items-center gap-3">
                            <div>
                                <label for="filter-status" class="form-label">Filter Status</label>
                                <select id="filter-status" class="form-select">
                                    <option value="">Semua Status</option>
                                    <option value="approved">Approved</option>
                                    <option value="rejected">Rejected</option>
                                </select>
                            </div>
                            <div>
                                <label for="filter-menu" class="form-label">Filter Menu</label>
                                <select id="filter-menu" class="form-select">
                                    <option value="">Semua Jenis</option>
                                    @foreach (App\Models\Menu::all() as $menu)
                                        <option value="{{ $menu->id }}">{{ $menu->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table-order" class="table mb-0 table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Username</th>
                                    <th>Jenis</th>
                                    <th>Catatan</th>
                                    <th>Status</th>
                                    <th>Proof Payment</th>
                                    <th>Alasan Ditolak</th>
                                    <th>Tanggal Upload</th>
                                    <th>Tanggal Review</th>
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
            const table = $('#table-order').DataTable({
                processing: false,
                serverSide: true,
                paging: true,
                searching: false,
                ordering: true,
                info: true,
                autoWidth: false,
                responsive: false,
                scrollX: true,
                pageLength: 5,
                lengthMenu: [
                    [5, 15, 30, 50, 75, 100],
                    [5, 15, 30, 50, 75, 100],
                ],
                ajax: {
                    url: "{{ route('admin.order.history') }}",
                    data: function(d) {
                        d.status = $('#filter-status').val();
                        d.menu_id = $('#filter-menu').val();
                    },
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
                        data: 'jenis',
                        name: 'jenis'
                    },
                    {
                        data: 'notes',
                        name: 'notes'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'proof_payment',
                        name: 'proof_payment',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'reject_reason',
                        name: 'reject_reason',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'reviewed_at',
                        name: 'reviewed_at'
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

            $('#filter-status, #filter-menu').on('change', function() {
                table.ajax.reload();
            });

            $('#refresh-btn').on('click', function() {
                table.ajax.reload();
            });
        });
    </script>
@endpush
