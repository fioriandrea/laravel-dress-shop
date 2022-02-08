<?php

namespace dress_shop\Http\Middleware;

use Closure;
use dress_shop\DataLayer;

class ProductChecks
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
        $id = $request->route()->parameters()['id'];
        $product = DataLayer::getProduct($id);
        if ($product == null) {
            return redirect()->route('user_error', ['messages' => ['Product not found']]);
        }
        if ($product->status == 'unlisted') {
            return redirect()->route('user_error', ['messages' => ['Product ' . $product->name . ' is unlisted']]);
        }
        return $next($request);
    }
}
