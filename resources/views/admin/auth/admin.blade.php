@extends('layout.admin')

@section('title', 'Thông tin quản trị')

@section('content')
    <div class="container mt-4" id='showComponent'>
        <h3 class="fw-bold">Thông tin quản trị</h3>
        <livewire:layout.editUser />
    </div>
@endsection
