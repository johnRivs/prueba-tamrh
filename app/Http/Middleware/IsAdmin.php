<?php

namespace App\Http\Middleware;

use App\Actions\Logout;
use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    function __construct(protected Logout $action) {}

    function handle(Request $request, Closure $next)
    {
        if (! $request->user()->isAdmin) {
            $this->action->handle();

            return redirect('/')->with('status', 'You are not authorized to access this page.');
        }

        return $next($request);
    }
}
