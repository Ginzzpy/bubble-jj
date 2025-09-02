@extends('layouts.admin.app')
@section('title', 'Page 2')

@section('styles')
    <style data-partial="1">
        #text {
            color: green;
        }
    </style>
@endsection

@section('content')
    <h1 id="text"></h1>
@endsection

@section('scripts')
    <script data-partial="1">
        $("#text").text("Tes Halaman 2");
    </script>
@endsection
