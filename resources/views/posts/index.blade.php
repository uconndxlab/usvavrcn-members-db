@extends('layouts.app')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('entities.index') }}">Members</a></li>
            <li class="breadcrumb-item"><a href="{{ route('entities.show', $group) }}">{{ $group->name }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">Posts</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1>{{ $group->name }} Posts</h1>
            <p class="text-muted mb-0">
                <i class="bi bi-people"></i> {{ $group->members()->count() }} members
            </p>
        </div>
        <a href="{{ route('groups.posts.create', $group) }}" class="btn btn-primary">
            <i class="bi bi-plus"></i> New Post
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($posts->count())
        <div class="row">
            <div class="col-md-8">
                @foreach ($posts as $post)
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <strong>{{ $post->author->name }}</strong>
                                <small class="text-muted ms-2">{{ $post->created_at->diffForHumans() }}</small>
                            </div>
                            @if ($post->start_time || $post->end_time)
                                <div class="text-muted small">
                                    @if ($post->start_time)
                                        <i class="bi bi-calendar-event"></i>
                                        {{ $post->start_time->format('M j, Y g:i A') }}
                                        @if ($post->end_time)
                                            - {{ $post->end_time->format('M j, Y g:i A') }}
                                        @endif
                                    @endif
                                </div>
                            @endif
                        </div>
                        <div class="card-body">
                            <p class="card-text">{!! nl2br(e($post->content)) !!}</p>
                        </div>
                    </div>
                @endforeach

                {{ $posts->links() }}
            </div>
            
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h6 class="mb-0">Group Members</h6>
                    </div>
                    <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                        @foreach ($group->members as $member)
                            <div class="d-flex align-items-center mb-2">
                                <div class="flex-grow-1">
                                    <a href="{{ route('entities.show', $member) }}" class="text-decoration-none">
                                        {{ $member->name }}
                                    </a>
                                    @if ($member->job_title)
                                        <br><small class="text-muted">{{ $member->job_title }}</small>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-5">
            <i class="bi bi-chat-dots display-1 text-muted"></i>
            <h3 class="mt-3">No posts yet</h3>
            <p class="text-muted">Be the first to post in this group!</p>
            <a href="{{ route('groups.posts.create', $group) }}" class="btn btn-primary">
                Create First Post
            </a>
        </div>
    @endif
</div>
@endsection
