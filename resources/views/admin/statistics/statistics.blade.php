@extends('layout.admin')

@section('title', 'Thống kê số liệu')

@section('content')
    <div class="container-fluid statistics" id="showComponent">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mt-3">
            <h1 class="h3 mb-0 fw-bold text-gray-800">Thống kê</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
        </div>
        {{--  --}}
        <livewire:admin.statistics.card />
        {{--  --}}
        <livewire:admin.statistics.statistics />
        {{--  --}}

        <div class="d-sm-flex align-items-center justify-content-between mt-3">
            <h1 class="h3 mb-0 fw-bold text-gray-800">Danh sách yêu cầu duyệt sản phẩm</h1>
            {{-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> --}}
        </div>

        <livewire:admin.statistics.request  />
    </div>
@endsection
