<div class="row">
    <div class="col-md-6 mx-auto">
        <form action="" method="POST">
            @csrf
            @method('POST')

            <div class="card">
                <div class="card-header pb-0 mb-0">
                    <h1 class="fw-bold">Selamat Datang!</h1>
                    <p>Akun kamu akan dibuat secara otomatis jika belum terdaftar. Jika sudah memiliki akun, silakan login.</p>
                </div>

                <div class="card-body">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username Tiktok</label>
                        <input type="text" class="form-control" id="username" name="username"
                            placeholder="Masukkan username tiktok kamu" value="{{ old('username') }}">
                    </div>
                    <div class="mb-3">
                        <label for="no_telp" class="form-label">Nomor Whatsapp</label>
                        <input type="text" class="form-control" id="no_telp" name="no_telp"
                            placeholder="Masukkan nomor Whatsapp kamu" value="{{ old('no_telp') }}">
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary d-block w-100">
                        Lanjut
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
