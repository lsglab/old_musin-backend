<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthCookie extends BaseMiddleware
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


        $refresh_token = $request->cookie('refresh_token');

        if($refresh_token != null){
            $user = User::where('remember_token',$refresh_token)->first();
            if($user === null){
                return $this->respond(['message' => 'invalid refresh_token'],403);
            }
            auth()->login($user);
        } else {
            $user = User::where('email','public@lsg.de')->first();
            auth()->login($user);
        }

        return $next($request);
    }

    function respond($array,$status = 200){
        return response()->json($array,$status);
    }
}
