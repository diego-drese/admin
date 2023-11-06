<?php

namespace App\Http\Middleware;

use App\Models\Resource;
use Closure;
use Illuminate\Http\Request;

class Acl {
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next) {
        $routeArray     = app('request')->route()->getAction();
        $routeName      = $routeArray['as'];
        $resource      = Resource::checkUser($routeName);

        if($resource === false){
            return response()->json(['message'=>'Resource not found'],404);
        }

        if(!isset($resource->id)){
            return response()->json(['message'=>'Access denied'],403);
        }

        return $next($request);
    }
}
