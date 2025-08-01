<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Native\Mobile\Facades\SecureStorage;

class AuthApiService
{
    protected string $apiUrl;
    protected string $authType;

    public function __construct()
    {
        $this->apiUrl = rtrim(config('app.api_url'), '/');
        $this->authType = config('app.auth_type', 'sanctum');
    }

    /**
     * Set secure storage value with fallback for development
     */
    protected function setSecure(string $key, string $value): void
    {
        $success = false;
        
        try {
            $success = SecureStorage::set($key, $value);
        } catch (\Exception $e) {
            $success = false;
        }
        
        // If native storage failed, use session fallback
        if (!$success) {
            session(["secure_storage_{$key}" => $value]);
        }
    }

    /**
     * Get secure storage value with fallback for development
     */
    protected function getSecure(string $key): ?string
    {
        $value = null;
        
        try {
            $value = SecureStorage::get($key);
        } catch (\Exception $e) {
            $value = null;
        }
        
        // If native storage didn't return a value, try session fallback
        if ($value === null) {
            $value = session("secure_storage_{$key}");
        }
        
        return $value;
    }

    /**
     * Delete secure storage value with fallback for development
     */
    protected function deleteSecure(string $key): void
    {
        try {
            SecureStorage::delete($key);
        } catch (\Exception $e) {
            // Continue to session cleanup
        }
        
        // Always clean up session fallback
        session()->forget("secure_storage_{$key}");
    }

    /**
     * Authenticate user with the external API
     */
    public function login(string $email, string $password): array
    {
        try {
            $response = $this->makeRequest()->post('/auth/login', [
                'email' => $email,
                'password' => $password,
                'auth_type' => $this->authType,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                // Handle different response structures
                $token = null;
                if (isset($data['data']['token'])) {
                    $token = $data['data']['token']; // Your API structure
                } elseif (isset($data['token'])) {
                    $token = $data['token']; // Alternative structure
                }
                
                if ($token) {
                    // Store token securely
                    $this->setSecure('auth_token', $token);
                    
                    // Try to get user data with the token
                    $userData = $this->fetchUserData($token);
                    if ($userData) {
                        $this->setSecure('user_data', json_encode($userData));
                    }
                }

                return [
                    'success' => true,
                    'data' => $data,
                    'message' => 'Authentication successful'
                ];
            }

            return [
                'success' => false,
                'message' => $response->json('message') ?? 'Authentication failed',
                'errors' => $response->json('errors', [])
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Connection error: ' . $e->getMessage(),
                'errors' => []
            ];
        }
    }

    /**
     * Fetch user data from API using token
     */
    protected function fetchUserData(string $token): ?array
    {
        try {
            $response = $this->makeAuthenticatedRequest($token)->get('/v1/user');
            
            if ($response->successful()) {
                return $response->json();
            }
            
        } catch (\Exception $e) {
            // Log error but don't fail the login
        }
        
        return null;
    }

    /**
     * Get authenticated user data
     */
    public function getUser(): ?array
    {
        try {
            $token = $this->getSecure('auth_token');
            
            if (!$token) {
                return null;
            }

            $response = $this->makeAuthenticatedRequest($token)->get('/v1/user');

            if ($response->successful()) {
                $userData = $response->json();
                // Update stored user data
                $this->setSecure('user_data', json_encode($userData));
                return $userData;
            }

            // Token might be expired, clear storage
            $this->logout();
            return null;

        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Logout user and clear stored tokens
     */
    public function logout(): bool
    {
        try {
            $token = $this->getSecure('auth_token');
            
            if ($token) {
                // Notify the API of logout
                $this->makeAuthenticatedRequest($token)->post('/auth/logout');
            }

            // Clear stored data
            $this->deleteSecure('auth_token');
            $this->deleteSecure('user_data');

            return true;
        } catch (\Exception $e) {
            // Still clear local storage even if API call fails
            $this->deleteSecure('auth_token');
            $this->deleteSecure('user_data');
            return true;
        }
    }

    /**
     * Check if user is authenticated
     */
    public function isAuthenticated(): bool
    {
        $token = $this->getSecure('auth_token');
        return !empty($token);
    }

    /**
     * Get stored authentication token
     */
    public function getToken(): ?string
    {
        return $this->getSecure('auth_token');
    }

    /**
     * Get stored user data
     */
    public function getStoredUser(): ?array
    {
        $userData = $this->getSecure('user_data');
        return $userData ? json_decode($userData, true) : null;
    }

    /**
     * Make an HTTP request to the API
     */
    protected function makeRequest(): PendingRequest
    {
        return Http::timeout(30)
            ->withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])
            ->baseUrl($this->apiUrl);
    }

    /**
     * Make an authenticated HTTP request to the API
     */
    protected function makeAuthenticatedRequest(string $token): PendingRequest
    {
        return $this->makeRequest()
            ->withToken($token);
    }
} 