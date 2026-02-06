<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider; // Importa la clase correcta
use App\Models\Imagen;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;

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
        if (Schema::hasTable('imagenes')) {
            $logoImage = Imagen::where('seccion', 'logo')->first();
            View::share('logoImage', $logoImage);
        }
        Paginator::useBootstrap();
    }
}