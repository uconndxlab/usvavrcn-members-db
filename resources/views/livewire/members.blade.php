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
    <div class="container text-center mb-5">
        <h1 class="text-dark fw-normal">Welcome to the <strong>USAVRCN</strong> Member Database</h1>
        <div class="text-light bg-primary py-2 px-4 align-middle d-inline-block w-auto rounded-pill">
            <p class="p-0 m-0">Search, connect, and collaborate across the field of animal vaccinology.</p>
        </div>
    </div>

    {{-- Search/Selectors --}}
    @if($tagCategories && $tagCategories->isNotEmpty())
        <div class="container mb-2">
            <div class="row align-items-start fw-bold py-2 flex-column flex-md-row">
                {{-- Tag categories - appears first on mobile, side by side on desktop --}}
                <div class="col overflow-hidden rounded order-1 order-md-2 mb-3 mb-md-0" style="background-color: rgba(0,0,0,0.05);">
                    <div class="d-flex align-items-start overflow-auto" style="white-space: nowrap;">
                        @foreach($tagCategories as $category)
                            @if($category->tags && $category->tags->isNotEmpty())
                                <div class="d-flex flex-column justify-content-center align-items-center px-1 flex-shrink-0">
                                    <small class="ps-2 pb-0 text-muted text-start w-100 text-uppercase text-nowrap" style="font-size: 0.7em;">{{ $category->name }}</small>
                                    <select class="form-select fw-semibold py-2 rounded-pill" wire:model.change="selection">
                                        <option value="all">All {{ $category->name }}</option>
                                        @foreach($category->tags as $tag)
                                            <option @if(isset($selectedTagIds[$tag->id])) disabled @endif value="{{ $tag->id }}">{{ $tag->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="d-flex flex-column align-items-center my-2">
                                        @foreach($category->tags as $tag)
                                            @if (isset($selectedTagIds[$tag->id]))
                                                <span class="badge bg-primary me-1 mb-1">
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
                <div class="col-12 col-md-auto d-flex flex-column align-items-center justify-content-center px-1 order-2 order-md-1">
                    <small class="ps-2 pb-0 text-muted text-start w-100 text-uppercase text-nowrap d-none d-md-block" style="font-size: 0.7em;">
                        {{-- blank header text so that the input below will align with the other items on desktop --}}
                        &nbsp;
                    </small>
                    <div class="input-group" style="width: 200px;">
                        <span class="input-group-text bg-dark border-0 rounded-start-pill text-white">
                            <i class="bi bi-search"></i>
                        </span>
                        <input wire:model.live.debounce.250ms="searchTerm" type="text" class="light-placeholder text-white form-control bg-dark border-0 rounded-end-pill" placeholder="Search by name...">
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Members Table -->
    <div class="card rounded" style="background-color: rgba(0,0,0,0.05)">
        <div class="card-body text-dark rounded pt-0 px-1">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="text-muted bg-transparent text-uppercase" style="font-size: 0.9em;">Name</th>
                            <th class="text-muted bg-transparent text-uppercase" style="font-size: 0.9em;">Title</th>
                            <th class="text-muted bg-transparent text-uppercase" style="font-size: 0.9em;">Company</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($members as $member)
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