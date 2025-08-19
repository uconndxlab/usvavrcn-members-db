@extends('layouts.app')

@section('content')
<div class="container">
    {{-- Breadcrumbs --}}
    <nav aria-label="breadcrumb" class="mb-2">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('entities.index') }}">Entities</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $entity->name }}</li>
        </ol>
    </nav>

    @if ($entity->entity_type === 'group')
        @livewire('group', ['group' => $entity])        
    @endif
</div>
@endsection
