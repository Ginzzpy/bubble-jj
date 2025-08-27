@extends('layouts.viewer')
@section('title', 'Upload Video Berbayar')

@section('content')
    <div class="d-flex align-items-center mb-3">
        <a href="{{ route('viewer.home') }}" class="btn btn-sm d-flex align-items-center">
            <i class="bi bi-arrow-left-short fs-3"></i>
            <span class="fw-bold fs-5">Kembali</span>
        </a>
    </div>

    <div class="row">
        <div class="card">
            <form action="{{ route('viewer.order.handle', $menu->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST')

                <div class="card-header border-bottom">
                    <h3 class="fw-bold fs-3 lh-1">Upload {{ $menu->title }}</h3>
                </div>

                <div class="card-body">
                    <div class="mb-3">
                        <label for="file">Pilih File {{ $menu->title }}</label>
                        <input class="form-control" type="file" id="file" name="file" accept="video/*">
                    </div>
                    <div class="mb-3">
                        <label for="notes">Request Tambahan</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3"
                            placeholder="Contoh: Minta diedit cerah, tambahkan musik, dll..."></textarea>
                    </div>
                    <div class="mb-3">
                        <span>Biaya Upload:</span>
                        <h4 class="fw-bold text-success">{{ $menu->price }}</h4>
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

@push('script')
    <script>
        $(document).ready(function() {
            const fileInput = $('#file');
            const previewContainer = $('<div id="preview-container" class="d-flex flex-wrap mt-3"></div>');
            fileInput.after(previewContainer);
            let fileObj = null;

            // Render ulang preview
            function renderPreview() {
                previewContainer.html('');
                if (!fileObj) return;

                const reader = new FileReader();
                reader.onload = function(e) {
                    const wrapper = $('<div>')
                        .addClass('position-relative m-2')
                        .css({
                            width: '240px',
                            height: '135px'
                        });

                    const video = $('<video>')
                        .attr('src', e.target.result)
                        .attr('controls', true)
                        .css({
                            width: '100%',
                            height: '100%',
                            borderRadius: '8px',
                            objectFit: 'cover'
                        });

                    const removeBtn = $('<button>')
                        .addClass('btn btn-sm btn-danger position-absolute top-0 end-0 m-1 p-1')
                        .html('<i class="mdi mdi-close"></i>')
                        .on('click', function() {
                            fileObj = null;
                            fileInput.val('');
                            renderPreview();
                        });

                    wrapper.append(video).append(removeBtn);
                    previewContainer.append(wrapper);
                };
                reader.readAsDataURL(fileObj);
            }

            fileInput.on('change', function() {
                if (this.files.length > 0) {
                    fileObj = this.files[0];
                    renderPreview();
                } else {
                    fileObj = null;
                    renderPreview();
                }
            });
        });
    </script>
@endpush
