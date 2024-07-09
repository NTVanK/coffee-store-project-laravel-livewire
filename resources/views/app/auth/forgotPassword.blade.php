@extends('layout.app')

@section('title', 'Tạo mật khẩu mới')

@section('content')
    <div class="container py-3 h-100 mt-2 rounded shadow" 
        style="background: url({{ asset('assets/img/background.svg') }})">
        <div class="row d-flex h-100">
            <div class="col-md-8 col-lg-7 col-xl-6">
                <img class="img-fluid mx-auto d-block" src="{{ asset('assets/img/logoA.svg') }}" style="width: 80%" />
            </div>
            <div class="col-md-7 col-lg-5 col-xl-4 offset-xl-1">
                <livewire:app.auth.forgotPassword :email='$email'/>
            </div>
        </div>
    </div>
@endsection