<div class="mb-3">
    <label for="name" class="form-label">Tag Name</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $tag->name ?? '') }}" required>
    @error('name')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
