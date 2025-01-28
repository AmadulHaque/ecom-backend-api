<?php

namespace App\Providers;

use App\Models\ShopSetting;
use App\Facades\DynamicFacade;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
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

        DB::statement("SET SESSION sql_mode='STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION'");
        $shop_settings = [];
        if (Schema::hasTable('shop_settings')) {
            $shop_settings = Cache::remember('settings', now()->addMonths(12), function () {
                return ShopSetting::select('key', 'value')->get()->toArray();
            });
        }

        // backend.pages
        $this->loadViewsFrom(resource_path('views/backend/pages'), 'Admin');
        View::addNamespace('RolePermission', base_path('app/Modules/RolePermission/Views'));
        view()->share('shop_settings', $shop_settings);

        // manage dynamic services
        $services = config('services.dynamic_services', []);
        foreach ($services as $serviceName => $serviceClass) {
            $this->app->singleton($serviceName, fn () => new $serviceClass);

            $aliasName = ucfirst($serviceName);
            if (! class_exists($aliasName)) {
                class_alias(DynamicFacade::class, $aliasName);
            }
            DynamicFacade::setFacadeAccessor($serviceName);
        }

        // check permissions
        Blade::if('permission', function ($permissions) {
            if (is_array($permissions)) {
                foreach ($permissions as $permission) {
                    if (Auth::check() && Auth::user()->can($permission) or Auth::user()->role->value == 5) {
                        return true;
                    }
                }
            }

            return Auth::check() && Auth::user()->can($permissions) or Auth::user()->role->value == 5;
        });

        Blade::directive('elsepermission', function () {
            return '<?php else: ?>';
        });

        Paginator::defaultView('pagination::bootstrap-5');
    }
}
