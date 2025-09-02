@extends('layouts.admin.app')
@section('title', 'Page 1')

@section('styles')
    <style>
        #text {
            color: red;
        }
    </style>
@endsection

@section('content')
    <h1 id="text"></h1>
@endsection

@section('scripts')
    <script>
        $("#text").text("Tes Halaman 1");
    </script>
@endsection
