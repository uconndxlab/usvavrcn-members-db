@extends('layouts.app')

@section('content')
<div class="container">
    {{-- Breadcrumbs --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('entities.index') }}">Entities</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $entity->name }}</li>
        </ol>
    </nav>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row">
                {{-- Left: Photo --}}
                <div class="col-md-3 text-center mb-3">
                    @if ($entity->photo_src)
                        <img src="{{ asset('storage/' . $entity->photo_src) }}" class="img-fluid rounded shadow" alt="{{ $entity->name }}">
                    @else
                        <div class="bg-light rounded p-5 text-muted">No Photo</div>
                    @endif
                </div>

                {{-- Right: Details --}}
                <div class="col-md-9">
                    <h2 class="mb-1">{{ $entity->name }}</h2>
                    @if ($entity->job_title)
                        <p class="text-muted mb-2">{{ $entity->job_title }}</p>
                    @endif

                    @if ($entity->email || $entity->phone)
                        <p class="mb-2">
                            @if ($entity->email)
                                <i class="bi bi-envelope"></i> <a href="mailto:{{ $entity->email }}">{{ $entity->email }}</a><br>
                            @endif
                            @if ($entity->phone)
                                <i class="bi bi-telephone"></i> {{ $entity->phone }}
                            @endif
                        </p>
                    @endif

                    @if ($entity->linkedin || $entity->website)
                        <p>
                            @if ($entity->linkedin)
                                <a href="{{ $entity->linkedin }}" target="_blank" class="btn btn-sm btn-outline-primary me-2">LinkedIn</a>
                            @endif
                            @if ($entity->website)
                                <a href="{{ $entity->website }}" target="_blank" class="btn btn-sm btn-outline-secondary">Website</a>
                            @endif
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- More Details --}}
    <div class="row">
        <div class="col-md-6">

            <div class="mb-3">
                <h5>Tags</h5>
                @if ($entity->tags->isNotEmpty())
                    <ul class="list-inline">
                        @foreach ($entity->tags as $tag)
                            <li class="list-inline-item">
                                <span class="badge bg-secondary">{{ $tag->name }}</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">No tags assigned</p>
                @endif
            </div>

            <div class="mb-3">
                <h5>Description</h5>
                <p>{{ $entity->description ?? '—' }}</p>
            </div>

            <div class="mb-3">
                <h5>Research Interests</h5>
                <p>{{ $entity->research_interests ?? '—' }}</p>
            </div>

            <div class="mb-3">
                <h5>Projects</h5>
                <p>{{ $entity->projects ?? '—' }}</p>
            </div>

            <div class="mb-3">
                <h5>Career Stage</h5>
                <p>{{ $entity->career_stage ?? '—' }}</p>
            </div>
        </div>

        <div class="col-md-6">
            <div class="mb-3">
                <h5>Primary Institution</h5>
                <p>
                    {{ $entity->primary_institution_name ?? '—' }}<br>
                    {{ $entity->primary_institution_department ?? '' }}<br>
                    {{ $entity->primary_institution_mailing ?? '' }}
                </p>
            </div>

            @if ($entity->secondary_institution_name)
                <div class="mb-3">
                    <h5>Secondary Institution</h5>
                    <p>{{ $entity->secondary_institution_name }}</p>
                </div>
            @endif

            <div class="mb-3">
                <h5>COE Affiliation</h5>
                <p>{{ $entity->coe_affiliation ?? '—' }}</p>
            </div>

            <div class="mb-3">
                <h5>Lab Group</h5>
                <p>{{ $entity->lab_group ?? '—' }}</p>
            </div>

            <div class="mb-3 text-muted">
                <small>
                    Created: {{ $entity->creation_date ? \Carbon\Carbon::parse($entity->creation_date)->format('M j, Y') : '—' }}<br>
                    Updated: {{ $entity->last_updated ? \Carbon\Carbon::parse($entity->last_updated)->format('M j, Y') : '—' }}
                </small>
            </div>
        </div>
    </div>

    @if ($entity->entity_type === 'group')
        <hr class="my-4">
        <div class="row">
            <div class="col-md-6">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5>Group Members ({{ $entity->members()->count() }})</h5>
                    <a href="{{ route('groups.posts', $entity) }}" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-chat-dots"></i> View Posts
                    </a>
                </div>
                
                @if ($entity->members()->count() > 0)
                    <div style="max-height: 300px; overflow-y: auto;">
                        @foreach ($entity->members()->orderBy('name')->get() as $member)
                            <div class="d-flex align-items-center mb-2 p-2 border rounded">
                                <div class="flex-grow-1">
                                    <a href="{{ route('entities.show', $member) }}" class="text-decoration-none fw-bold">
                                        {{ $member->name }}
                                    </a>
                                    @if ($member->job_title)
                                        <br><small class="text-muted">{{ $member->job_title }}</small>
                                    @endif
                                    @if ($member->email)
                                        <br><small class="text-muted">{{ $member->email }}</small>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted">No members yet.</p>
                @endif
            </div>
            
            <div class="col-md-6">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5>Recent Posts</h5>
                    <a href="{{ route('groups.posts.create', $entity) }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-plus"></i> New Post
                    </a>
                </div>
                
                @php
                    $recentPosts = $entity->groupPosts()->with('author')->latest()->take(3)->get();
                @endphp
                
                @if ($recentPosts->count() > 0)
                    @foreach ($recentPosts as $post)
                        <div class="card mb-2">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <small class="fw-bold">{{ $post->author->name }}</small>
                                    <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                                </div>
                                <p class="card-text small mb-0">{{ Str::limit($post->content, 150) }}</p>
                            </div>
                        </div>
                    @endforeach
                    <div class="text-center">
                        <a href="{{ route('groups.posts', $entity) }}" class="btn btn-sm btn-outline-secondary">
                            View All Posts
                        </a>
                    </div>
                @else
                    <p class="text-muted">No posts yet.</p>
                    <a href="{{ route('groups.posts.create', $entity) }}" class="btn btn-sm btn-primary">
                        Create First Post
                    </a>
                @endif
            </div>
        </div>
    @endif

    {{-- Actions --}}
    <div class="d-flex justify-content-between mt-4">
        <a href="{{ route('entities.edit', $entity) }}" class="btn btn-warning">Edit</a>
        <form action="{{ route('entities.destroy', $entity) }}" method="POST" onsubmit="return confirm('Delete this entity?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
    </div>
</div>
@endsection
