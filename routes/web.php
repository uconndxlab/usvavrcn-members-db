<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EntityController;
use App\Http\Controllers\TagController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('entities', [EntityController::class, 'index'])->name('entities.index');
Route::get('entities/create', [EntityController::class, 'create'])->name('entities.create');
Route::post('entities', [EntityController::class, 'store'])->name('entities.store');
Route::get('entities/{entity}', [EntityController::class, 'show'])->name('entities.show');
Route::get('entities/{entity}/edit', [EntityController::class, 'edit'])->name('entities.edit');
Route::put('entities/{entity}', [EntityController::class, 'update'])->name('entities.update');
Route::delete('entities/{entity}', [EntityController::class, 'destroy'])->name('entities.destroy');




Route::resource('tags', TagController::class)->except(['show']);


