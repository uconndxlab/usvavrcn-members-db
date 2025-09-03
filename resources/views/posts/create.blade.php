@extends('layouts.app')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('entities.index') }}">Members</a></li>
            <li class="breadcrumb-item"><a href="{{ route('entities.show', $group) }}">{{ $group->name }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('groups.posts', $group) }}">Posts</a></li>
            <li class="breadcrumb-item active" aria-current="page">New Post</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h4 class="mb-0">Create New Post in {{ $group->name }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('groups.posts.store', $group) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input
                                type="text"
                                name="title"
                                id="title"
                                class="form-control @error('title') is-invalid @enderror"
                                value="{{ old('title') }}"
                                placeholder="Enter post title"
                                maxlength="60"
                                required
                            >
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Content</label>
                            <textarea name="content" id="content" rows="6" 
                                      class="form-control @error('content') is-invalid @enderror" 
                                      placeholder="What would you like to share with the group?" required>{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="start_time" class="form-label">Event Start (Optional)</label>
                                    <input type="datetime-local" name="start_time" id="start_time" 
                                           class="form-control @error('start_time') is-invalid @enderror"
                                           value="{{ old('start_time') }}">
                                    @error('start_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="end_time" class="form-label">Event End (Optional)</label>
                                    <input type="datetime-local" name="end_time" id="end_time" 
                                           class="form-control @error('end_time') is-invalid @enderror"
                                           value="{{ old('end_time') }}">
                                    @error('end_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send"></i> Post
                            </button>
                            <a href="{{ route('groups.posts', $group) }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
