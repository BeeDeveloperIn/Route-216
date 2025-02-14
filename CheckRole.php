<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\DocBlock\Tags\Reference\Url;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // if is customer
        // if ($request->user()->is_customer) {
        //     return redirect(\url('/'));
        // }

        return $next($request);
    }
}
