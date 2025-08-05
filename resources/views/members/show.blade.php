@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between mb-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar-lg bg-primary rounded-circle d-flex align-items-center justify-content-center text-white me-3">
                                {{ substr($member->full_name, 0, 1) }}
                            </div>
                            <div>
                                <h4 class="mb-1">{{ $member->full_name }}</h4>
                                @if($member->title)
                                    <p class="text-muted mb-0">{{ $member->title }}</p>
                                @endif
                                @if($member->company)
                                    <p class="text-muted mb-0">{{ $member->company }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="btn-group">
                            <a href="{{ route('entities.edit', $member) }}" class="btn btn-outline-primary">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                        </div>
                    </div>

                    @if($member->biography)
                    <div class="mb-4">
                        <h6 class="fw-bold">Biography</h6>
                        <p>{{ $member->biography }}</p>
                    </div>
                    @endif

                    <div class="row">
                        @if($member->email)
                        <div class="col-md-6 mb-3">
                            <h6 class="fw-bold">Email</h6>
                            <a href="mailto:{{ $member->email }}">{{ $member->email }}</a>
                        </div>
                        @endif

                        @if($member->phone)
                        <div class="col-md-6 mb-3">
                            <h6 class="fw-bold">Phone</h6>
                            <a href="tel:{{ $member->phone }}">{{ $member->phone }}</a>
                        </div>
                        @endif

                        @if($member->website)
                        <div class="col-md-6 mb-3">
                            <h6 class="fw-bold">Website</h6>
                            <a href="{{ $member->website }}" target="_blank">{{ $member->website }}</a>
                        </div>
                        @endif

                        @if($member->location)
                        <div class="col-md-6 mb-3">
                            <h6 class="fw-bold">Location</h6>
                            <p class="mb-0">{{ $member->location }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Tags -->
            @if($member->tags && $member->tags->isNotEmpty())
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Tags</h6>
                </div>
                <div class="card-body">
                    @foreach($member->tags->groupBy('category.name') as $categoryName => $tags)
                        <div class="mb-3">
                            <small class="text-muted fw-bold">{{ $categoryName }}:</small>
                            <div class="mt-1">
                                @foreach($tags as $tag)
                                    <span class="badge bg-secondary me-1 mb-1">{{ $tag->name }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Group Memberships -->
            @if($member->memberOf && $member->memberOf->isNotEmpty())
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Group Memberships</h6>
                </div>
                <div class="card-body">
                    @foreach($member->memberOf as $group)
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div>
                                <a href="{{ route('groups.show', $group) }}" class="text-decoration-none">
                                    {{ $group->name }}
                                </a>
                                @if($group->tags && $group->tags->isNotEmpty())
                                    <br>
                                    @foreach($group->tags->take(2) as $tag)
                                        <small class="badge bg-light text-dark">{{ $tag->name }}</small>
                                    @endforeach
                                @endif
                            </div>
                            <small class="text-muted">
                                {{ $group->members->count() }} members
                            </small>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('members.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to Members
        </a>
    </div>
</div>

<style>
.avatar-lg {
    width: 80px;
    height: 80px;
    font-size: 2rem;
}
</style>
@endsection
