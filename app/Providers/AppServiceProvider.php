<?php

namespace App\Providers;

use App\Models\Products;
use App\Models\User;
use App\Observers\ProductExpiryObserver;
use App\Observers\ProductsExpiryObserver;
use App\Policies\UsersPolicy;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    protected $policies=[User::class=> UsersPolicy::class];
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(User::class,UsersPolicy::class);

        Model::unguard();
        Paginator::useBootstrapFive();
        //Products::observe(ProductsExpiryObserver::class);
        $this->app->booted(function () {
            $schedule = app(Schedule::class);
            $schedule->command('app:update-expired-products')->daily();
        });
    }
}
