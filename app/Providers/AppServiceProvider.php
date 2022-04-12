<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('route_active', function ($expression) {

            $params = explode(',', $expression);

            $route = $params[0];
            $class = $params[1];

            return "<?php echo Route::currentRouteNamed($route) ? $class : '' ?>";
        });
    }
}
