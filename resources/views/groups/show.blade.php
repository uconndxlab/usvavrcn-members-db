@extends('layouts.app')

@section('content')
<div class="container">
    <div class="alert alert-warning" role="alert">
        TODO: remove this page, replace with entities page (switch check for groups)
    </div>
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('info'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <i class="bi bi-info-circle"></i> {{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between mb-4">
                        <div>
                            <h3 class="mb-2">{{ $group->name }}</h3>
                            @if($group->description)
                                <p class="text-muted">{{ $group->description }}</p>
                            @endif
                        </div>
                        <div class="btn-group">
                            <form method="POST" action="{{ route('groups.join', $group) }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-primary">
                                    <i class="bi bi-person-plus"></i> Join Group
                                </button>
                            </form>
                            <a href="{{ route('entities.edit', $group) }}" class="btn btn-outline-primary">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <a href="{{ route('groups.posts.create', $group) }}" class="btn btn-primary">
                                <i class="bi bi-plus"></i> New Post
                            </a>
                        </div>
                    </div>

                    <!-- Group Posts -->
                    <h5 class="mb-3">Recent Posts</h5>
                    @forelse($group->groupPosts->sortByDesc('created_at')->take(5) as $post)
                        <div class="card mb-3">
                            <div class="card-body">
                                <h6 class="card-title">{{ $post->title }}</h6>
                                <p class="card-text">{{ Str::limit($post->content, 200) }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        By {{ $post->author->full_name }} • {{ $post->created_at->diffForHumans() }}
                                    </small>
                                    <a href="{{ route('groups.posts', $group) }}" class="btn btn-sm btn-outline-primary">
                                        Read More
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <div class="text-muted">
                                <i class="bi bi-chat fs-1"></i>
                                <p class="mt-2">No posts yet</p>
                                <a href="{{ route('groups.posts.create', $group) }}" class="btn btn-primary">
                                    <i class="bi bi-plus"></i> Create First Post
                                </a>
                            </div>
                        </div>
                    @endforelse

                    @if($group->posts->count() > 5)
                        <div class="text-center">
                            <a href="{{ route('groups.posts', $group) }}" class="btn btn-outline-primary">
                                View All Posts ({{ $group->posts->count() }})
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Group Info -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Group Information</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="text-center">
                                <h4 class="text-primary mb-0">{{ $group->members->count() }}</h4>
                                <small class="text-muted">Members</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center">
                                <h4 class="text-info mb-0">{{ $group->groupPosts->count() }}</h4>
                                <small class="text-muted">Posts</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tags -->
            @if($group->tags && $group->tags->isNotEmpty())
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Tags</h6>
                </div>
                <div class="card-body">
                    @foreach($group->tags->groupBy('category.name') as $categoryName => $tags)
                        <div class="mb-3">
                            <small class="text-muted fw-bold">{{ $categoryName }}:</small>
                            <div class="mt-1">
                                @foreach($tags as $tag)
                                    <span class="badge bg-secondary me-1 mb-1">{{ $tag->name }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Members -->
            @if($group->members && $group->members->isNotEmpty())
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Members ({{ $group->members->count() }})</h6>
                </div>
                <div class="card-body">
                    @foreach($group->members as $member)
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center text-white me-2">
                                {{ substr($member->full_name, 0, 1) }}
                            </div>
                            <div class="flex-grow-1">
                                <a href="{{ route('members.show', $member) }}" class="text-decoration-none">
                                    {{ $member->full_name }}
                                </a>
                                @if($member->company)
                                    <br><small class="text-muted">{{ $member->company }}</small>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('groups.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to Groups
        </a>
    </div>
</div>

<style>
.avatar-sm {
    width: 32px;
    height: 32px;
    font-size: 0.875rem;
}
</style>
@endsection
