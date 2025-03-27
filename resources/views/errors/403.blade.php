@extends('layouts.app') <!-- Nếu có layout chung -->

@section('title', '403 - Không có quyền truy cập')

@section('content')
<div class="container d-flex flex-column justify-content-center" style="height: 90vh; width:500px">
    <h1 class="display-4">403</h1>
    <p class="lead">Bạn không có quyền truy cập vào trang này.</p>
    <a href="{{ url('/') }}" class="btn btn-primary">Quay lại trang chủ</a>
</div>
@endsection
