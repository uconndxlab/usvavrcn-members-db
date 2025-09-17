@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Tags</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('tags.create') }}" class="btn btn-primary mb-3">Add Tag</a>

    <ul class="list-group">
        @foreach ($tags as $tag)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                {{ $tag->name }}
                <div>
                    <a href="{{ route('tags.edit', $tag) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('tags.destroy', $tag) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this tag?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </div>
            </li>
        @endforeach
    </ul>
</div>
@endsection
