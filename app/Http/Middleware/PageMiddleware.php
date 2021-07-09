<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Storage;
use Closure;

class PageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next){
        error_log("path");

        $path = $request->path();

        if($path !== '/'){
            $path = "/export/".$path;
        } else {
            $path = "/export/";
        }

        if(strpos($path,'.') === false){
            $path = $path.'/index.html';
        }

        $filePath = getcwd().$path;

        $request->merge(['path' => $path]);

        if(file_exists($filePath)){
            return $next($request);
        }

        abort(404);
    }
}
