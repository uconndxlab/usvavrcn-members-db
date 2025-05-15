@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Entity</h1>
    <form action="{{ route('entities.update', $entity) }}" method="POST">
        @csrf @method('PUT')
        @include('entities.partials.form')

        <div class="mb-3">
            <label for="tags" class="form-label">Tags</label>
            <select name="tags[]" id="tags" class="form-select" multiple>
                @foreach ($tags as $tag)
                    <option value="{{ $tag->id }}" @selected(in_array($tag->id, old('tags', $selectedTags)))>
                        {{ $tag->name }}
                    </option>
                @endforeach
            </select>
            <small class="text-muted">Hold Ctrl (Cmd on Mac) to select multiple tags.</small>
        </div>

        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>
@endsection
