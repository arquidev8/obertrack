<?php

namespace App\Providers;

use Illuminate\Support\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    protected $policies = [
        Comment::class => CommentPolicy::class,
    ];

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // Establecer el locale en español
        Carbon::setLocale('es');
    }

}
