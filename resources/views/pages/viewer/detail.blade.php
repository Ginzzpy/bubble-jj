@extends('layouts.viewer')
@section('title', 'Detail Pesanan')

@section('content')
    <div class="d-flex align-items-center mb-3">
        <a href="{{ route('viewer.home') }}" class="btn btn-sm d-flex align-items-center">
            <i class="bi bi-arrow-left-short fs-3"></i>
            <span class="fw-bold fs-5">Kembali</span>
        </a>
    </div>

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="fw-bold fs-5">Pesanan <mark>{{ $order->viewer->username1 }}</mark></h5>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <h6 class="fs-6 fst-italic">
                            Jenis pesanan: {{ $order->menu->title }}
                        </h6>
                        @if ($order->status == 'pending')
                            <span class="badge bg-warning">{{ ucfirst($order->status) }}
                            @elseif ($order->status == 'approved')
                                <span class="badge bg-success">{{ ucfirst($order->status) }}
                                @elseif ($order->status == 'rejected')
                                    <span class="badge bg-danger">{{ ucfirst($order->status) }}
                        @endif
                    </div>
                </div>

                <hr />

                <div class="card-body">
                    <div class="mb-3">
                        <span class="fw-bold">Catatan: </span>
                        <p>
                            {{ $order->notes }}
                        </p>
                    </div>
                    <div class="mb-3">
                        <span class="fw-bold">Files: </span>
                        <div class="table-responsive">
                            <table id="table-order" class="table mb-0 table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Filename</th>
                                        <th>Durasi</th>
                                        <th>Ukuran</th>
                                        <th>File</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->files as $row => $file)
                                        <tr>
                                            <td>{{ $row }}</td>
                                            <td>{{ basename($file->filename) }}</td>
                                            <td>{{ $file->duration ?? 0 }}</td>
                                            <td>{{ $file->size }}</td>
                                            <td>
                                                @if ($order->menu->slug == 'photo')
                                                    <a href='{{ asset('storage/' . $file->filename) }}' target='_blank'>
                                                        <img src='{{ asset('storage/' . $file->filename) }}' alt='File'
                                                            style='height:80px; width:auto; border-radius:4px; object-fit:cover;' />
                                                    </a>
                                                @else
                                                    <a href='{{ asset('storage/' . $file->filename) }}' target='_blank'>
                                                        <video src='{{ asset('storage/' . $file->filename) }}'
                                                            alt='File'
                                                            style='height:80px; width:auto; border-radius:4px; object-fit:cover;' />
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
