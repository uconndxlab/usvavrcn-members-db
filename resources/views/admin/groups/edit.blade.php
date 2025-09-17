@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Group</h1>
    <form method="POST" action="{{ route('admin.groups.update', $group) }}">
        @csrf @method('PUT')
        @include('admin.groups.partials.form')
        <button class="btn btn-primary">Save</button>
    </form>
</div>
@endsection
