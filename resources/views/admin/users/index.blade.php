@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Users</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Entity</th>
                    <th>Admin</th>
                    <th>Last Login</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->entity)
                                <div class="d-flex align-items-center justify-content-between">
                                    <a href="{{ route('members.show', $user->entity) }}">{{ $user->entity->name }}</a>
                                    <div class="d-flex align-items-center gap-2">
                                        @if($user->entity->is_public)
                                            <span class="badge bg-success">Public</span>
                                        @else
                                            <span class="badge bg-secondary">Hidden</span>
                                        @endif
                                        <form action="{{ route('admin.users.toggleEntityVisibility', $user) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-secondary">
                                                {{ $user->entity->is_public ? 'Hide' : 'Make public' }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @else
                                <span class="text-muted">No entity</span>
                            @endif
                        </td>
                        <td>
                            @if($user->is_admin)
                                <span class="badge bg-success">Admin</span>
                            @else
                                <span class="badge bg-secondary">User</span>
                            @endif
                        </td>
                        <td>
                            @if($user->last_login)
                                {{ $user->last_login->format('M d, Y') }}
                            @else
                                <span class="text-muted">Never</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-warning">Edit</a>
                            @if(auth()->id() !== $user->id)
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this user? This action cannot be undone.')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
