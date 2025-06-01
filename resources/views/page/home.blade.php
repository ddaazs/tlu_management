@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-center align-items-center" style="height: 90vh">
        <div class="text-center">
            <h1>{{ $title }}</h1>
            <p class="lead">{{ $description }}</p>
        </div>
    </div>
@endsection

