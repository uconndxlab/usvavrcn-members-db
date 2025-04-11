@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Entity</h1>
    <form action="{{ route('entities.update', $entity) }}" method="POST">
        @csrf @method('PUT')
        @include('entities.partials.form')
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>
@endsection
