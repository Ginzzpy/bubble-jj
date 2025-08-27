@extends('layouts.auth')
@section('title', 'Login')

@section('content')
    <div class="row">
        <div class="col-md-6 mx-auto">
            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                @method('POST')

                <div class="card">
                    <div class="card-header pb-0 mb-0">
                        <h1 class="fw-bold">Login</h1>
                        <p>Silahkan login untuk posting video Jedag-jedug kamu.</p>
                    </div>

                    {{-- Error message umum --}}
                    @if (session('error'))
                        <div class="alert alert-danger mx-3 mt-2" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="card-body">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username Tiktok</label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror"
                                id="username" name="username" placeholder="Masukkan username tiktok kamu"
                                value="{{ old('username') }}">
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="no_telp" class="form-label">Nomor Whatsapp</label>
                            <input type="text" class="form-control @error('no_telp') is-invalid @enderror" id="no_telp"
                                name="no_telp" placeholder="Masukkan nomor Whatsapp kamu" value="{{ old('no_telp') }}">
                            @error('no_telp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary d-block w-100">
                            Login
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
