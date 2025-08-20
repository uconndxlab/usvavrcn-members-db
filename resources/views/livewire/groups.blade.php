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
        <div class="text-light bg-primary py-2 px-4 align-middle d-inline-block w-auto rounded-pill">
            <p class="p-0 m-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
        </div>
    </div>

    {{-- My groups bar --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="text-dark fw-bold">My Groups</h4>
        <a href="#" class="btn btn-sm bg-dark text-white py-2 px-3 text-underline-none fw-semibold rounded-pill">
            <i class="bi bi-pencil text-primary me-1"></i> Edit My Groups
        </a>
    </div>

    {{-- List of my groups --}}
    @if (Auth::user() && !Auth::user()->entity->groups->isEmpty())

        <div class="row">
            @foreach (Auth::user()->entity->groups as $group)
                <div class="col-md-6 col-lg-4 mb-4">
                    @include('groups.partials.group-card', ['group' => $group])
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info mb-4" role="alert">
            <i class="bi bi-info-circle"></i> You are not a member of any groups yet. 
        </div>
    @endif

    {{-- All groups --}}
    <div class="my-3">
        <h4 class="text-dark fw-bold mb-2 d-block d-md-inline me-md-3">All Groups</h4>
        <div class="btn-group btn-group-sm border p-1 rounded-pill" style="background-color: rgba(0,0,0,0.05)" role="group" aria-label="Filter by group type">
            <button type="button"
                    class="btn @if($selectedGroup == 'all') btn-light @endif fw-semibold rounded-pill"
                    wire:click="selectGroup('all')"
            >All Groups</button>
            <button type="button"
                    class="btn @if($selectedGroup == 'Team:') btn-light @endif fw-semibold rounded-pill"
                    wire:click="selectGroup('Team:')"
            >Teams</button>
            <button type="button"
                    class="btn @if($selectedGroup == 'Focus:') btn-light @endif fw-semibold rounded-pill"
                    wire:click="selectGroup('Focus:')"
            >Focuses</button>
            <button type="button"
                    class="btn @if($selectedGroup == 'Committee:') btn-light @endif fw-semibold rounded-pill"
                    wire:click="selectGroup('Committee:')"
            >Committees</button>
            {{-- @foreach ($tagCategories as $category)
                <button type="button"
                        class="btn @if($selectedGroup == $category->id) btn-light @endif fw-semibold rounded-pill"
                        wire:click="selectGroup({{ $category->name }})"
                >{{ $category->name }}</button>
            @endforeach --}}
        </div>
    </div>

    <!-- Groups Cards -->
    <div class="row">
        @forelse($groups as $group)
            <div class="col-md-6 col-lg-4 mb-4">
                @include('groups.partials.group-card', ['group' => $group])
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