<?php

declare(strict_types=1);

namespace Tanggalan\Laravel;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use Tanggalan\Laravel\Carbon\CarbonMixin;
use Tanggalan\Laravel\Commands\TanggalanInstallCommand;
use Tanggalan\Tanggalan;

/**
 * Tanggalan Laravel Service Provider
 *
 * Follows Laravel package development best practices
 */
class TanggalanServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     */
    public function boot(): void
    {
        // Publish configuration file
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/tanggalan.php' => config_path('tanggalan.php'),
            ], 'tanggalan-config');

            // Register commands
            $this->commands([
                TanggalanInstallCommand::class,
            ]);
        }

        // Register Carbon macros if enabled
        if (config('tanggalan.enable_carbon_macros', true)) {
            Carbon::mixin(new CarbonMixin());
        }
    }

    /**
     * Register any package services.
     */
    public function register(): void
    {
        // Merge package configuration
        $this->mergeConfigFrom(
            __DIR__ . '/../config/tanggalan.php',
            'tanggalan'
        );

        // Register Tanggalan as singleton
        $this->app->singleton(Tanggalan::class, function ($app) {
            $adjustment = config('tanggalan.hijri_adjustment', 0);
            return Tanggalan::withAdjustment($adjustment);
        });

        // Register facade alias
        $this->app->alias(Tanggalan::class, 'tanggalan');
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [Tanggalan::class, 'tanggalan'];
    }
}
