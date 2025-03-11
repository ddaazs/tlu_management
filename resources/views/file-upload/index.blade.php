@extends('layouts.app')

@section('title', 'Trang Upload File')

@section('content')
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <h1 class="mt-4">Danh sách File của Bạn</h1>

        <!-- Danh sách dự án -->
        <h2 class="mt-4">Dự Án</h2>
        @if($projects->count())
            @foreach($projects as $project)
                <div class="card mb-3">
                    <div class="card-header">
                        <strong>{{ $project->name }}</strong>
                    </div>
                    <div class="card-body">
                        <p>{{ $project->description }}</p>

                        @if($project->project_file)
                            <p>File đã upload:
                                <a href="{{ asset('storage/' . $project->project_file) }}" target="_blank">Xem file</a>
                            </p>
                        @else
                            <p><em>Chưa upload file dự án.</em></p>
                        @endif

                        <!-- Form upload file cho dự án sử dụng input name 'project_file' -->
                        <form action="{{ route('store.project', $project->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @if($errors->has('project_file'))
                                <div class="alert alert-danger">
                                    {{ $errors->first('project_file') }}
                                </div>
                            @endif
                            <div class="mb-2">
                                <label for="projectFile{{ $project->id }}">Chọn file (pdf, doc, docx, zip - tối đa 5MB):</label>
                                <input type="file" name="project_file" id="projectFile{{ $project->id }}" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-success">Upload File</button>
                        </form>
                    </div>
                </div>
            @endforeach
        @else
            <p>Bạn chưa có dự án nào.</p>
        @endif

        <!-- Danh sách báo cáo thực tập -->
        <h2 class="mt-5">Báo Cáo Thực Tập</h2>
        @if($internships->count())
            @foreach($internships as $internship)
                <div class="card mb-3">
                    <div class="card-header">
                        <strong>{{ $internship->title }}</strong>
                    </div>
                    <div class="card-body">
                        <p>{{ $internship->description }}</p>

                        @if($internship->report_file)
                            <p>File đã upload:
                                <a href="{{ asset('storage/' . $internship->report_file) }}" target="_blank">Xem file</a>
                            </p>
                        @else
                            <p><em>Chưa upload file báo cáo thực tập.</em></p>
                        @endif

                        <!-- Form upload file cho báo cáo thực tập sử dụng input name 'internship_file' -->
                        <form action="{{ route('store.internship', $internship->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @if($errors->has('internship_file'))
                                <div class="alert alert-danger">
                                    {{ $errors->first('internship_file') }}
                                </div>
                            @endif
                            <div class="mb-2">
                                <label for="internshipFile{{ $internship->id }}">Chọn file (pdf, doc, docx, zip - tối đa 5MB):</label>
                                <input type="file" name="internship_file" id="internshipFile{{ $internship->id }}" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-success">Upload File</button>
                        </form>
                    </div>
                </div>
            @endforeach
        @else
            <p>Bạn chưa có báo cáo thực tập nào.</p>
        @endif
    </div>
@endsection
