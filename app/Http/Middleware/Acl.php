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
    public function handle(Request $request, Closure $next, $ability = null, $boundModelName = null) {
        $routeArray         = app('request')->route()->getAction();
        $controllerAction   = $routeArray['controller'];
        $controller         = explode('@', $controllerAction);
        $request->headers->set('controller' , $controller);
        $resources          = Resource::verifyUser($controllerAction);

        if($resources === false){
            return response()->json(['message'=>'Resource not found'],404);
        }

        if(!count($resources)){
            return response()->json(['message'=>'Access denied'],403);
        }

        return $next($request);
    }
}
