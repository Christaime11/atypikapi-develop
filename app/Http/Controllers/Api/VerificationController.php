<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    /**
     * @param $user_id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     *
     * Permet de vérifier si l'email d'un utilisateur existant en
     * bd est vérifié. S'il n'est pas encore vérifié et que l'utilisateur
     * existe bien en bd on marque l'email comme email vérifié
     */
    public  function verify($user_id, Request $request){
        if( !$request->hasValidSignature() ){
            return response()->json([
                'error' => 'Votre url est invalide ou a expiré'
            ], 400);
        }

        //si l'utilisateur est trouvé en bd
        $user =  User::findOrFail( $user_id );
        if( !$user->hasVerifiedEmail() ){
            $user->markEmailAsVerified();
        }
        return  response()->json([
            'success'=>'Email vérifié avec succès'
        ], 200);
    }

    public function resend(){
        if ( auth()->user()->hasVerifiedEmail() ){
            return response()->json( [
                'infoMessage'=>'Votre email a déjà été vérifié'
            ], 400 );
        }

        auth()->user()->sendEmailVerificationNotification();
        return response()->json([
            'info'=>'Un lien de vérification de votre email vous a été envoyé par mail'
        ],200);
    }
}
