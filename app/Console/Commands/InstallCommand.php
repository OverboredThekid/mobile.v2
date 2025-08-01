<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:install';
    protected $description = 'Run initial install setup for the application';

    public function handle(): int
    {
        $this->info('⚙️ Running install tasks...');

        // Example: publish config or run setup logic
        $this->call('migrate:fresh');

        $this->info('✅ Installation complete.');

        return self::SUCCESS;
    }
}
