<?php

namespace App\Services;

use App\Services\AuthApiService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ApiService
{
    protected $apiUrl;
    protected $http;
    protected $authService;
    
    public function __construct()
    {
        $this->apiUrl = config('app.api_url');
        $this->authService = new AuthApiService();
        
        // Get token using the instance method with proper fallback
        $token = $this->authService->getToken();
        
        $this->http = Http::timeout(30)
            ->withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])
            ->baseUrl($this->apiUrl);
            
        // Only add token if it exists
        if ($token) {
            $this->http = $this->http->withToken($token);
        }
    }

    public function get($url, $hasTeam = false)
    {
        try {
            if ($hasTeam) {
                $user = $this->authService->getStoredUser();
                if (!$user || !isset($user['team_id'])) {
                    throw new \Exception("No valid user or team ID found");
                }
                $teamId = $user['team_id'];
                $url = str_replace('{teamId}', $teamId, $url);
            }
            
            $response = $this->http->get($url);
            if (!$response->successful()) {
                Log::error("API request failed for URL: {$url}", [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'headers' => $response->headers()
                ]);
                
                // If we get a 401, try to refresh the token
                if ($response->status() === 401) {
                    Log::warning("Unauthorized request, attempting to refresh token");
                    $this->refreshToken();
                    
                    // Retry the request with new token
                    $token = $this->authService->getToken();
                    if ($token) {
                        $this->http = $this->http->withToken($token);
                        $response = $this->http->get($url);
                        
                        if (!$response->successful()) {
                            throw new \Exception("API request failed after token refresh with status: " . $response->status());
                        }
                    } else {
                        throw new \Exception("No valid authentication token available");
                    }
                } else {
                    throw new \Exception("API request failed with status: " . $response->status());
                }
            }
            
            $data = $response->json();
            
            // Log the response type for debugging
            Log::debug("API response type for {$url}", [
                'type' => gettype($data),
                'is_array' => is_array($data),
                'is_object' => is_object($data)
            ]);
            
            return $data;
        } catch (\Exception $e) {
            Log::error("API service error for URL: {$url}", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }
    
    /**
     * Attempt to refresh the authentication token
     */
    protected function refreshToken()
    {
        try {
            // Try to get fresh user data which might refresh the token
            $this->authService->getUser();
        } catch (\Exception $e) {
            Log::error("Failed to refresh token: " . $e->getMessage());
        }
    }
}