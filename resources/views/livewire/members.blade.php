<div class="container">

    <style>
        .light-placeholder::placeholder {
            color: white !important;
            opacity: 0.9;
        }
    </style>

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
            <div class="row align-items-start fw-bold py-2">
                <div class="col-auto d-flex flex-column align-items-center px-1" style="max-width: 220px;">
                    <small class="ps-2 pb-0 text-muted text-start w-100 text-uppercase text-nowrap" style="font-size: 0.7em;">
                        {{-- blank header text so that the input below will align with the other items --}}
                        &nbsp;
                    </small>
                    <input wire:model.live.debounce.250ms="searchTerm" type="text" class="light-placeholder text-white form-control px-3 bg-dark" style="border-radius: 50px; width: 180px;" placeholder="Search by name...">
                </div>
                <div class="col overflow-hidden rounded" style="background-color: rgba(0,0,0,0.025);">
                    <div class="d-flex align-items-start overflow-auto" style="white-space: nowrap;">
                        @foreach($tagCategories as $category)
                            @if($category->tags && $category->tags->isNotEmpty())
                                <div class="d-flex flex-column justify-content-center align-items-center px-1 flex-shrink-0">
                                    <small class="ps-2 pb-0 text-muted text-start w-100 text-uppercase text-nowrap" style="font-size: 0.7em;">{{ $category->name }}</small>
                                    <select class="form-select fw-semibold py-2" style="border-radius: 50px;" wire:model.change="selection">
                                        <option value="all">All {{ $category->name }}</option>
                                        @foreach($category->tags as $tag)
                                            <option @if(isset($selectedTagIds[$tag->id])) disabled @endif value="{{ $tag->id }}">{{ $tag->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="d-flex flex-column align-items-center my-2">
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
            </div>
        </div>
    @endif

    <hr>

    <!-- Members Table -->
    <div class="card bg-light rounded">
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
            {{-- TODO: Figure out livewire pagination --}}
            {{--             
            @if($members->hasPages())
                <div class="d-flex justify-content-center mt-3">
                    {{ $members->links() }}
                </div>
            @endif --}}
        </div>
    </div>
</div>