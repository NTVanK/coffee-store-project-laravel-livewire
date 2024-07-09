@extends('layout.admin')

@section('title', 'Phản hồi bình luận')

@section('content')
    <div class="container comment" id="showComponent">
        <h1 class="h3 mt-4 fw-bold text-gray-800">Bình luận</h1>
        <hr>
        {{--  --}}
        <livewire:admin.comment.comment />

    </div>
@endsection
