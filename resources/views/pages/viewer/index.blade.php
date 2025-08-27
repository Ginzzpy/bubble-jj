@extends('layouts.viewer')
@section('title', 'Beranda')
@push('style')
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables/datatables.min.css') }}">
@endpush

@section('content')

    {{-- Success message --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                <i class="mdi mdi-close me-1"></i>
            </button>
        </div>
    @endif

    {{-- Error message general --}}
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                <i class="mdi mdi-close me-1"></i>
            </button>
        </div>
    @endif

    <div class="row">
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="username1" class="form-label">Akun 1</label>
                <input type="text" class="form-control @error('username1') is-invalid @enderror" id="username1"
                    name="username1" placeholder="Masukkan akun tiktok utama kamu"
                    value="{{ Auth::guard('viewer')->user()->username1 }}" readonly>
            </div>

            <div class="col-md-4 mb-3">
                <label for="username2" class="form-label">Akun 2</label>
                <input type="text" class="form-control @error('username2') is-invalid @enderror" id="username2"
                    name="username2" placeholder="Akun tiktok kedua (Opsional)"
                    value="{{ Auth::guard('viewer')->user()->username2 ?? '' }}" readonly>
            </div>

            <div class="col-md-4 mb-3">
                <label for="no_telp" class="form-label">Nomor Whatsapp</label>
                <input type="text" class="form-control @error('no_telp') is-invalid @enderror" id="no_telp"
                    name="no_telp" placeholder="Masukkan nomor Whatsapp kamu"
                    value="{{ Auth::guard('viewer')->user()->no_telp ?? '' }}" readonly>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <button type="button" id="edit_btn" class="btn btn-primary">Edit akun</button>
            </div>
        </div>
    </div>

    <hr />

    <div class="row">
        <h3 class="fw-bold mb-3">Daftar Menu</h3>

        @foreach ($menus as $menu)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-flex align-items-center justify-content-between">
                            <h4 class="fw-bold">{{ $menu->title }}</h4>
                            <h6 class="fw-bold text-success">{{ $menu->price }}</h6>
                        </div>
                    </div>
                    <div class="card-body pb-0">
                        <h6 class="text-muted fw-bold">
                            Keterangan:
                        </h6>
                        <p>
                            {{ $menu->description }}
                        </p>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('viewer.upload', ['slug' => $menu->slug]) }}" class="btn btn-primary">
                            Pilih
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row row-sm">
        <h3 class="fw-bold mb-3">Riwayat Pemesanan</h3>

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
                        <table id="table-upload" class="table mb-0 table-striped table-bordered table-hover">
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

    <div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('verify-password') }}" method="POST">
                    @csrf
                    @method('POST')

                    <div class="modal-header">
                        <h5 class="modal-title">Masukkan Password</h5>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="modal_password">Password</label>
                            <input type="password" class="form-control @error('username') is-invalid @enderror"
                                id="modal_password" name="password" placeholder="Masukkan password kamu" required>
                        </div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Verifikasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if (session('set_password_required'))
        <div class="modal fade" id="setPasswordModal" tabindex="-1" aria-labelledby="setPasswordModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="setPasswordForm" action="{{ route('save-password') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="setPasswordModalLabel">Upload Hasil</h1>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-warning" role="alert">
                                <strong>Catatan!</strong> Akun kamu baru terdaftar silahkan membuat password sebelum
                                menggunakan aplikasi. Password
                                akan digunakan pada saat kamu mengorder layanan.
                            </div>
                            <div class="mb-3">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password" id="password" required>
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation">Konfirmasi Password</label>
                                <input type="password" class="form-control" name="password_confirmation"
                                    id="password_confirmation" required>
                            </div>
                            <div id="password-error" class="text-danger d-none">
                                Password dan konfirmasi tidak sama!
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('script')
    <script src="{{ asset('assets/libs/datatables/datatables.min.js') }}"></script>
    <script>
        $(function() {
            @if (session('set_password_required'))
                var passwordModal = new bootstrap.Modal(document.getElementById('setPasswordModal'), {
                    backdrop: 'static',
                    keyboard: false
                });
                passwordModal.show();

                // Validasi konfirmasi password
                const form = document.getElementById('setPasswordForm');
                form.addEventListener('submit', function(e) {
                    const password = document.getElementById('password').value;
                    const confirm = document.getElementById('password_confirmation').value;
                    const errorDiv = document.getElementById('password-error');

                    if (password !== confirm) {
                        e.preventDefault();
                        errorDiv.classList.remove('d-none');
                    } else {
                        errorDiv.classList.add('d-none');
                    }
                });
            @endif

            $("#edit_btn").on('click', function() {
                var passwordModal = new bootstrap.Modal(document.getElementById('passwordModal'), {
                    backdrop: 'static',
                    keyboard: false
                });
                passwordModal.show();
            });

            const table = $("#table-upload").DataTable({
                processing: false,
                serverSide: true,
                paging: true,
                searching: false,
                ordering: true,
                info: true,
                autoWidth: true,
                responsive: true,
                pageLength: 5,
                lengthMenu: [
                    [5, 15, 30, 50, 75, 100],
                    [5, 15, 30, 50, 75, 100],
                ],
                ajax: {
                    url: "{{ route('viewer.home') }}",
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

            $("#refresh-btn").on('click', function() {
                table.ajax.reload();
            });
        });
    </script>
@endpush
