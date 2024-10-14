<?php

namespace App\Providers;

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
        // Directive pour appliquer les couleurs par index
        Blade::directive('getColorClassByIndex', function ($index) {
            return "<?php 
                \$colors = ['green', 'purple', 'blue', 'yellow', 'orange', 'red'];
                echo \$colors[$index % count(\$colors)];
            ?>";
        });
    }
}
