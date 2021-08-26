<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForceSSL
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
		if (env('APP_USE_SSL', false) && !$request->secure()) {
			return redirect()->secure($request->getRequestUri());
		}

        return $next($request);
    }
}
