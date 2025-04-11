@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1>Add Entity</h1>
    <form action="{{ route('entities.store') }}" method="POST">
        @csrf
        @include('entities.partials.form')
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
</div>
@endsection
