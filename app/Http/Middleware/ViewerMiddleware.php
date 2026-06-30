<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ViewerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
         if ($request->user() && $request->user()->isViewer()) {
            return response()->json([
                'message' => 'Accès refusé. Vous êtes en lecture seule.'
            ], 403);
        }
        return $next($request);
    }
}