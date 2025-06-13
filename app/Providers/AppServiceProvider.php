<?php

namespace App\Providers;

use Spatie\Multitenancy\Models\Tenant;
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
         Tenant::forgetCurrent(); // تأكيد إن مفيش تينانت مفعّل حاليًا

    if (auth()->check()) {
        $tenantId = auth()->user()->tenant_id;

        // تفعيل التينانت الحالي للمستخدم
        Tenant::find($tenantId)?->makeCurrent();
    }
    }
}
