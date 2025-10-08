<div class="mb-3">
    <label for="name" class="form-label">Tag Name</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $tag->name ?? '') }}" required>
    @error('name')
        <div class="text-danger">{{ $message }}</div>
    @enderror

    <label for="category_id" class="form-label mt-3">Category</label>
    <select name="category_id" class="form-select">
        <option value="">Select Category</option>
        @foreach (App\Models\TagCategory::all() as $category)
            <option value="{{ $category->id }}" @if(old('category_id', $tag->category->id ?? '') == $category->id) selected @endif>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
    @error('category_id')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
