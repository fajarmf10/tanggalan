<?php

declare(strict_types=1);

namespace Tanggalan\Laravel\Commands;

use Illuminate\Console\Command;

/**
 * Artisan command to install and configure Tanggalan
 */
class TanggalanInstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tanggalan:install
                            {--force : Overwrite existing configuration}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install and configure Tanggalan package';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Installing Tanggalan...');

        // Publish configuration
        $this->call('vendor:publish', [
            '--tag' => 'tanggalan-config',
            '--force' => $this->option('force'),
        ]);

        $this->newLine();
        $this->components->info('Tanggalan installed successfully!');
        $this->newLine();

        $this->line('📅 Available helper functions:');
        $this->line('   • to_hijri($date)');
        $this->line('   • to_javanese($date)');
        $this->line('   • get_weton($date)');
        $this->line('   • from_hijri($year, $month, $day)');

        $this->newLine();
        $this->line('🎨 Carbon macros (if enabled):');
        $this->line('   • Carbon::now()->toHijri()');
        $this->line('   • Carbon::now()->toJavanese()');
        $this->line('   • Carbon::now()->getWeton()');

        $this->newLine();
        $this->line('📖 Documentation: https://github.com/fajarmf10/tanggalan');

        return self::SUCCESS;
    }
}
