@extends('layouts.user.main')
@section('title', 'Upload Video Gratis')

@section('content')
    <div class="d-flex align-items-center mb-3">
        <a href="{{ route('user.dashboard') }}" class="btn btn-sm d-flex align-items-center spa-link">
            <i class="bi bi-arrow-left-short fs-3"></i>
            <span class="fw-bold fs-5">Kembali</span>
        </a>
    </div>

    <div class="row">
        <div class="card">
            <form action="" method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST')

                <div class="card-header border-bottom">
                    <h3 class="fw-bold fs-3 lh-1">Upload {{ $menu->title }}</h3>
                </div>

                <div class="card-body">
                    <div class="mb-3">
                        <label for="file">Pilih File {{ $menu->title }}</label>
                        <input class="form-control form-control-sm" type="file" id="file" name="file" accept="video/*">
                    </div>
                    <div class="mb-3">
                        <label for="display_type">Pilih Jenis Tampil</label>
                        <select class="form-select form-select-sm" name="display_type" id="display_type" required>
                            <option selected disabled>=== Pilih Jenis Tampil JJ ===</option>
                            <option value="20">Jenis JJ Coin 20 : 15 detik</option>
                            <option value="30">Jenis JJ Coin 30 : 25 detik</option>
                            <option value="99">Jenis JJ Coin 99 : 60 detik</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <span>Biaya Upload:</span>
                        <h4 class="fw-bold text-success">{{ $menu->price }}</h4>
                    </div>
                    <div class="mb-3">
                        <h5 class="text-warning fw-bold">
                            <i class="ti ti-alert-circle"></i>
                            S&K (Syarat & Ketentuan):
                        </h5>
                        <ul>
                            <li>Video harus berdurasi maksimal 60 detik.</li>
                            <li>Video harus berukuran maksimal 2MB.</li>
                        </ul>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary w-100">
                        Upload sekarang
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
