<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Imagen;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View; 
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB; // <-- Asegúrate de tener esta importación

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
        Paginator::useBootstrap();

        try {
            // 1. Registramos el tipo ENUM en Doctrine ANTES de cualquier consulta
            if (class_exists(\Doctrine\DBAL\Types\Type::class)) {
                $databasePlatform = DB::connection()->getDoctrineSchemaManager()->getDatabasePlatform();
                $databasePlatform->registerDoctrineTypeMapping('enum', 'string');
            }

            // 2. Ahora sí, hacemos la lógica del Logo de forma segura
            if (Schema::hasTable('imagenes')) {
                $logoImage = Imagen::where('seccion', 'logo')->first();
                View::share('logoImage', $logoImage);
            }
        } catch (\Exception $e) {
            // Si la base de datos no está lista o está migrando, 
            // atrapamos el error en silencio para que el comando termine con éxito.
        }
    }
}