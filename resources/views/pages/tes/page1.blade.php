@extends('layouts.admin.main')
@section('title', 'Page 1')

@section('styles')
    <style data-partial="1">
        #text {
            color: red;
        }
    </style>
@endsection

@section('content')
    <h1 id="text"></h1>
@endsection

@section('scripts')
    <script data-partial="1">
        $("#text").text("Tes Halaman 1");
    </script>
@endsection
