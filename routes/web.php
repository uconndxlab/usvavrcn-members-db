<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EntityController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\GroupController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

// Authentication Routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

Route::middleware(['guest'])->group(function() {
    Route::get('/forgot-password', [PasswordController::class, 'showForgotPassword'])->name('forgot-password');
    Route::post('/forgot-password', [PasswordController::class, 'forgotPassword'])->name('forgot-password');
    Route::get('/reset-password/{token}', [PasswordController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password', [PasswordController::class, 'resetPassword'])->name('password.update');
});

// Redirect root to members (new default)
Route::get('/', function() {
    return redirect()->route('members.index');
});

// New Members and Groups routes
Route::get('members', [MemberController::class, 'index'])->name('members.index');
Route::get('members/{member}', [MemberController::class, 'show'])->name('members.show');

Route::get('groups', [GroupController::class, 'index'])->name('groups.index');
Route::get('groups/{group}', [GroupController::class, 'show'])->name('groups.show');

// Keep existing entity routes for CRUD operations
Route::get('entities', [EntityController::class, 'index'])->name('entities.index');
Route::get('entities/create', [EntityController::class, 'create'])->name('entities.create');
Route::post('entities', [EntityController::class, 'store'])->name('entities.store');
Route::get('entities/{entity}', [EntityController::class, 'show'])->name('entities.show');
Route::get('entities/{entity}/edit', [EntityController::class, 'edit'])->name('entities.edit');
Route::put('entities/{entity}', [EntityController::class, 'update'])->name('entities.update');
Route::delete('entities/{entity}', [EntityController::class, 'destroy'])->name('entities.destroy');

// Group-specific routes
Route::get('groups/{group}/posts', [PostController::class, 'index'])->name('groups.posts');
Route::get('groups/{group}/posts/create', [PostController::class, 'create'])->name('groups.posts.create');
Route::post('groups/{group}/posts', [PostController::class, 'store'])->name('groups.posts.store');

// Public posts
Route::get('posts', [PostController::class, 'publicPosts'])->name('posts.public');

Route::resource('tags', TagController::class)->except(['show']);


