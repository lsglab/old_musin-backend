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
        $token;

        try {
            JWTAuth::parseToken()->authenticate();
            $token = JWTAuth::getToken();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){

                return $this->respond(['message' => 'invalid_token'],401);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                $refresh_token = $request->cookie('refresh_token');

                if($refresh_token != null){
                    $user = User::where('remember_token',$refresh_token)->first();
                    if($user === null){
                        return $this->respond(['message' => 'invalid refresh_token'],403);
                    }
                    $token = auth()->login($user);
                } else {
                    return $this->respond(['message' => 'token_expired'],403);
                }
            }else{
                // login the public user; This way it doesnt matter whether the user or public sends
                // a request the user can always be retrieved with auth()->user();
                $user = User::where('email','public@lsg.de')->first();
                $token = auth()->login($user);
            }
        }

        $reponse = $next($request);
        $reponse->header("Authorization","Bearer $token");
        return $reponse;
    }

    function respond($array,$status = 200){
        return response()->json($array,$status);
    }
}
