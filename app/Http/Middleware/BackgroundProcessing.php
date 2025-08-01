<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Jobs\LoadDashboardCounts;

class BackgroundProcessing
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Dispatch background jobs for dashboard counts if they're missing
        if ($request->is('/') && Cache::missing('shift_requests_count')) {
            LoadDashboardCounts::dispatch();
        }

        return $response;
    }
} 