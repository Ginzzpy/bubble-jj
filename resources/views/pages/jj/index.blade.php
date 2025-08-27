@extends('layouts.admin')
@section('title', 'Data JJ')
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
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table-jj" class="table mb-0 table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Username 1</th>
                                    <th>Username 2</th>
                                    <th>Durasi</th>
                                    <th>Ukuran</th>
                                    <th>File</th>
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
        $('#table-jj').DataTable({
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
                url: "{{ route('data.jj') }}",
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
                    data: 'username1',
                    name: 'username1'
                },
                {
                    data: 'username2',
                    name: 'username2'
                },
                {
                    data: 'duration',
                    name: 'duration'
                },
                {
                    data: 'size',
                    name: 'size'
                },
                {
                    data: 'file',
                    name: 'file',
                    orderable: false,
                    searchable: false
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
    </script>
@endpush
