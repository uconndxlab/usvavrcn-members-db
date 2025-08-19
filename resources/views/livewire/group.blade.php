<div>
    <div class="mb-4">
        <p class="fw-bolder h1">{{ $group->name }}</p>
        <div>
            <span class="h5 fw-normal text-muted me-3 text-dark">{{ $group->members()->count() }} Members</span>
            {{-- if we are not already in the group --}}
            @if (!Auth::user()->entity->groups->contains($group))
                <form method="POST" action="{{ route('groups.join', $group) }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn bg-primary text-white px-4" style="border-radius: 50px;">Join Group</button>
                </form>
            @else
                <form method="POST" action="{{ route('groups.leave', $group) }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger px-4" style="border-radius: 50px;"
                        onclick="return confirm('Are you sure you want to leave this group?');"
                    >Leave Group</button>
                </form>
            @endif
        </div>
    </div>

    <div class="d-flex align-items-center my-3">
        <div class="btn-group btn-group-sm border p-1" style="border-radius: 50px; background-color: rgba(0,0,0,0.05)" role="group" aria-label="Filter by group type">
            <button type="button"
                    class="btn @if($selectedTab == 'members') btn-light @endif fw-semibold"
                    style="border-radius: 50px"
                    wire:click="$set('selectedTab', 'members')"
            >Members</button>
            <button type="button"
                    class="btn @if($selectedTab == 'forum') btn-light @endif fw-semibold"
                    style="border-radius: 50px"
                    wire:click="$set('selectedTab', 'forum')"
            >Forum</button>
        </div>
    </div>
    
    {{-- Members view --}}
    @if ($selectedTab == 'members')
        <div class="card bg-light rounded mt-4">
            <div class="card-body bg-light text-dark rounded">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="bg-light text-dark">Name</th>
                                <th class="bg-light text-dark">Company</th>
                                <th class="bg-light text-dark">Email</th>
                                <th class="bg-light text-dark">Tags</th>
                                <th class="bg-light text-dark">Groups</th>
                                <th class="bg-light text-dark">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($group->members as $member)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center text-white me-2">
                                            {{ substr($member->full_name, 0, 1) }}
                                        </div>
                                        <div>
                                            <strong>{{ $member->full_name }}</strong>
                                            @if($member->title)
                                                <br><small class="text-muted">{{ $member->title }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $member->company ?? '-' }}</td>
                                <td>
                                    @if($member->email)
                                        <a href="mailto:{{ $member->email }}">{{ $member->email }}</a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if($member->tags)
                                        @foreach($member->tags as $tag)
                                            <span class="badge bg-secondary me-1">{{ $tag->name }}</span>
                                        @endforeach
                                    @endif
                                </td>
                                <td>
                                    @if($member->memberOf && $member->memberOf->isNotEmpty())
                                        {{ $member->memberOf->count() }} group(s)
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('members.show', $member) }}" class="btn btn-outline-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('entities.edit', $member) }}" class="btn btn-outline-secondary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="bi bi-people fs-1"></i>
                                        <p class="mt-2">No members found</p>
                                        @if(request('search') || request('tag'))
                                            <a href="{{ route('members.index') }}" class="btn btn-sm btn-outline-primary">Clear filters</a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{-- TODO: Figure out livewire pagination --}}
                {{--             
                @if($members->hasPages())
                    <div class="d-flex justify-content-center mt-3">
                        {{ $members->links() }}
                    </div>
                @endif --}}
            </div>
        </div>
    @endif
    
    {{-- Forum view --}}
    @if ($selectedTab == 'forum')
        <div class="mb-4 mt-4 d-flex justify-content-between">
            <p class="fw-bolder h4">Recent Posts</p>
            <div class="text-center">
                <a href="{{ route('groups.posts.create', ['group' => $group]) }}" class="btn btn-dark btn-sm px-4 py-2 text-decoration-none" style="border-radius: 50px">Make Post</a>
            </div>
        </div>
        <div class="row">
            @foreach($group->groupPosts->where('parent_id', null)->sortByDesc('created_at') as $post)
                <div class="col-md-12">
                    <livewire:post-card :$post :group="$group" :key="$post->id" />
                </div>
            @endforeach
        </div>
    @endif

</div>