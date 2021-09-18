<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\VerificationController;
use App\Http\Controllers\Api\HabitatController;
use App\Http\Controllers\Api\ReservationController;
use App\Http\Controllers\Api\CommentairesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|*/

Route::middleware('cors')->group(function(){
    Route::post('/login', [AuthController::class,'login']);
    Route::post('/register', [AuthController::class,'register']); //@Todo secure with client credentials
    Route::get('email/verify/{id}', [VerificationController::class,'verify'])->name('verification.verify');
    Route::get('email/resend', [VerificationController::class,'resend'])->name('verification.resend');


    Route::prefix('habitats')->group(function(){
        Route::get('getAll', [HabitatController::class,'getAllHabitat'])->name('getAllHabitat');
        Route::get('getDetails/{habitat_id}',[HabitatController::class, 'getHabitatDetails'])->name('getHabitatDetails');
        Route::get('getAllTypeHabitats', [HabitatController::class,'getAllTypeHabitat'])->name('getAllTypeHabitat');

    });
});


Route::middleware(['auth:api','cors'])->group( function(){
    Route::prefix('habitats')->group( function(){
        Route::post('add', [HabitatController::class,'addHabitat'])->name('addHabitat');
        Route::post('update/{habitat_id}', [HabitatController::class,'updateHabitat'])->name('updateHabitat');
        Route::get('delete/{habitat_id}', [HabitatController::class,'deleteHabitat'])->name('deleteHabitat');
        Route::post('addNewPropriete/{idHabitat}', [HabitatController::class,'addNewPropriete'])->name('addNewPropriete');

        Route::prefix('reservations')->group(function(){
            Route::post('add/{idHabitat}', [ReservationController::class,'addReservation'])->name('addReservation');
            Route::get('allUsersReservations', [ReservationController::class,'getAllMyReservations'])->name('getAllMyReservations');
            Route::get('details/{idReservation}', [ReservationController::class,'getReservationDetails'])->name('getReservationDetails');
            Route::get('autoCancel/{idReservation}', [ReservationController::class,'autoCancelReservation'])->name('autoCancelReservation');
            Route::get('makePayement/{idReservation}', [ReservationController::class,'makePayement'])->name('makePayement');
        });

    });

    Route::prefix('comments')->group(function(){
        Route::post('add/{idHabitat}', [CommentairesController::class,'addComment'])->name('addComment');
        Route::post('getallcomments', [CommentairesController::class,'getAllcomments'])->name('getAllcomments');
    });

    Route::prefix('users')->group( function(){
        Route::get('usersHabitats', [HabitatController::class,'getUserHabitat'])->name('getUserHabitat');
        Route::post('askAuthorizationToAddHabitat', [UserController::class,'askAuthorizationToAddHabitat'])->name('askAuthorizationToAddHabitat');
        Route::post('updateProfil/{idUser}', [UserController::class,'updateProfil'])->name('updateProfil');
        Route::get('user-profile', [AuthController::class,'userProfileData'])->name('user.profile-data');

    });

});
