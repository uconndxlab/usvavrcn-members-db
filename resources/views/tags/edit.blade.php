@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Tag</h1>
    <form method="POST" action="{{ route('tags.update', $tag) }}">
        @csrf @method('PUT')
        @include('tags.partials.form')
        <button class="btn btn-primary">Save</button>
    </form>
</div>
@endsection
