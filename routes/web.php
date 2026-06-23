<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\Auth\EmployeeLoginController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MantenimientoController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\DireccionController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\TopProductController;
use App\Http\Controllers\ImagenProductoController;
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\Admin\ProductoDocController;
use App\Http\Controllers\BusquedaController;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\AdminLogoController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\ReparacionImagenController;

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/nosotros', [ImagenController::class, 'mostrarBannerN'])->name('nosotros');
Route::get('/buscar-sugerencias', [BusquedaController::class, 'sugerencias'])->name('buscar.sugerencias');
Route::get('/buscar', [BusquedaController::class, 'index'])->name('buscar.resultados');
Route::get('/catalogo/{id_categoria?}', [ProductoController::class, 'mostrarProductosPorCategoria'])->name('categoria.productos');
Route::get('/vermas/{id}', [ProductoController::class, 'verMas'])->name('productos.vermas');
Route::get('/mantenimiento', [MantenimientoController::class, 'mostrarFormularioPublico'])->name('mantenimiento');
Route::get('/reparacion', [ReparacionImagenController::class, 'mostrarFormularioPublico'])->name('reparacion');
Route::get('/mantenimientos', [MantenimientoController::class, 'index'])->name('mantenimientos.index');
Route::post('/submit_mantenimiento', [MantenimientoController::class, 'store'])->name('submit_mantenimiento');
Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');
Route::get('/reportes/create', [ReporteController::class, 'create'])->name('reportes.create');
Route::post('/reportes', [ReporteController::class, 'store'])->name('reportes.store');
Route::get('/reportes/{reporte}', [ReporteController::class, 'show'])->name('reportes.show');

Route::post('/productos/{producto_id}/reviews', [ReviewController::class, 'store'])->middleware('throttle:10,1')->name('reviews.store');
Route::post('/reviews/{id}/like', [ReviewController::class, 'like'])->middleware('throttle:30,1')->name('reviews.like');

/*
|--------------------------------------------------------------------------
| RUTAS EMPLEADOS (PROTEGIDAS)
|--------------------------------------------------------------------------
*/
Route::prefix('employees')->group(function () {
    Route::get('/login', [EmployeeLoginController::class, 'showLoginForm'])->name('employee.login');
    Route::post('/login', [EmployeeLoginController::class, 'login'])->name('employee.login.submit');
    Route::post('/logout', [EmployeeLoginController::class, 'logout'])->name('employee.logout');

    // ==========================================================
    // PROMOCIONES (sin middleware de auth para evitar 404 en submit)
    // ==========================================================
    Route::get('promotions/gestionar', function () {
        $promotions = \App\Models\Promotion::take(4)->get();
        return view('promotions.gestionar', compact('promotions'));
    })->name('promotions.gestionar');

    Route::middleware(['auth:employee'])->group(function () {
        Route::put('/admin/logo', [AdminLogoController::class, 'update'])->name('admin.logo.update');
        Route::delete('/admin/logo', [AdminLogoController::class, 'reset'])->name('admin.logo.reset');
        Route::put('promociones/{id}', [PromotionController::class, 'update'])->name('promociones.update');
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

        // ==========================================================
        // RUTAS PRODUCTOS DESTACADOS
        // ==========================================================
        Route::get('top-products/gestionar', function () {
            $topProducts = \App\Models\TopProduct::all();
            return view('top_products.gestionar', compact('topProducts'));
        })->name('top-products.gestionar');

        Route::post('top-products/reorder', [TopProductController::class, 'reorder'])->name('top-products.reorder');
        Route::post('top-products/rename-section', [TopProductController::class, 'renameSection'])->name('top-products.rename-section');
        Route::get('top-products/check-section/{section}', [TopProductController::class, 'checkSectionProducts'])->name('top-products.check-section');
        Route::delete('top-products/section/{section}', [TopProductController::class, 'destroySection'])->name('top-products.destroy-section');

        Route::resource('top-products', TopProductController::class)->only(['index', 'store', 'update', 'destroy']);
        // ==========================================================

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
            Route::get('videos/banner/create', [ImagenController::class, 'createVideoBanner'])->name('videos.create');
            Route::post('videos/banner', [ImagenController::class, 'storeVideoBanner'])->name('videos.store');
            Route::post('reordenar/{producto_id}', [ImagenProductoController::class, 'reordenar'])->name('productos.imagenes.reordenar');
            Route::post('guardarTodo/{producto_id}', [ImagenProductoController::class, 'guardarTodo'])->name('productos.imagenes.guardarTodo');
        });

        Route::get('imagenes', [ImagenController::class, 'indexImagen'])->name('imagenes.index');
        Route::get('imagenes/create', [ImagenController::class, 'createImagen'])->name('imagenes.create');
        Route::post('imagenes', [ImagenController::class, 'storeImagen'])->name('imagenes.store');
        Route::get('imagenes/{id}', [ImagenController::class, 'showImagen'])->name('imagenes.show');
        Route::get('imagenes/{id}/edit', [ImagenController::class, 'editImagen'])->name('imagenes.edit');
        Route::put('imagenes/{id}', [ImagenController::class, 'updateImagen'])->name('imagenes.update');
        Route::delete('imagenes/{id}', [ImagenController::class, 'destroyImagen'])->name('imagenes.destroy');

        // ✅ MANTENIMIENTOS — movida aquí para que sea del panel admin
        Route::get('/mantenimientos', [MantenimientoController::class, 'index'])->name('mantenimientos.index');
        Route::delete('/mantenimientos/{mantenimiento}', [MantenimientoController::class, 'destroy'])->name('mantenimientos.destroy');
        Route::put('/mantenimientos/{id}/updateStatus', [MantenimientoController::class, 'updateStatus'])->name('mantenimientos.updateStatus');

        Route::delete('/reportes/{id_reporte}', [ReporteController::class, 'eliminar'])->name('reportes.eliminar');
        Route::get('/reportes/{reporte}/edit', [ReporteController::class, 'edit'])->name('reportes.edit');
        Route::put('/reportes/{reporte}', [ReporteController::class, 'update'])->name('reportes.update');
        Route::delete('/reportes/{reporte}', [ReporteController::class, 'destroy'])->name('reportes.destroy');
        Route::put('productos/{id}/video', [ProductoController::class, 'updateVideo'])->name('productos.video.update');
        Route::delete('productos/{id}/video', [ProductoController::class, 'destroyVideo'])->name('productos.video.destroy');
        Route::get('/reviews', [ReviewController::class, 'index'])->name('admin.reviews.index');
        Route::put('/reviews/{id}', [ReviewController::class, 'update'])->name('admin.reviews.update');
        Route::delete('/reviews/{id}', [ReviewController::class, 'destroy'])->name('admin.reviews.destroy');
        Route::patch('/reviews/{id}/estado', [ReviewController::class, 'estado'])->name('admin.reviews.estado');

        Route::get('/productos/obtener-siguiente-base/{categoriaId}', [ProductoController::class, 'obtenerSiguienteNumeroBase'])
            ->where('categoriaId', '.*');

        // Imágenes de mantenimiento
        Route::get('/admin/mantenimiento/imagenes', [MantenimientoController::class, 'editImagenes'])
            ->name('admin.mantenimientos.imagenes.edit');
        Route::post('/admin/mantenimiento/imagenes', [MantenimientoController::class, 'updateImagenes'])
            ->name('mantenamientos.imagenes.update');

        // Imágenes de Reparación
        Route::get('/admin/reparacion/imagenes', [ReparacionImagenController::class, 'editImagenes'])
            ->name('admin.reparacion.imagenes.edit');
        Route::post('/admin/reparacion/imagenes', [ReparacionImagenController::class, 'updateImagenes'])
            ->name('admin.reparacion.imagenes.update');

        // ── Festividades ──
        Route::get('/festividades/create', [ImagenController::class, 'createFestividad'])->name('festividades.create');
        Route::post('/festividades', [ImagenController::class, 'storeFestividad'])->name('festividades.store');
        Route::post('/festividades/desactivar', [ImagenController::class, 'desactivarFestividad'])->name('festividades.desactivar');
        Route::get('/festividades/{festividad}/edit', [ImagenController::class, 'editFestividad'])->name('festividades.edit');
        Route::put('/festividades/{festividad}', [ImagenController::class, 'updateFestividad'])->name('festividades.update');
        Route::delete('/festividades/{festividad}', [ImagenController::class, 'destroyFestividad'])->name('festividades.destroy');
        Route::post('/festividades/{festividad}/activar', [ImagenController::class, 'activarFestividad'])->name('festividades.activar');
    });
});