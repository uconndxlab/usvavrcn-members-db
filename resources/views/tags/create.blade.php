@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Tag</h1>
    <form method="POST" action="{{ route('tags.store') }}">
        @csrf
        @include('tags.partials.form')
        <button class="btn btn-primary">Create</button>
    </form>
</div>
@endsection
