<?php

namespace App\Providers;

use App\Models\Invoice;
use App\Models\User;
use Illuminate\Auth\Access\Gate;
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

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Gate::define('can-approve-invoice', function (User $user, Invoice $invoice): bool {
            return $user->id === $invoice->user_id;
        });
        \Gate::define('can-view-invoice', function (User $user, Invoice $invoice): bool {
            return $user->id === $invoice->user_id;
        });
    }
}
