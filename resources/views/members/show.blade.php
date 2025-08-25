@extends('layouts.app')

@section('content')


<div class="container">
    {{-- Members Breadcrumbs --}}
    <nav aria-label="breadcrumb" class="mb-2">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('members.index') }}">Members</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ $member->name }}</li>
        </ol>
    </nav>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    <div class="row">
        <div class="col-lg-8">
            <div class="mb-4">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <h1 class="fw-bolder mb-0 text-dark" style="font-size: 2.5rem;">{{ $member->full_name }}</h1>
                    <div>
                        @can('admin')
                            @php $hasAdmin = App\Models\User::where('entity_id', $member->id)->first()->is_admin @endphp
                            <form action="{{ route('members.toggleAdmin', $member) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger rounded-pill px-3 text-decoration-none">
                                    <i class="bi bi-lock"></i>
                                    <span>
                                        @if ($hasAdmin)
                                            Revoke Admin
                                        @else
                                            Grant Admin
                                        @endif
                                    </span>
                                </button>
                            </form>
                        @endcan
                        @can('edit-member', $member)
                            <a href="{{ route('entities.edit', $member) }}" class="btn btn-sm btn-primary rounded-pill px-3 text-decoration-none">
                                <i class="bi bi-pencil"></i>
                                <span>Edit</span>
                            </a>
                        @endcan
                    </div>
                </div>
                @if (!empty($member->job_title))
                    <span class="badge bg-primary rounded-pill px-4 py-3" style="font-size:1rem">{{ $member->job_title }}</span>
                @endif
            </div>

            <div class="mb-4">
                @if (!empty($member->email))
                    <div class="mb-2">
                        <i class="bi bi-send text-primary me-2"></i>
                        <a href="mailto:{{ $member->email }}" class="text-decoration-none fw-semibold text-dark">{{ $member->email }}</a>
                    </div>
                @endif
                @if (!empty($member->phone))
                    <div class="mb-2">
                        <i class="bi bi-telephone text-primary me-2"></i>
                        <a href="tel:{{ $member->phone }}" class="text-decoration-none fw-semibold text-dark">{{ $member->phone }}</a>
                    </div>
                @endif
                @if (!empty($member->website))
                    <div class="mb-2">
                        <i class="bi bi-globe text-primary me-2"></i>
                        <a href="{{ $member->website }}" target="_blank" class="text-decoration-none fw-semibold text-dark">{{ $member->website }}</a>
                    </div>
                @endif
            </div>

            <div class="mb-5">
                <h4 class="fw-bold mb-3 text-dark">Biography</h4>
                <p class="text-muted lh-lg">{{ $member->biography }}</p>
            </div>

            <div class="mb-5">
                <h4 class="fw-bold mb-3 text-dark">Research Interests</h4>
                <p class="text-muted lh-lg">{{ $member->research_interests }}</p>
            </div>

            <div class="mb-5">
                <h4 class="fw-bold mb-3 text-dark">Projects</h4>
                <p class="text-muted lh-lg">{{ $member->projects }}</p>
            </div>

            <div class="mb-5 small text-muted">
                <div>Created: {{ $member->created_at->format('M j, Y') }}</div>
                <div>Updated: {{ $member->updated_at->format('M j, Y') }}</div>
            </div>
        </div>

        {{-- Side Panel --}}
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="fw-bold text-dark mb-3 border-0">Primary Institution</h5>
                    <div class="text-muted">{{ $member->primary_institution_name }}</div>
                    <div class="text-muted">{{ $member->primary_institution_department }}</div>
                    <div class="text-muted">{{ $member->primary_institution_mailing }}</div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="fw-bold text-dark mb-3 border-0">Communication Groups</h5>
                    @foreach($member->groups as $group)
                        <div class="mb-2 text-muted">
                            Team: <a href="{{ route('groups.show', $group) }}" class="text-decoration-none text-muted">{{ $group->name }}</a>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="fw-bold text-dark mb-3 border-0">Tags</h5>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($member->tags as $tag)
                            <span class="badge bg-primary rounded-pill">{{ $tag->name }}</span>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="fw-bold text-dark mb-3 border-0">COE Affiliation</h5>
                    <div class="text-muted">{{ $member->affiliation }}</div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="fw-bold text-dark mb-3 border-0">Funding</h5>
                    <div class="text-muted">{{ $member->funding_sources }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5 pt-4 border-top">
        <a href="{{ route('members.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to Members
        </a>
    </div>
</div>
@endsection
