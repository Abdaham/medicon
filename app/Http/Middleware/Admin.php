<?php

namespace App\Http\Middleware;

use Closure;

class Admin
{

    public function handle($request, Closure $next)
    {
        if ($request->user()->perfil_id != 1) {
            return redirect()->back();
        }

        return $next($request);
    }
}
