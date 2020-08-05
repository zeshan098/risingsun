<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles) {
        if ($request->user() == null) {
            return redirect()->route('login');
        }
        if (!in_array($request->user()->role, $roles)) {
            return response('Unauthorized.', 401);
        }
        return $next($request);
    }

}
