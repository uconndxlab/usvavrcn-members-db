<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ManageUserController extends Controller
{
    public function index()
    {
        $users = User::with('entity')->orderBy('name')->get();
        return view('admin.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'is_admin' => 'boolean',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'is_admin' => $request->has('is_admin'),
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'User updated!');
    }

    public function toggleEntityVisibility(User $user)
    {
        if (!$user->entity) {
            return redirect()->back()->with('error', 'This user has no associated entity.');
        }

        $user->entity->is_public = !$user->entity->is_public;
        $user->entity->save();

        return redirect()->back()->with('success', $user->entity->is_public
            ? 'Profile is now public.'
            : 'Profile is now hidden.');
    }

    public function destroy(User $user)
    {
        // Prevent deleting yourself
        if (auth()->id() === $user->id) {
            return redirect()->route('admin.users.index')->with('error', 'You cannot delete your own account from here!');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted!');
    }
}
