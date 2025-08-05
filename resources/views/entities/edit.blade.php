@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Entity</h1>
    <form action="{{ route('entities.update', $entity) }}" method="POST">
        @csrf @method('PUT')
        @include('entities.partials.form')

        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="{{ route('entities.show', $entity) }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
