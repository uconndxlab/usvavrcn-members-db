<div>
    <div class="mb-4">
        <p class="fw-bolder h1">{{ $group->name }}</p>
        <div>
            <span class="h5 fw-normal text-muted me-3 text-dark">{{ $group->members()->count() }} Members</span>
            {{-- if we are not already in the group --}}
            @if (!Auth::user()->entity->groups->contains($group))
                <form method="POST" action="{{ route('groups.join', $group) }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn bg-primary text-white rounded-pill px-4">Join Group</button>
                </form>
            @else
                <form method="POST" action="{{ route('groups.leave', $group) }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger rounded-pill px-4"
                        onclick="return confirm('Are you sure you want to leave this group?');"
                    >Leave Group</button>
                </form>
            @endif
        </div>
    </div>

    <div class="d-flex align-items-center my-3">
        <div class="btn-group btn-group-sm border p-1 rounded-pill" style="background-color: rgba(0,0,0,0.05)" role="group" aria-label="Filter by group type">
            <button type="button"
                    class="btn @if($selectedTab == 'forum') btn-light @endif fw-semibold rounded-pill"
                    wire:click="$set('selectedTab', 'forum')"
            >Forum</button>
            <button type="button"
                    class="btn @if($selectedTab == 'members') btn-light @endif fw-semibold rounded-pill"
                    wire:click="$set('selectedTab', 'members')"
            >Members</button>
        </div>
    </div>
    
    {{-- Members view --}}
    @if ($selectedTab == 'members')

        <div class="card rounded" style="background-color: rgba(0,0,0,0.05)">
            <div class="card-body text-dark rounded py-0 px-1">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="text-muted bg-transparent text-uppercase" style="font-size: 0.9em;">Name</th>
                                <th class="text-muted bg-transparent text-uppercase" style="font-size: 0.9em;">Title</th>
                                <th class="text-muted bg-transparent text-uppercase" style="font-size: 0.9em;">Company</th>
                                @can ('admin')
                                    <th class="text-muted bg-transparent text-uppercase" style="font-size: 0.9em;"></th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($group->members as $member)
                            <tr
                                style="cursor: pointer; @if($loop->first) border-top-left-radius: 0.5rem; border-top-right-radius: 0.5rem; @endif @if($loop->last) border-bottom-left-radius: 0.5rem; border-bottom-right-radius: 0.5rem; @endif"
                                onclick="window.location.href='{{ route('members.show', $member) }}'">
                                <td style="@if($loop->first) border-top-left-radius: 0.5rem; @endif @if($loop->last) border-bottom-left-radius: 0.5rem; @endif">
                                    @if (empty($member->full_name))
                                        <strong class="fst-italic">{{ $member->email }}</strong>
                                    @else
                                        <strong>{{ $member->full_name }}</strong>
                                    @endif
                                </td>
                                <td>{{ !empty($member->job_title) ? $member->job_title : '-' }}</td>
                                <td style="@if($loop->first) border-top-right-radius: 0.5rem; @endif @if($loop->last) border-bottom-right-radius: 0.5rem; @endif">{{ !empty($member->company) ? $member->company : '-' }}</td>
                                @can ('admin')
                                    <td>
                                        <form method="POST" action="{{ route('groups.removeMember', ['group' => $group, 'member' => $member]) }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-link text-danger px-2"
                                                onclick="event.stopPropagation(); return confirm('Are you sure you want to remove this member from the group?');"
                                                title="Remove Member"
                                            >
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                @endcan
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="bi bi-people fs-1"></i>
                                        <p class="mt-2">No members found</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
    
    {{-- Forum view --}}
    @if ($selectedTab == 'forum')
        <div class="mt-4 mb-3 d-flex justify-content-between align-items-center">
            <p class="fw-bolder h4 mb-0">Recent Posts ({{ $group->groupPosts->count() }})</p>
            <div class="text-center">
                <a href="{{ route('groups.posts.create', ['group' => $group]) }}" class="btn btn-dark btn-sm px-4 py-2 text-decoration-none rounded-pill">Make Post</a>
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

@script
<script>
    // tell the nav bar to update the unread posts count
    $wire.on('unread-posts-updated', (e) => {
        const { count } = e;
        new CustomEvent('unread-posts-updated', {
            detail: { count }
        });
    });
</script>
@endscript