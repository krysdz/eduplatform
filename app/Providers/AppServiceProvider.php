<?php

namespace App\Providers;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

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
        Blade::directive('datetime', function ($expression) {
            return "<?php echo ($expression)->format('d.m.Y H:i:s'); ?>";
        });

        Blade::stringable(function (Carbon $datetime) {
            return $datetime->setTimezone('Europe/Warsaw')->format('d.m.Y H:i:s');
        });
    }
}
