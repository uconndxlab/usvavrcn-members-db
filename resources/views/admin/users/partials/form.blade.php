<div class="mb-3">
    <label for="name" class="form-label">Name</label>
    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name ?? '') }}" required>
    @error('name')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email ?? '') }}" required>
    @error('email')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" name="password" id="password" class="form-control" placeholder="Leave blank to keep current password">
    <small class="text-muted">Only fill this in if you want to change the password</small>
    @error('password')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="password_confirmation" class="form-label">Confirm Password</label>
    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
</div>

<div class="mb-3 form-check">
    <input type="checkbox" name="is_admin" id="is_admin" class="form-check-input" value="1" {{ old('is_admin', $user->is_admin ?? false) ? 'checked' : '' }}>
    <label class="form-check-label" for="is_admin">
        Administrator
    </label>
    <div class="form-text">Administrators can manage users, groups, and tags</div>
    @error('is_admin')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

@if($user->entity ?? false)
<div class="mb-3">
    <label class="form-label">Associated Entity</label>
    <div>
        <a href="{{ route('members.show', $user->entity) }}" class="btn btn-sm btn-outline-primary">
            View {{ $user->entity->name }}
        </a>
    </div>
</div>
@endif
