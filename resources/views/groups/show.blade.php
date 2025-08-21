@extends('layouts.app')

@section('content')
<div class="container">
    {{-- Breadcrumbs --}}
    <nav aria-label="breadcrumb" class="mb-2">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('groups.index') }}">Groups</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ $group->name }}</li>
        </ol>
    </nav>

    @livewire('group', ['group' => $group])
</div>
@endsection
