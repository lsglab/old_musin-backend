<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\User;
use Symfony\Component\HttpFoundation\Cookie;
use Illuminate\Http\Response;
use App\Http\Controllers\Base\Controller;


class AuthController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['message' => 'invalid_credentials'],400);
            }
        } catch (JWTException $e) {
            return response()->json(['message' => 'could_not_create_token'], 500);
        }

        $session = true;

        if(count($request->only('remember')) > 0){
            $session = false;
        }

        $user = auth()->user();

        return response()->json(['token'=>$token,'user' =>$user])->withCookie($this->createCookie($request,$session));
    }

    public function createCookie($request,$session){
        $user = auth()->user();

        $rememberToken = $user->getRememberToken();
        $minutes = config('jwt.refresh_ttl');

        // if session is true the cookie will be deleted once the session ends (browser window is closed);
        if($session === true){
            $minutes = null;
        }

        $origin = parse_url(request()->header('origin'))['host'];

        return cookie('refresh_token',$rememberToken,$minutes,'/',$origin,true,true);
    }

    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'role_id' => $request->get('role')
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user','token'),201);
    }

    public function getAuthenticatedUser(){
        $user = auth()->user();

        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Exception $e) {
            if ($e instanceof Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(['token_expired'], $e->getStatusCode());
            } else if ($e instanceof Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['token_invalid'], $e->getStatusCode());
            } else if ($e instanceof Tymon\JWTAuth\Exceptions\JWTException) {
                return response()->json(['token_absent'], $e->getStatusCode());
            }
        }

        return response()->json(['user' => $user]);
    }

    function logout(){
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
