@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Membership Database</h1>
        <p>The USAVRCN maintains a customized and closed database to accession members, allow members to log areas of interest, and facilitate networking through internal and area-specific posting.</p>

        <a href="{{ route('entities.create') }}" class="btn btn-primary mb-4">Add Entity</a>

        <form method="GET" action="{{ route('entities.index') }}" class="row g-3 mb-4">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Search by name…"
                    value="{{ request('search') }}">
            </div>

            <div class="col-md-3">
                <select name="type" class="form-select">
                    <option value="">All Types</option>
                    <option value="person" {{ request('type') == 'person' ? 'selected' : '' }}>Show Only People</option>
                    <option value="group" {{ request('type') == 'group' ? 'selected' : '' }}>Show Only Groups</option>
                </select>
            </div>

            <div class="col-md-3">
                <select name="sort" class="form-select">
                    <option value="">Sort By</option>
                    <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name A-Z</option>
                    <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name Z-A</option>
                </select>
            </div>

            <div class="col-md-2">
                <button type="submit" class="btn btn-outline-primary w-100">Apply</button>
            </div>
        </form>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($entities->count())
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach ($entities as $entity)
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            @if ($entity->photo_src)
                                <img src="{{ asset('storage/' . $entity->photo_src) }}" class="card-img-top"
                                    alt="{{ $entity->name }}">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href="{{ route('entities.show', $entity) }}">{{ $entity->name }}</a>
                                </h5>
                                <p class="card-text text-muted mb-1">
                                    <strong>{{ ucfirst($entity->entity_type) }}</strong>
                                    @if ($entity->entity_type === 'group')
                                        <span class="badge bg-secondary ms-2">{{ $entity->members()->count() }} members</span>
                                    @endif
                                    @if ($entity->email)
                                        <br>{{ $entity->email }}
                                    @endif
                                </p>
                                <p class="card-text">
                                    {{ Str::limit($entity->description ?? $entity->biography, 100) }}
                                </p>
                                
                                @if ($entity->entity_type === 'group')
                                    <div class="mt-2">
                                        <a href="{{ route('groups.posts', $entity) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-chat-dots"></i> View Posts
                                        </a>
                                        <a href="{{ route('groups.posts.create', $entity) }}" class="btn btn-sm btn-primary">
                                            <i class="bi bi-plus"></i> Post
                                        </a>
                                    </div>
                                @endif
                            </div>
                            <div class="card-footer d-flex justify-content-between align-items-center">
                                <a href="{{ route('entities.edit', $entity) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('entities.destroy', $entity) }}" method="POST"
                                    onsubmit="return confirm('Delete this entity?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $entities->links() }}
            </div>
        @else
            <p class="text-muted">No entities found.</p>
        @endif
    </div>
@endsection
