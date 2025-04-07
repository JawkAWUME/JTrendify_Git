<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Product;
use App\Policies\ProductPolicy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    protected $policies = [
        Product::class => ProductPolicy::class,
    ];

    public function boot()
    {
        // $this->registerPolicies();
    }
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
}
