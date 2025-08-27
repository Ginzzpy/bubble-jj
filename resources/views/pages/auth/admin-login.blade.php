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
                        <p>Ini halaman login untuk admin.</p>
                    </div>

                    {{-- Error message general --}}
                    @if (session('error'))
                        <div class="alert alert-danger mx-3 mt-2" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="card-body">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror"
                                id="username" name="username" placeholder="Masukkan username anda"
                                value="{{ old('username') }}">
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password" placeholder="Masukkan password anda">
                            @error('password')
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
