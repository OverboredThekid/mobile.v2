<?php

use App\Http\Controllers\DashboardController;
use App\Livewire\Admin\ManagePunches;
use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\Login;
use App\Livewire\Dashboard;
use App\Livewire\Auth\ForgotPassword;
use App\Livewire\Auth\Logout;
use App\Livewire\Company\Chat;
use App\Livewire\User\Shifts;
use App\Livewire\User\ShiftRequests;
use App\Livewire\User\AvailableShifts;
use App\Livewire\Company\Blog;
use App\Livewire\Company\Faq;
use App\Livewire\Company\Resources;
use App\Livewire\Company\Contacts;
use App\Livewire\User\TimeOff;
use App\Livewire\User\Availability;
use App\Livewire\User\MyHours;
use App\Livewire\Ui\Modal\Demo;

// Public routes (no authentication required)
Route::get('/login', Login::class)->name('login');
Route::get('/forgot-password', ForgotPassword::class)->name('forgot-password');
Route::post('/logout', Logout::class)->name('logout');

// Protected routes (require authentication)
Route::middleware(['auth.token'])->group(function () {
    // Blade dashboard (faster loading)
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // API routes for dashboard counts
    Route::get('/api/dashboard/counts', [DashboardController::class, 'getCounts'])->name('dashboard.counts');
    
    // Livewire routes for interactive components
    Route::get('/chat', Chat::class)->name('chat');
    Route::get('/my-shifts', Shifts::class)->name('my-shifts');
    Route::get('/shift-requests', ShiftRequests::class)->name('shift-requests');
    Route::get('/available-shifts', AvailableShifts::class)->name('available-shifts');

    // Company routes
    Route::get('/blog', Blog::class)->name('blog');
    Route::get('/faq', Faq::class)->name('faq');
    Route::get('/resources', Resources::class)->name('resources');
    Route::get('/contacts', Contacts::class)->name('contacts');

    // User management routes
    Route::get('/time-off', TimeOff::class)->name('time-off');
    Route::get('/availability', Availability::class)->name('availability');
    Route::get('/my-hours', MyHours::class)->name('my-hours');

    // Admin routes
    Route::get('/manage-punches', ManagePunches::class)->name('manage-punches');
    
    // Modal Demo Route
    Route::get('/modal-demo', Demo::class)->name('modal-demo');
});