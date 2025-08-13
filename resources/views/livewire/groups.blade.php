<div class="container">
    <!-- Tab Navigation -->
    <ul class="nav nav-tabs mb-4" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="{{ route('members.index') }}">
                <i class="bi bi-people"></i> Members
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link active" href="{{ route('groups.index') }}">
                <i class="bi bi-collection"></i> Groups
            </a>
        </li>
    </ul>

    {{-- Title heading --}}
    <div class="text-center mb-4">
        <h1 class="text-dark fw-normal"><strong>Groups</strong></h1>
        <div class="text-light bg-primary py-2 px-4 align-middle d-inline-block w-auto" style="border-radius: 50px;">
            <p class="p-0 m-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
        </div>
    </div>

    {{-- My groups bar --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="text-dark fw-bold">My Groups</h4>
        <a href="#" class="btn btn-sm bg-dark text-white py-2 px-3 text-underline-none fw-semibold" style="border-radius: 50px">
            <i class="bi bi-pencil text-primary me-1"></i> Edit My Groups
        </a>
    </div>

    {{-- message that you have no groups --}}
    <div class="alert alert-info mb-4" role="alert">
        <i class="bi bi-info-circle"></i> You are not a member of any groups yet. 
    </div>

    {{-- All groups --}}
    <div class="d-flex align-items-center mb-3">
        <h2 class="h5 text-dark fw-bold me-3">All Groups</h2>
        <div class="btn-group btn-group-sm border p-2" style="border-radius: 50px; background-color: rgba(0,0,0,0.05)" role="group" aria-label="Filter by group type">
            <button type="button" class="btn @if($selectedGroup == 'all') btn-light @endif fw-semibold" style="border-radius: 50px" wire:click="selectGroup('all')">All Groups</button>
            @foreach ($tagCategories as $category)
                <button type="button" class="btn @if($selectedGroup == $category->id) btn-light @endif fw-semibold" style="border-radius: 50px" wire:click="selectGroup({{ $category->id }})">{{ $category->name }}</button>
            @endforeach
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="row mb-4">
        <div class="col-md-8">
            <form method="GET" action="{{ route('groups.index') }}" class="d-flex">
                <input class="form-control me-2" type="search" name="search" placeholder="Search groups..." 
                       value="{{ request('search') }}">
                <button class="btn btn-outline-secondary" type="submit">
                    <i class="bi bi-search"></i>
                </button>
                @if(request('search'))
                    <a href="{{ route('groups.index') }}" class="btn btn-outline-secondary ms-2">
                        <i class="bi bi-x"></i>
                    </a>
                @endif
            </form>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('entities.create') }}" class="btn btn-primary">
                <i class="bi bi-plus"></i> Add Group
            </a>
        </div>
    </div>

    <!-- Filter Tags -->
    @if($tagCategories && $tagCategories->isNotEmpty())
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Filter by Tags:</h6>
                    @foreach($tagCategories as $category)
                        @if($category->tags && $category->tags->isNotEmpty())
                        <div class="mb-2">
                            <small class="text-muted fw-bold">{{ $category->name }}:</small>
                            @foreach($category->tags as $tag)
                                <a href="{{ route('groups.index', ['tag' => $tag->id]) }}" 
                                   class="badge text-decoration-none me-1 {{ request('tag') == $tag->id ? 'bg-primary' : 'bg-secondary' }}">
                                    {{ $tag->name }}
                                </a>
                            @endforeach
                        </div>
                        @endif
                    @endforeach
                    @if(request('tag'))
                        <a href="{{ route('groups.index') }}" class="btn btn-sm btn-outline-secondary">
                            Clear Filter
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Groups Cards -->
    <div class="row">
        @forelse($groups as $group)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between mb-3">
                        <div class="flex-grow-1">
                            <h5 class="card-title mb-1">{{ $group->name }}</h5>
                            @if($group->description)
                                <p class="card-text text-muted small">{{ Str::limit($group->description, 100) }}</p>
                            @endif
                        </div>
                        <div class="badge bg-primary rounded-pill">
                            {{ $group->members ? $group->members->count() : 0 }} members
                        </div>
                    </div>

                    @if($group->tags && $group->tags->isNotEmpty())
                    <div class="mb-3">
                        @foreach($group->tags as $tag)
                            <span class="badge bg-secondary me-1">{{ $tag->name }}</span>
                        @endforeach
                    </div>
                    @endif

                    <div class="d-flex justify-content-between align-items-center">
                        <div class="btn-group">
                            <a href="{{ route('groups.show', $group) }}" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-eye"></i> View
                            </a>
                            <a href="{{ route('entities.edit', $group) }}" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                        </div>
                        @if($group->posts && $group->posts->isNotEmpty())
                            <small class="text-muted">
                                <i class="bi bi-chat"></i> {{ $group->posts->count() }} posts
                            </small>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <div class="text-muted">
                        <i class="bi bi-collection fs-1"></i>
                        <p class="mt-2 mb-3">No groups found</p>
                        @if(request('search') || request('tag'))
                            <a href="{{ route('groups.index') }}" class="btn btn-outline-primary">Clear filters</a>
                        @else
                            <a href="{{ route('entities.create') }}" class="btn btn-primary">Create your first group</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforelse
    </div>
</div>