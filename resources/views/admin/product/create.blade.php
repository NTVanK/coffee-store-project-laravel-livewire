@extends('layout.admin')

@section('title', empty($id) ? 'Thêm sản phẩm' : 'Cập nhật sản phẩm')

@section('content')
<livewire:admin.product.create :editId='$id ?? null'/>  
@endsection