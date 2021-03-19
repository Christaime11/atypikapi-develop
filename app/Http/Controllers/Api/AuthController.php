<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;

class AuthController extends Controller
{
    public function register(Request $request){
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'email|required|unique:users',
            'telephone'=>'string|required',
            'adresse'=>'string|required',
            'password' => 'required|confirmed'
        ]);

        if ( $validation->fails() ){
            return response()->json( [
                'error'=>'Les informations envoyées invalides',
                'validationErrors' => $validation->errors()
            ], 400);
        }

        $data =  $validation->validated();

        $data ['password'] =  bcrypt( $request->password );
        $data ['role'] = "user";
        $data ['company_verified_at'] = null;
        $user = User::create( $data );

        if( empty($user) ){
            return response()->json([
                'error'=>'La création de votre compte a échoué veuillez réessayer'
            ],500);
        }

        //envoie d'un mail de vérification d'email
        //event(new Registered($user));
        //$user->sendEmailVerificationNotification();
        $accessToken = $user->createToken("authToken")->accessToken;
        return response()->json([
            'success'=>'Votre compte a été créé avec succcès',
            'user' => $user, 'access_token'=>$accessToken
        ],201);
    }

    public function login(Request $request)
    {
        $validation = Validator::make( $request->all(), [
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if ( $validation->fails() ){
            return response()->json([
                'error'=>'Les informations envoyées sont invalides',
                'validationErrors'=>$validation->errors()
            ],400);
        }

        $loginData = $validation->validated();
        if ( !auth()->attempt( $loginData ) ) {
            return response()->json([
                'error' => ' Identifiants incorrects. Veuillez réessayer'
            ],403);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return response()->json([
            'success'=>'Authentification réussie !',
            'user' => auth()->user(),
            'access_token' => $accessToken
        ],200);

    }

    public function userProfileData()
    {
        $user = auth()->user();
        return response()->json(['user' => $user], 200);
    }
}
