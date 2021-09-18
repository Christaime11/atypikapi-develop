<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller {
    public $token = true;

     /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function register(Request $request) {
 
        $validator = Validator::make($request->all(), 
        [ 
            'name' => 'required',
            'email' => 'email|required|unique:users',
            'telephone'=>'string|required',
            'adresse'=>'string|required',
            'password' => 'required|confirmed'
        ]);  
 
        if ($validator->fails()) {  
            return response()->json(['error'=>$validator->errors()], 401); 
        }   
 
 
        $data =  $validator->validated();

        $data ['password'] =  bcrypt( $request->password );
        $data ['role'] = "user";
        $data ['company_verified_at'] = null;

        $user = User::create( $data );
  
        if ($this->token) {
            return $this->login($request);
        }
  
        return response()->json([
            'success' => 'Votre compte a été créé avec succcès',
            'data' => $data
        ], 201);
    }

    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|string|min:6',
            ]);
 
        if ($validator->fails()) {  
            return response()->json(['error'=>$validator->errors()], 401); 
        }   
 
        //$input = $request->only('email', 'password');
        $jwt_token = null;
  
        if (!$jwt_token = JWTAuth::attempt($validator->validated())) {
            return response()->json([
                'error' => 'Invalid Email or Password',
            ], 401);
        }
  
        return response()->json([
            'success' => 'Vous êtes bien connecté',
            'token' => $jwt_token,
        ]);
    }

    public function userProfileData()  {
        $auth_check = JWTAuth::parseToken()->authenticate();
        if($auth_check){
        return response()->json(['user' => auth()->user()]);
            }else{
            return response()->json([
                'success' => false,
                'message' => 'Veulliez vous authentifier'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        } 
    } 

}