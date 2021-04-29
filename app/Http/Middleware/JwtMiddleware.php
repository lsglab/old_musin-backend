<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class JwtMiddleware extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next){
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){

                return $this->respond(['message' => 'invalid_token'],401);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){

                $refreshed = JWTAuth::refresh();
                $user = JWTAuth::setToken($refreshed)->toUser();
                // only send the refreshed token back if the cookie is sent with the request
                if($request->cookie('refresh_token') === $user->getRememberToken()){
                    $roleId = $user->role_id;
                    $request->headers->set('Authorization',"Bearer $refreshed");
                }
                else {
                    return $this->respond(['message' => 'token_expired'],403);
                }
            }else{
                // login the public user; This way it doesnt matter whether the user or public sends
                // a request the user can always be retrieved with auth()->user();
                $user = User::where('email','public@lsg.de')->first();
                Auth::login($user);
            }
        }

        return $next($request);
    }

    function respond($array,$status = 200){
        return response()->json($array,$status);
    }
}
