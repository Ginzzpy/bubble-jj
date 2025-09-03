@extends('layouts.auth.main')
@section('title', 'Verifikasi email')

@section('content')
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card">
                <div class="card-body text-center">
                    <h3 class="mb-2">Verifikasi Email Kamu</h3>
                    <p class="mb-4">
                        Kami telah mengirim link verifikasi ke <b>{{ auth()->user()->email }}</b>.
                        Silakan cek inbox (atau folder spam).
                    </p>

                    <div class="d-flex gap-2 justify-content-center">
                        <button id="btn-resend" class="btn btn-primary">Kirim Ulang Email</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script data-partial="{{ isset($view) }}">
        $("#btn-resend").on("click", function() {
            let btn = $(this);
            btn.attr("disabled", true).text("Mengirim...");

            $.ajax({
                url: "{{ route('verification.send') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(res) {
                    showToast("success", res.message);

                    let countdown = 25;
                    btn.text(`Tunggu ${countdown}d untuk kirim ulang`);

                    let interval = setInterval(() => {
                        countdown--;
                        if (countdown > 0) {
                            btn.text(`Tunggu ${countdown}d untuk kirim ulang`);
                        } else {
                            clearInterval(interval);
                            btn.attr("disabled", false).text("Kirim Ulang Email");
                        }
                    }, 1000);
                },
                error: function(xhr) {
                    let err = xhr.responseJSON?.message || "Terjadi kesalahan!";
                    showToast("error", err);
                    btn.attr("disabled", false).text("Kirim Ulang Email");
                }
            });
        });
    </script>
@endsection
