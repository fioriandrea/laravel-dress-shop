<?php

namespace dress_shop\Http\Middleware;

use Closure;

class AdminChecks
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->user()->type != 'admin') {
            return redirect()->route('user_error', ['messages' => ['You are not authorized to edit products'], 'status' => 403]);
        }
        return $next($request);
    }
}
