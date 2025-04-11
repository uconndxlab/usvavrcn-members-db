@extends('layouts.app')

@section('content')
<div class="container">
    {{-- Breadcrumbs --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('entities.index') }}">Entities</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $entity->name }}</li>
        </ol>
    </nav>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row">
                {{-- Left: Photo --}}
                <div class="col-md-3 text-center mb-3">
                    @if ($entity->photo_src)
                        <img src="{{ asset('storage/' . $entity->photo_src) }}" class="img-fluid rounded shadow" alt="{{ $entity->name }}">
                    @else
                        <div class="bg-light rounded p-5 text-muted">No Photo</div>
                    @endif
                </div>

                {{-- Right: Details --}}
                <div class="col-md-9">
                    <h2 class="mb-1">{{ $entity->name }}</h2>
                    @if ($entity->job_title)
                        <p class="text-muted mb-2">{{ $entity->job_title }}</p>
                    @endif

                    @if ($entity->email || $entity->phone)
                        <p class="mb-2">
                            @if ($entity->email)
                                <i class="bi bi-envelope"></i> <a href="mailto:{{ $entity->email }}">{{ $entity->email }}</a><br>
                            @endif
                            @if ($entity->phone)
                                <i class="bi bi-telephone"></i> {{ $entity->phone }}
                            @endif
                        </p>
                    @endif

                    @if ($entity->linkedin || $entity->website)
                        <p>
                            @if ($entity->linkedin)
                                <a href="{{ $entity->linkedin }}" target="_blank" class="btn btn-sm btn-outline-primary me-2">LinkedIn</a>
                            @endif
                            @if ($entity->website)
                                <a href="{{ $entity->website }}" target="_blank" class="btn btn-sm btn-outline-secondary">Website</a>
                            @endif
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- More Details --}}
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <h5>Description</h5>
                <p>{{ $entity->description ?? '—' }}</p>
            </div>

            <div class="mb-3">
                <h5>Research Interests</h5>
                <p>{{ $entity->research_interests ?? '—' }}</p>
            </div>

            <div class="mb-3">
                <h5>Projects</h5>
                <p>{{ $entity->projects ?? '—' }}</p>
            </div>

            <div class="mb-3">
                <h5>Career Stage</h5>
                <p>{{ $entity->career_stage ?? '—' }}</p>
            </div>
        </div>

        <div class="col-md-6">
            <div class="mb-3">
                <h5>Primary Institution</h5>
                <p>
                    {{ $entity->primary_institution_name ?? '—' }}<br>
                    {{ $entity->primary_institution_department ?? '' }}<br>
                    {{ $entity->primary_institution_mailing ?? '' }}
                </p>
            </div>

            @if ($entity->secondary_institution_name)
                <div class="mb-3">
                    <h5>Secondary Institution</h5>
                    <p>{{ $entity->secondary_institution_name }}</p>
                </div>
            @endif

            <div class="mb-3">
                <h5>COE Affiliation</h5>
                <p>{{ $entity->coe_affiliation ?? '—' }}</p>
            </div>

            <div class="mb-3">
                <h5>Lab Group</h5>
                <p>{{ $entity->lab_group ?? '—' }}</p>
            </div>

            <div class="mb-3 text-muted">
                <small>
                    Created: {{ $entity->creation_date ? \Carbon\Carbon::parse($entity->creation_date)->format('M j, Y') : '—' }}<br>
                    Updated: {{ $entity->last_updated ? \Carbon\Carbon::parse($entity->last_updated)->format('M j, Y') : '—' }}
                </small>
            </div>
        </div>
    </div>

    {{-- Actions --}}
    <div class="d-flex justify-content-between mt-4">
        <a href="{{ route('entities.edit', $entity) }}" class="btn btn-warning">Edit</a>
        <form action="{{ route('entities.destroy', $entity) }}" method="POST" onsubmit="return confirm('Delete this entity?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
    </div>
</div>
@endsection
