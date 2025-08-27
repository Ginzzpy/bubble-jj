@extends('layouts.viewer')
@section('title', 'Upload Foto')

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
                        <div class="input-group">
                            <input class="form-control" type="file" id="file" name="files[]" accept="image/*"
                                multiple>
                            <button type="button" id="reset_file_btn" class="btn btn-danger">
                                Reset
                            </button>
                        </div>
                        <div id="preview-container" class="d-flex flex-wrap mt-3"></div>
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
            const previewContainer = $('#preview-container');
            let filesArray = [];

            // Reset button
            $('#reset_file_btn').on('click', function() {
                fileInput.val('');
                filesArray = [];
                previewContainer.html('');
            });

            // Re-render preview
            function renderPreviews() {
                previewContainer.html('');
                filesArray.forEach((file, i) => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const wrapper = $('<div>')
                            .addClass('position-relative m-2')
                            .css({
                                width: '120px',
                                height: '120px'
                            });

                        const img = $('<img>')
                            .attr('src', e.target.result)
                            .addClass('border')
                            .css({
                                width: '100%',
                                height: '100%',
                                objectFit: 'cover',
                                borderRadius: '8px'
                            });

                        const removeBtn = $('<button>')
                            .addClass('btn btn-sm btn-danger position-absolute top-0 end-0 m-1 p-1')
                            .html('<i class="mdi mdi-close"></i>')
                            .on('click', function() {
                                filesArray.splice(i, 1); // destroy from array
                                updateFileInput();
                                renderPreviews(); // re-render
                            });

                        wrapper.append(img).append(removeBtn);
                        previewContainer.append(wrapper);
                    };
                    reader.readAsDataURL(file);
                });
            }

            // Update fileInput.files from filesArray
            function updateFileInput() {
                const dt = new DataTransfer();
                filesArray.forEach(file => dt.items.add(file));
                fileInput[0].files = dt.files;
            }

            fileInput.on('change', function() {
                filesArray = Array.from(this.files); // save to array

                if (filesArray.length > 3) {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'warning',
                        title: 'Maksimal upload 3 file!',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
                    fileInput.val('');
                    filesArray = [];
                    return;
                }

                updateFileInput();
                renderPreviews();
            });
        });
    </script>
@endpush
