<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [App\Http\Controllers\Auth\LoginController::class,'showLoginForm'])->name('login');

Auth::routes();

Route::middleware(['auth','admin'])->group(function(){
    Route::prefix('type-habitat')->group(function(){
        Route::get('/', [\App\Http\Controllers\Admin\ManageHabitatsController::class,'listTypeHabitat'])->name('listTypeHabitat');
        Route::get('liste', [\App\Http\Controllers\Admin\ManageHabitatsController::class,'listTypeHabitat'])->name('listTypeHabitat');
        Route::post('add', [\App\Http\Controllers\Admin\ManageHabitatsController::class,'addTypeHabitat'])->name('addTypeHabitat');
        Route::post('update/{idTypeHabitat}', [\App\Http\Controllers\Admin\ManageHabitatsController::class,'updateTypeHabitat'])->name('updateTypeHabitat');
        Route::get('delete/{idTypeHabitat}', [\App\Http\Controllers\Admin\ManageHabitatsController::class,'deleteTypeHabitat'])->name('deleteTypeHabitat');
    });

    Route::prefix('habitats')->group(function(){
        Route::get('tous-les-habitats', [\App\Http\Controllers\Admin\ManageHabitatsController::class,'getAllHabitat'] )->name('getAllHabitat');
        Route::get('habitats-en-attentes-de-validation', [\App\Http\Controllers\Admin\ManageHabitatsController::class,'getUnValidatedHabitat'] )->name('getUnValidatedHabitat');
        Route::get('valider-habitat/{idHabitat}', [\App\Http\Controllers\Admin\ManageHabitatsController::class,'validateHabitat'] )->name('validateHabitat');
        Route::get('annuler-validdation-habitat/{idHabitat}', [\App\Http\Controllers\Admin\ManageHabitatsController::class,'unValidateHabitat'] )->name('unValidateHabitat');
        Route::get('details-habitat/{idHabitat}', [\App\Http\Controllers\Admin\ManageHabitatsController::class,'getDetailHabitat'] )->name('getDetailHabitat');
    });

    Route::prefix('propriete-dynamique')->group(function(){
        Route::get('toutes-les-proprietes', [\App\Http\Controllers\Admin\ManageHabitatsController::class,'listProrieteTypeHabitat'] )->name('listProrieteTypeHabitat');
        Route::post('add', [\App\Http\Controllers\Admin\ManageHabitatsController::class,'addProrieteTypeHabitat'] )->name('addProrieteTypeHabitat');
        Route::post('update/{prorieteTypeHabitateId}', [\App\Http\Controllers\Admin\ManageHabitatsController::class,'updateProrieteTypeHabitat'] )->name('updateProrieteTypeHabitat');
        Route::get('delete/{prorieteTypeHabitateId}', [\App\Http\Controllers\Admin\ManageHabitatsController::class,'deleteProrieteTypeHabitat'] )->name('deleteProrieteTypeHabitat');
    });

    Route::prefix('utilisateurs')->group(function(){
        Route::get('demandes-autorisations',[\App\Http\Controllers\Admin\ManageUsersController::class,'usersWhoWanToAddHabitat'])->name('usersWhoWanToAddHabitat');
        Route::get('autoriser-ajout-habitat/{idUser}',[\App\Http\Controllers\Admin\ManageUsersController::class,'authorizeUserToAddHabitat'])->name('authorizeUserToAddHabitat');
        Route::get('supprimer-autoriser-ajout-habitat/{idUser}',[\App\Http\Controllers\Admin\ManageUsersController::class,'unAuthorizeUserToAddHabitat'])->name('unAuthorizeUserToAddHabitat');
    });
});



