<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\OffreController;
use App\Http\Controllers\VisualisationController;
use App\Http\Controllers\AdminController;

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

require __DIR__.'/auth.php';

// routes/web.php
Route::get('/dashboardbuilder', function () {
    return view('dashboardbuilder.index'); // Assurez-vous que vous avez une vue pour Dashboard Builder
});

Route::get('/student', [StudentController::class, 'index'])->name('student.index');
Route::get('/offre-details/{id}', [OffreController::class, 'getDetails']);
// Route pour afficher les détails d'une offre d'emploi
Route::get('/student/{id}', [StudentController::class, 'show'])->name('student.show');
Route::get('/visualisation', [VisualisationController::class, 'index'])->name('visualisation.index');


// Routes pour l'administration des offres
Route::get('/admin/offres', [AdminController::class, 'index'])->name('admin.offres.index');
Route::get('/admin/offres/{id}', [AdminController::class, 'show'])->name('admin.offres.show');
Route::delete('/admin/offres/{id}', [AdminController::class, 'destroy'])->name('admin.offres.destroy');

// Route pour afficher la liste des utilisateurs
Route::get('admin/users', [AdminController::class, 'usersIndex'])->name('admin.users.index');

// Route pour supprimer un utilisateur
Route::delete('admin/users/{id}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');