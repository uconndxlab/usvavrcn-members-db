@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Groups</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('groups.create') }}" class="btn btn-primary mb-3">Add Group</a>

    <ul class="list-group">
        @foreach ($groups as $group)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                {{ $group->name }}
                <div>
                    <a href="{{ route('groups.edit', $group) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('groups.destroy', $group) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this tag?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </div>
            </li>
        @endforeach
    </ul>
</div>
@endsection
