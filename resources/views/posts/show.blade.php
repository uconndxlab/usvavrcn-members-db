@extends('layouts.app')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb" class="mb-2">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('groups.index') }}">Groups</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
                <a href="{{ route('groups.show', $group) }}">{{ $group->name }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Post: {{ $post->title }}</li>
        </ol>
    </nav>

    {{-- Showcase: display entirety of the post, displayed on its own page --}}
    <livewire:post-card :$post :group="$group" :key="$post->id" :showcase="true" />
</div>
@endsection
