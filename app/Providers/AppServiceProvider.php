<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\FlashSale;
use Illuminate\Support\Facades\View;

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
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $flashSale = FlashSale::where('start_time', '<=', now())
                ->where('end_time', '>=', now())
                ->latest()
                ->first();

            $view->with('flashSale', $flashSale);
        });
    }
}
