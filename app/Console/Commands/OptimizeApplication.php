<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;
use App\Jobs\LoadDashboardCounts;

class OptimizeApplication extends Command
{
    protected $signature = 'app:optimize';
    protected $description = 'Optimize the application for better performance';

    public function handle()
    {
        $this->info('Optimizing application...');

        // Clear all caches
        $this->info('Clearing caches...');
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');

        // Clear application-specific caches
        $this->info('Clearing application caches...');
        Cache::forget('shift_requests_count.value');
        Cache::forget('available_shifts_count.value');
        
        // Clear shifts cache
        for ($tab = 1; $tab <= 3; $tab++) {
            for ($page = 1; $page <= 10; $page++) {
                Cache::forget("shifts_all_page_{$page}");
                Cache::forget("shifts_upcoming_page_{$page}");
                Cache::forget("shifts_past_page_{$page}");
            }
        }

        // Preload dashboard counts in background
        $this->info('Preloading dashboard counts...');
        LoadDashboardCounts::dispatch();

        // Optimize autoloader
        $this->info('Optimizing autoloader...');
        Artisan::call('optimize');

        $this->info('Application optimization completed!');
    }
} 