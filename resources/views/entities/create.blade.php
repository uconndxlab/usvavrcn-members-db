@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1>Create Profile</h1>
    <form action="{{ route('entities.store') }}" method="POST">
        @csrf
        @include('entities.partials.form', ['submitButton' => false])

        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="btn btn-primary">Create Profile</button>
            <a href="{{ route('entities.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
