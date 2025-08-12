<div class="container">
    <!-- Tab Navigation -->
    <ul class="nav nav-tabs mb-4" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" href="{{ route('members.index') }}">
                <i class="bi bi-people"></i> Members
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="{{ route('groups.index') }}">
                <i class="bi bi-collection"></i> Groups
            </a>
        </li>
    </ul>

    {{-- Title heading --}}
    <div class="container text-center mb-4">
        <h1 class="text-dark fw-normal">Welcome to the <strong>USAVRCN</strong> Member Database</h1>
        <div class="text-light bg-primary py-2 px-4 align-middle d-inline-block w-auto" style="border-radius: 50px;">
            <p class="p-0 m-0">Search, connect, and collaborate across the field of animal vaccinology.</p>
        </div>
    </div>

    {{-- Search/Selectors --}}
    @if($tagCategories && $tagCategories->isNotEmpty())
        <div class="container mb-4">
            <div class="row align-items-start fw-bold py-2 flex-nowrap overflow-auto">
                <div class="col d-flex flex-column align-items-center px-1 h-100">
                    <small class="ps-2 pb-0 text-muted text-start w-100 text-uppercase text-nowrap" style="font-size: 0.7em;">
                        {{-- blank header text so that the input below will align with the other items --}}
                        &nbsp;
                    </small>
                    <input type="text" class="form-control w-auto px-3" style="border-radius: 50px;" placeholder="Search by name..." wire:model.live.debounce.250ms="searchTerm">
                </div>
                @foreach($tagCategories as $category)
                    @if($category->tags && $category->tags->isNotEmpty())
                        <div class="col d-flex flex-column justify-content-center align-items-center px-1">
                            <small class="ps-2 pb-0 text-muted text-start w-100 text-uppercase text-nowrap" style="font-size: 0.7em;">{{ $category->name }}</small>
                            <select class="form-select w-auto fw-semibold py-2" style="border-radius: 50px;" wire:model.change="selection">
                                <option value="all">All {{ $category->name }}</option>
                                @foreach($category->tags as $tag)
                                    <option @if(isset($selectedTagIds[$tag->id])) disabled @endif value="{{ $tag->id }}">{{ $tag->name }}</option>
                                @endforeach
                            </select>
                            <div class="mt-2 d-flex flex-wrap justify-content-center">
                                @foreach($category->tags as $tag)
                                    @if (isset($selectedTagIds[$tag->id]))
                                        <span class="badge bg-secondary me-1 mb-1">
                                            {{ $tag->name }}
                                            <button type="button" class="btn-close btn-close-white btn-sm" wire:click="removeTag({{ $tag->id }})"></button>
                                        </span>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    @endif

    <hr>

    {{-- <!-- Search and Filter Section -->
    <div class="row mb-4">
        <div class="col-md-8">
            <form method="GET" action="{{ route('members.index') }}" class="d-flex">
                <input class="form-control me-2" type="search" name="search" placeholder="Search members..." 
                       value="{{ request('search') }}">
                <button class="btn btn-outline-secondary" type="submit">
                    <i class="bi bi-search"></i>
                </button>
                @if(request('search'))
                    <a href="{{ route('members.index') }}" class="btn btn-outline-secondary ms-2">
                        <i class="bi bi-x"></i>
                    </a>
                @endif
            </form>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('entities.create') }}" class="btn btn-primary">
                <i class="bi bi-plus"></i> Add Member
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
                                <a href="{{ route('members.index', ['tag' => $tag->id]) }}" 
                                   class="badge text-decoration-none me-1 {{ request('tag') == $tag->id ? 'bg-primary' : 'bg-secondary' }}">
                                    {{ $tag->name }}
                                </a>
                            @endforeach
                        </div>
                        @endif
                    @endforeach
                    @if(request('tag'))
                        <a href="{{ route('members.index') }}" class="btn btn-sm btn-outline-secondary">
                            Clear Filter
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif --}}

    <!-- Members Table -->
    <div class="card">
        <div class="card-body">
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
                        @forelse($members as $member)
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
{{--             
            @if($members->hasPages())
                <div class="d-flex justify-content-center mt-3">
                    {{ $members->links() }}
                </div>
            @endif --}}
        </div>
    </div>
</div>