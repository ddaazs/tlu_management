@extends('layouts.app')

@section('title', 'Upload File Dự Án')

@section('content')
    <div class="container">
        <h1>Upload File cho Dự Án: {{ $project->name }}</h1>
        <form action="{{ route('store.project', $project->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="file">Chọn file (pdf, doc, docx, zip):</label>
                <input type="file" name="file" id="file" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Upload File</button>
        </form>
    </div>
@endsection
