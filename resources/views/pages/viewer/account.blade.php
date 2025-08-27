@extends('layouts.viewer')
@section('title', 'Account')

@section('content')
    <div class="d-flex align-items-center mb-3">
        <a href="{{ route('viewer.home') }}" class="btn btn-sm d-flex align-items-center">
            <i class="bi bi-arrow-left-short fs-3"></i>
            <span class="fw-bold fs-5">Kembali</span>
        </a>
    </div>

    <div class="row">
        <div class="card">
            <form action="{{ route('viewer.account.put') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="card-header border-bottom">
                    <h3 class="fw-bold fs-3 lh-1">Profile Akun</h3>
                </div>

                <div class="card-body">
                    <div class="mb-3">
                        <label for="username1">Akun 1</label>
                        <input class="form-control @error('username1') is-invalid @enderror" type="text" id="username1"
                            name="username1" placeholder="Akun tiktok utama"
                            value="{{ Auth::guard('viewer')->user()->username1 ?? '' }}">
                        @error('username1')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="username2">Akun 2</label>
                        <input class="form-control @error('username2') is-invalid @enderror" type="text" id="username2"
                            name="username2" placeholder="Akun tiktok kedua (Opsional)"
                            value="{{ Auth::guard('viewer')->user()->username2 ?? '' }}">
                        @error('username2')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="no_telp">Nomor Whatsapp</label>
                        <input class="form-control @error('no_telp') is-invalid @enderror" type="text" id="no_telp"
                            name="no_telp" placeholder="Nomor Whatsapp"
                            value="{{ Auth::guard('viewer')->user()->no_telp ?? '' }}">
                        @error('no_telp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password">Password Baru</label>
                        <input class="form-control @error('password') is-invalid @enderror" type="password" id="password"
                            name="password" placeholder="Kosongkan jika tidak ingin mengganti">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation">Konfirmasi Password Baru</label>
                        <input class="form-control" type="password" id="password_confirmation" name="password_confirmation"
                            placeholder="Konfirmasi password baru">
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary w-100">
                        Perbarui
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
