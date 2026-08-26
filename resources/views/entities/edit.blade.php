@extends('layouts.app')

@section('content')
<div class="container">
    <a href="{{ $entity->entity_type === 'group' ? route('groups.show', $entity) : route('members.show', $entity) }}" class="btn btn-sm btn-outline-secondary mb-3">
        &laquo; Back to profile
    </a>
    <form action="{{ route('entities.update', $entity) }}" method="POST">
        @csrf @method('PUT')
        @include('entities.partials.form', [
            'submitButton' => true,
            'submitText' => "Update Profile",
            'title' => "Update Profile"
        ])
    </form>
</div>
@endsection
