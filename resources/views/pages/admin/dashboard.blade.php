@extends('layouts.admin.main')
@section('title', 'Dashboard')

@section('content')
    <h1>Dashboard</h1>
    <a href="{{ route('dashboard') }}" class="btn btn-primary spa-link">Go to Dashboard</a>
@endsection
