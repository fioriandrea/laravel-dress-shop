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
            return redirect()->route('error', ['messages' => ['You are not authorized to edit products']]);
        }
        return $next($request);
    }
}
