@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Public Posts</h1>
        <a href="{{ route('entities.index') }}" class="btn btn-outline-primary">
            <i class="bi bi-people"></i> Browse Groups
        </a>
    </div>

    @if ($posts->count())
        <div class="row">
            @foreach ($posts as $post)
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $post->author->name }}</strong>
                                @if ($post->targetGroup)
                                    <small class="text-muted">
                                        in <a href="{{ route('groups.posts', $post->targetGroup) }}">{{ $post->targetGroup->name }}</a>
                                    </small>
                                @endif
                            </div>
                            <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                        </div>
                        <div class="card-body">
                            <p class="card-text">{!! nl2br(e($post->content)) !!}</p>
                            @if ($post->start_time || $post->end_time)
                                <div class="text-muted small mt-2">
                                    <i class="bi bi-calendar-event"></i>
                                    @if ($post->start_time)
                                        {{ $post->start_time->format('M j, Y g:i A') }}
                                        @if ($post->end_time)
                                            - {{ $post->end_time->format('M j, Y g:i A') }}
                                        @endif
                                    @endif
                                </div>
                            @endif
                        </div>
                        @if ($post->targetGroup)
                            <div class="card-footer">
                                <a href="{{ route('groups.posts', $post->targetGroup) }}" class="btn btn-sm btn-outline-primary">
                                    View Group Posts
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        {{ $posts->links() }}
    @else
        <div class="text-center py-5">
            <i class="bi bi-chat-dots display-1 text-muted"></i>
            <h3 class="mt-3">No posts yet</h3>
            <p class="text-muted">Posts from groups will appear here.</p>
            <a href="{{ route('entities.index') }}" class="btn btn-primary">
                Browse Groups
            </a>
        </div>
    @endif
</div>
@endsection
