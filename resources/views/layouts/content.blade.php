@extends('layouts.admin.app')

@if (isset($view))
    @section('content')
        @include($view)
    @endsection
@else
    <h1>Konten tidak ditemukan</h1>
@endif
