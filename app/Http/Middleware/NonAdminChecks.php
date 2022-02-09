<?php

namespace dress_shop\Http\Middleware;

use Closure;

class NonAdminChecks
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
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin_error', ['messages' => ['Admins cannot perform such an action.'], 'status' => 403]);
        }
        return $next($request);
    }
}
