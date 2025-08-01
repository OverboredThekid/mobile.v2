<?php

namespace App\Http\Middleware;

use App\Services\AuthApiService;
use Closure;
use Illuminate\Http\Request;

class EnsureTokenIsValid
{
    protected AuthApiService $authService;

    public function __construct(AuthApiService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if user is authenticated via our API service
        if (!$this->authService->isAuthenticated()) {
            // If it's an AJAX/Livewire request, return 401
            if ($request->wantsJson() || $request->header('X-Livewire')) {
                return response()->json(['message' => 'Unauthenticated'], 401);
            }
            
            // For regular requests, redirect to login
            return redirect()->route('login');
        }

        // Optionally verify the token is still valid with the API
        // This is more thorough but makes an API call on each request
        // Uncomment if you want real-time token validation:
        /*
        $user = $this->authService->getUser();
        if (!$user) {
            // Token is invalid/expired, redirect to login
            if ($request->wantsJson() || $request->header('X-Livewire')) {
                return response()->json(['message' => 'Token expired'], 401);
            }
            return redirect()->route('login');
        }
        */

        return $next($request);
    }
}
