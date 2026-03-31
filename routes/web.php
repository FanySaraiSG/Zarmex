<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\Auth\EmployeeLoginController;
use App\Http\Controllers\CategoriaController;
//use App\Http\Controllers\ReseñaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MantenimientoController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\TopProductController;
// use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\ImagenProductoController;
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\Admin\ProductoDocController;
use App\Http\Controllers\BusquedaController;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\AdminLogoController;
use App\Http\Controllers\ReviewController;

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/nosotros', [ImagenController::class, 'mostrarBannerN'])->name('nosotros');

Route::get('/buscar-sugerencias', [BusquedaController::class, 'sugerencias'])->name('buscar.sugerencias');
Route::get('/buscar', [BusquedaController::class, 'index'])->name('buscar.resultados');

Route::get('/Catalogo/{categoria}', [ProductoController::class, 'index'])->name('Catalogo');
Route::get('/catalogo/{id_categoria}', [ProductoController::class, 'mostrarProductosPorCategoria'])->name('categoria.productos');
Route::get('/vermas/{id}', [ProductoController::class, 'verMas'])->name('productos.vermas');

Route::get('/mantenimiento', fn() => view('mantenimiento'))->name('mantenimiento');
Route::get('/reparación', fn() => view('reparación'))->name('reparación');

Route::get('/mantenimientos', [MantenimientoController::class, 'index'])->name('mantenimientos.index');
Route::post('/submit_mantenimiento', [MantenimientoController::class, 'store'])->name('submit_mantenimiento');

Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');
Route::get('/reportes/create', [ReporteController::class, 'create'])->name('reportes.create');
Route::post('/reportes', [ReporteController::class, 'store'])->name('reportes.store');
Route::get('/reportes/{reporte}', [ReporteController::class, 'show'])->name('reportes.show');

/* =========================
|  REVIEWS (PÚBLICO)
|  - SIN LOGIN
|  - Se guarda por producto_id
|========================= */
Route::post('/productos/{producto_id}/reviews', [ReviewController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('reviews.store');


/*|
| LOGIN SOLO EMPLEADOS
|--------------------------------------------------------------------------*/
Route::prefix('employees')->group(function () {

    Route::get('/login', [EmployeeLoginController::class, 'showLoginForm'])->name('employee.login');
    Route::post('/login', [EmployeeLoginController::class, 'login'])->name('employee.login.submit');
    Route::post('/logout', [EmployeeLoginController::class, 'logout'])->name('employee.logout');

    Route::middleware(['auth:employee'])->group(function () {

        Route::put('/admin/logo', [AdminLogoController::class, 'update'])->name('admin.logo.update');
        Route::delete('/admin/logo', [AdminLogoController::class, 'reset'])->name('admin.logo.reset');

        Route::get('/admin/dashboard', fn() => view('dashboard.admin'))->name('admin.dashboard');
        Route::get('/soporte/dashboard', fn() => view('dashboard.soporte'))->name('soporte.dashboard');
        Route::get('/tecnico/dashboard', fn() => view('dashboard.tecnico'))->name('tecnico.dashboard');

        Route::get('/gestion-pedidos', [PagoController::class, 'gestionPedidos'])->name('pagos.gestion');
        Route::post('/pagos/{id}/actualizar-estado', [PagoController::class, 'actualizarEstado'])->name('pagos.actualizarEstado');
        Route::get('/pagos/{pago}/detalles', [PagoController::class, 'detallesPago'])->name('pagos.detalles');

        Route::get('/solicitudes', [SolicitudController::class, 'index'])->name('solicitudes.index');
        Route::get('/solicitudes/usuario/{id}', [SolicitudController::class, 'usuario'])->name('solicitudes.usuario');

        Route::resource('employees', EmployeesController::class);
        Route::resource('categorias', CategoriaController::class);
        Route::resource('colors', ColorController::class);
        Route::resource('top-products', TopProductController::class)->only(['index', 'update']);

        Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index');
        Route::get('/productos/create', [ProductoController::class, 'create'])->name('productos.create');
        Route::post('/productos', [ProductoController::class, 'store'])->name('productos.store');
        Route::get('/productos/{id}/edit', [ProductoController::class, 'edit'])->name('productos.edit');
        Route::put('/productos/{id}', [ProductoController::class, 'update'])->name('productos.update');
        Route::post('/productos/{id}/imagenes-extra', [ProductoController::class, 'subirImagenesExtra'])->name('productos.imagenes.extra.store');
        Route::delete('/productos/{id}', [ProductoController::class, 'destroy'])->name('productos.destroy');

        Route::put('/productos/{producto}/docs', [ProductoDocController::class, 'update'])->name('productos.docs.update');

        Route::prefix('productos/imagenes')->group(function () {
            Route::get('{producto_id}', [ImagenProductoController::class, 'show'])->name('productos.imagenes.show');
            Route::get('create/{producto_id}', [ImagenProductoController::class, 'create'])->name('productos.imagenes.create');
            Route::post('/', [ImagenProductoController::class, 'store'])->name('productos.imagenes.store');
            Route::get('edit/{id}', [ImagenProductoController::class, 'edit'])->name('productos.imagenes.edit');
            Route::put('{id}', [ImagenProductoController::class, 'update'])->name('productos.imagenes.update');
            Route::delete('{id}', [ImagenProductoController::class, 'destroy'])->name('productos.imagenes.destroy');
        });

        Route::get('imagenes', [ImagenController::class, 'indexImagen'])->name('imagenes.index');
        Route::get('imagenes/create', [ImagenController::class, 'createImagen'])->name('imagenes.create');
        Route::post('imagenes', [ImagenController::class, 'storeImagen'])->name('imagenes.store');
        Route::get('imagenes/{id}', [ImagenController::class, 'showImagen'])->name('imagenes.show');
        Route::get('imagenes/{id}/edit', [ImagenController::class, 'editImagen'])->name('imagenes.edit');
        Route::put('imagenes/{id}', [ImagenController::class, 'updateImagen'])->name('imagenes.update');
        Route::delete('imagenes/{id}', [ImagenController::class, 'destroyImagen'])->name('imagenes.destroy');

        Route::delete('/mantenimientos/{mantenimiento}', [MantenimientoController::class, 'destroy'])->name('mantenimientos.destroy');
        Route::put('/mantenimientos/{id}/updateStatus', [MantenimientoController::class, 'updateStatus'])->name('mantenimientos.updateStatus');

        Route::delete('/reportes/{id_reporte}', [ReporteController::class, 'eliminar'])->name('reportes.eliminar');
        Route::get('/reportes/{reporte}/edit', [ReporteController::class, 'edit'])->name('reportes.edit');
        Route::put('/reportes/{reporte}', [ReporteController::class, 'update'])->name('reportes.update');
        Route::delete('/reportes/{reporte}', [ReporteController::class, 'destroy'])->name('reportes.destroy');

        /* =========================
        |  ADMIN: REVIEWS / RESEÑAS
        |========================= */
        Route::get('/reviews', [ReviewController::class, 'index'])->name('admin.reviews.index');
        Route::put('/reviews/{id}', [ReviewController::class, 'update'])->name('admin.reviews.update');
        Route::delete('/reviews/{id}', [ReviewController::class, 'destroy'])->name('admin.reviews.destroy');

        // Cambiar estatus (activo/inactivo) desde admin
        Route::patch('/reviews/{id}/estado', [ReviewController::class, 'estado'])->name('admin.reviews.estado');
    });
});