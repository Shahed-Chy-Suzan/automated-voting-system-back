<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ModifyHeader
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (empty($request->headers->get('Content-Type'))) {
            $request->headers->set('Content-Type', 'application/json');
        }

        if ($request->headers->get('Accept') == '*/*') {
            $request->headers->set('Accept', 'application/json');
        }

        $response = $next($request);
        $response->headers->set("Access-Control-Allow-Origin", "*");
        $response->headers->set("Access-Control-Allow-Headers", "Origin, Content-Type, Accept, Authorization, X-Requested-With");
        $response->headers->set("Access-Control-Allow-Methods", "OPTIONS, HEAD, GET, POST, PUT, DELETE");
        $response->headers->set("CrossOrigin", "Anonymous");

        return $response;
    }
}
