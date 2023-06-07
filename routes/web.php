<?php

use App\Http\Controllers\ArtisanController;
use App\Http\Controllers\ProfileController;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/articles/create', [ArtisanController::class, 'create'])->name('articles.create');

Route::post('/articles', [ArtisanController::class, 'store'])->name("articles.store");

Route::get('articles/index',[ArtisanController::class, 'index'])->name("articles.index");

Route::get('articles/{article}', [ArtisanController::class, 'show'])->name('articles.show');

Route::get('articles/edit/{article}',[ArtisanController::class, 'edit'])->name('articles.edit');

Route::PUT('articles/{article}',[ArtisanController::class, 'update'])->name('articles.update');

Route::delete('articles/{article}', [ArtisanController::class, 'destroy'])->name('articles.delete');

require __DIR__.'/auth.php';
