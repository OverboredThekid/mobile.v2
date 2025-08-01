<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\ShiftRequestApi;
use App\Http\Controllers\API\AvailableShiftsApi;
use App\Services\AuthApiService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    protected AuthApiService $authService;

    public function __construct(AuthApiService $authService)
    {
        $this->authService = $authService;
    }

    public function index()
    {
        // Check if user is authenticated
        if (!$this->authService->isAuthenticated()) {
            return redirect()->route('login');
        }

        // Get user data
        $user = $this->authService->getStoredUser();

        // Get counts using API controllers
        $shiftRequestsCount = 0;
        $availableShiftsCount = 0;
        $countsLoading = true;

        try {
            $shiftRequestApi = new ShiftRequestApi();
            $shiftRequestsData = $shiftRequestApi->getCountData();
            $shiftRequestsCount = $shiftRequestsData['count'] ?? 0;

            $availableShiftsApi = new AvailableShiftsApi();
            $availableShiftsData = $availableShiftsApi->getCountData();
            $availableShiftsCount = $availableShiftsData['count'] ?? 0;

            $countsLoading = false;
        } catch (\Exception $e) {
            Log::error('Failed to load dashboard counts: ' . $e->getMessage());
            $countsLoading = false;
        }

        return view('dashboard', compact('user', 'shiftRequestsCount', 'availableShiftsCount', 'countsLoading'));
    }

    public function getCounts()
    {
        $shiftRequestsCount = 0;
        $availableShiftsCount = 0;

        try {
            $shiftRequestApi = new ShiftRequestApi();
            $shiftRequestsData = $shiftRequestApi->getCountData();
            $shiftRequestsCount = $shiftRequestsData['count'] ?? 0;

            $availableShiftsApi = new AvailableShiftsApi();
            $availableShiftsData = $availableShiftsApi->getCountData();
            $availableShiftsCount = $availableShiftsData['count'] ?? 0;
        } catch (\Exception $e) {
            Log::error('Failed to load counts API: ' . $e->getMessage());
        }

        return response()->json([
            'shift_requests_count' => $shiftRequestsCount,
            'available_shifts_count' => $availableShiftsCount,
        ]);
    }
} 