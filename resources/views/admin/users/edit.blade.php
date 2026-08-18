@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit User</h1>

    @if($user->entity)
    <div class="mb-3">
        <label class="form-label">Associated Entity</label>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('members.show', $user->entity) }}" class="btn btn-sm btn-outline-primary">
                View {{ $user->entity->name }}
            </a>
            @if($user->entity->is_public)
                <span class="badge bg-success">Public</span>
            @else
                <span class="badge bg-secondary">Hidden</span>
            @endif
            <form action="{{ route('admin.users.toggleEntityVisibility', $user) }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-secondary">
                    {{ $user->entity->is_public ? 'Hide profile' : 'Make profile public' }}
                </button>
            </form>
        </div>
        <div class="form-text">Controls whether this member's profile appears in the public directory.</div>
    </div>
    @endif

    <form method="POST" action="{{ route('admin.users.update', $user) }}">
        @csrf @method('PUT')
        @include('admin.users.partials.form')
        <button class="btn btn-primary">Save</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
