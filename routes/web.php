<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\PostController;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'index'])->name('home');

Route::get('foro', [QuestionController::class, 'index'])->name('questions.index');

Route::get('foro/crear', [QuestionController::class, 'create'])->name('questions.create')->middleware('auth');
Route::post('foro', [QuestionController::class, 'store'])->name('questions.store')->middleware('auth');

Route::get('foro/{question:slug}/editar', [QuestionController::class, 'edit'])->name('questions.edit')->middleware('auth');
Route::put('foro/{question:slug}', [QuestionController::class, 'update'])->name('questions.update')->middleware('auth', 'can:update,question');



Route::get('foro/{question:slug}', [QuestionController::class, 'show'])->name('questions.show');
Route::delete('questions/{question:slug}', [QuestionController::class, 'destroy'])->name('questions.destroy')->middleware('auth', 'can:delete,question');



Route::post('/answers/{question}', [AnswerController::class, 'store'])->name('answers.store')->middleware('auth');


Route::resource('posts', PostController::class)
    ->parameters(['posts' => 'post:slug']);


Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__.'/auth.php';
