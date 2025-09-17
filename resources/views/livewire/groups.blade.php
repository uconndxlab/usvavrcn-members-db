<div class="container">

    {{-- Title heading --}}
    <div class="text-center mb-4">
        <h1 class="text-dark fw-normal"><strong>Groups</strong></h1>
        <div class="text-light bg-primary py-2 px-4 align-middle d-inline-block w-auto rounded-pill">
            <p class="p-0 m-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
        </div>
    </div>

    @php
        $hasNewPosts = false;
        foreach ($groups as $group) {
            $unreadMessages = $group->groupPosts->whereNotIn('id', Auth::user()->posts->pluck('id'));
            if ($unreadMessages->count() && Auth::user() && Auth::user()->entity->groups->contains($group)) {
                $hasNewPosts = true;
                break;
            }
        }
    @endphp

    @if ($hasNewPosts)
        <div class="my-3">
            <h4 class="text-dark fw-bold mb-2 d-block d-md-inline me-md-3">Recent Posts</h4>
            <div>
                @foreach ($groups as $group)
                    @php
                        $unreadMessages = $group->groupPosts
                            ->whereNotIn('id', Auth::user()->posts->pluck('id'));
                    @endphp

                    @if ($unreadMessages->count() && Auth::user() && Auth::user()->entity->groups->contains($group))
                        {{-- display card with the message content --}}
                        <div class="d-flex overflow-auto mb-3 pb-2" style="gap: 1rem;">
                            @foreach ($unreadMessages as $post)
                                <div class="card flex-shrink-0" style="width: 360px; height: 200px;">
                                    <div class="card-body d-flex flex-column h-100">
                                        <h5 class="card-title">{{ $post->title }}</h5>
                                        <p class="card-text mb-0 flex-grow-1">{{ Str::limit($post->content, 120) }}</p>
                                        <p class="card-text mt-auto mb-0">
                                            <small class="text-muted d-flex justify-content-between">
                                                {{ $post->created_at->format('M d, Y') }}
                                                <a href="{{ route('groups.show', $group->id) }}"> In {{ $group->name }}</a>
                                            </small>
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    @endif

    <div class="my-3">
        <h4 class="text-dark fw-bold mb-2 d-block d-md-inline me-md-3">My Groups</h4>
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