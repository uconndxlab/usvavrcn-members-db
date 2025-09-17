@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Group</h1>
    <form method="POST" action="{{ route('groups.store') }}">
        @csrf
        @include('admin.groups.partials.form')
        <button class="btn btn-primary">Create</button>
    </form>
</div>
@endsection
