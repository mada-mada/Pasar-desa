<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
  public function boot()
{
    // 1. Ambil URL langsung dari file .env
    $appUrl = env('APP_URL');

    // 2. PAKSA SEMUANYA TANPA SYARAT
    if (!empty($appUrl)) {
        // Paksa skema jadi http
        // Paksa root URL jadi https://ctk3gzc4-8000.asse.devtunnels.ms
        \Illuminate\Support\Facades\URL::forceRootUrl($appUrl);
    }
}
}
