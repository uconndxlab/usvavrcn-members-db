@extends('layouts.app')

@section('content')
<div class="container">
    <form action="{{ route('entities.update', $entity) }}" method="POST">
        @csrf @method('PUT')
        @include('entities.partials.form', [
            'submitButton' => true,
            'submitText' => "Update Profile",
            'title' => "Update Profile"
        ])
    </form>
</div>
@endsection
