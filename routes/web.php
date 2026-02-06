<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\Auth\EmployeeLoginController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ReseñaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MantenimientoController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\TopProductController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\ImagenProductoController;
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\DireccionController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\PagoController;

Route::get('/buscar', [App\Http\Controllers\BusquedaController::class, 'index'])->name('buscar.resultados');

Route::delete('/reportes/{id_reporte}', [ReporteController::class, 'eliminar'])->name('reportes.eliminar');
Route::delete('/mantenimientos/{id}', [MantenimientoController::class, 'eliminar'])->name('mantenimientos.eliminar');

Route::get('/solicitudes/usuario/{id}', [App\Http\Controllers\SolicitudController::class, 'usuario'])->name('solicitudes.usuario');

Route::get('/solicitudes', [App\Http\Controllers\SolicitudController::class, 'index'])->name('solicitudes.index');


Route::get('/pagos/{pago}/detalles', [PagoController::class, 'detallesPago'])->name('pagos.detalles');

Route::middleware(['auth:employee'])->group(function () {
    Route::get('/gestion-pedidos', [PagoController::class, 'gestionPedidos'])->name('pagos.gestion');
    Route::post('/pagos/{id}/actualizar-estado', [PagoController::class, 'actualizarEstado'])->name('pagos.actualizarEstado');
});

Route::get('/pedido/{id}', [PagoController::class, 'index'])->name('pedido');

Route::middleware(['auth'])->group(function () {
    Route::get('/pedidos', [PagoController::class, 'index'])->name('pedidos');
});

Route::post('/paypal/capture-order/{orderId}', [PagoController::class, 'capturePayPalOrder'])->name('paypal.captureOrder');

Route::post('/guardar-direccion-sesion', [PagoController::class, 'guardarDireccionSesion']);

Route::post('/paypal/create-order', [PagoController::class, 'createPayPalOrder'])->name('paypal.createOrder');

Route::get('/carritopago/{id_usuario}', [PagoController::class, 'mostrarPago'])->name('pagar');
Route::post('/procesar-pago', [PagoController::class, 'procesarPago'])->name('procesar.pago');
Route::resource('direcciones', DireccionController::class);

Route::get('/comentarios', [ComentarioController::class, 'index'])->name('comentarios.index');
Route::delete('/comentarios/{id}', [ComentarioController::class, 'destroy'])->name('comentarios.destroy');
Route::post('/comentarios/{producto_id}', [ComentarioController::class, 'store'])->middleware('auth');
Route::get('/comentarios/{producto_id}/{offset}', [ComentarioController::class, 'getComentarios']);

Route::resource('top-products', TopProductController::class)->only(['index', 'update']);
;

Route::get('/productos/agregar', [ProductoController::class, 'create'])->name('productos.create');
Route::post('/productos', [ProductoController::class, 'store'])->name('productos.store');
Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index');
Route::get('/productos/buscar', [ProductoController::class, 'buscar']);

Route::get('/Catalogo/{categoria}', [ProductoController::class, 'index'])->name('Catalogo');
Route::get('/vermas/{id}', [ProductoController::class, 'verMas'])->name('vermas');
Route::get('/vermas/{id}', [ProductoController::class, 'verMas'])->name('productos.vermas');


// Página principal con todos los reportes
Route::get('/', [ReporteController::class, 'index'])->name('reportes.index');
Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index'); // Para listar reportes
Route::post('/reportes', [ReporteController::class, 'store'])->name('reportes.store'); // Para guardar reportes


// Reportes
Route::get('/reportes/create', [ReporteController::class, 'create'])->name('reportes.create');
Route::post('/reportes', [ReporteController::class, 'store'])->name('reportes.store');
Route::get('/reportes/{reporte}', [ReporteController::class, 'show'])->name('reportes.show');
Route::get('/reportes/{reporte}/edit', [ReporteController::class, 'edit'])->name('reportes.edit');
Route::put('/reportes/{reporte}', [ReporteController::class, 'update'])->name('reportes.update');
Route::delete('/reportes/{reporte}', [ReporteController::class, 'destroy'])->name('reportes.destroy');


// Grupo de rutas para empleados autenticados
Route::prefix('employees')->group(function () {
    Route::get('/login', [EmployeeLoginController::class, 'showLoginForm'])->name('employee.login');
    Route::post('/login', [EmployeeLoginController::class, 'login'])->name('employee.login.submit');
    Route::post('/logout', [EmployeeLoginController::class, 'logout'])->name('employee.logout');

    Route::middleware(['auth:employee'])->group(function () {
        Route::get('/admin/dashboard', fn() => view('dashboard.admin'))->name('admin.dashboard');
        Route::get('/soporte/dashboard', fn() => view('dashboard.soporte'))->name('soporte.dashboard');
        Route::get('/tecnico/dashboard', fn() => view('dashboard.tecnico'))->name('tecnico.dashboard');

        // CRUD de empleados
        Route::resource('employees', EmployeesController::class);

        // CRUD de categorías (protegido)
        Route::resource('categorias', CategoriaController::class);

        //CRUD de Colores(Protegido)
        Route::resource('colors', ColorController::class);

        //CRUD de productos(protegido)
        Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index'); // Mostrar lista de productos
        Route::get('/productos/create', [ProductoController::class, 'create'])->name('productos.create'); // Formulario para agregar
        Route::post('/productos', [ProductoController::class, 'store'])->name('productos.store'); // Guardar producto
        Route::get('/productos/{id}/edit', [ProductoController::class, 'edit'])->name('productos.edit'); // Formulario para editar
        Route::put('/productos/{id}', [ProductoController::class, 'update'])->name('productos.update'); // Actualizar producto
        Route::delete('/productos/{id}', [ProductoController::class, 'destroy'])->name('productos.destroy'); // Eliminar producto

        // Rutas para la gestión de imágenes de productos
        Route::prefix('productos/imagenes')->group(function () {
            // Mostrar todas las imágenes de un producto
            Route::get('{producto_id}', [ImagenProductoController::class, 'show'])->name('productos.imagenes.show');

            // Mostrar el formulario para crear una nueva imagen
            Route::get('create/{producto_id}', [ImagenProductoController::class, 'create'])->name('productos.imagenes.create');

            // Almacenar una nueva imagen
            Route::post('/', [ImagenProductoController::class, 'store'])->name('productos.imagenes.store');

            // Mostrar el formulario para editar una imagen existente
            Route::get('edit/{id}', [ImagenProductoController::class, 'edit'])->name('productos.imagenes.edit');

            // Actualizar una imagen existente
            Route::put('{id}', [ImagenProductoController::class, 'update'])->name('productos.imagenes.update');

            // Eliminar una imagen existente
            Route::delete('{id}', [ImagenProductoController::class, 'destroy'])->name('productos.imagenes.destroy');
        });
        // CRUD de reseñas (solo empleados)
        Route::resource('reseñas', ReseñaController::class)->except(['create', 'store', 'index']);

        // Rutas para el controlador de imágenes
        Route::get('imagenes', [ImagenController::class, 'indexImagen'])->name('imagenes.index');
        Route::get('imagenes/create', [ImagenController::class, 'createImagen'])->name('imagenes.create');
        Route::post('imagenes', [ImagenController::class, 'storeImagen'])->name('imagenes.store');
        Route::get('imagenes/{id}', [ImagenController::class, 'showImagen'])->name('imagenes.show');
        Route::get('imagenes/{id}/edit', [ImagenController::class, 'editImagen'])->name('imagenes.edit');
        Route::put('imagenes/{id}', [ImagenController::class, 'updateImagen'])->name('imagenes.update');
        Route::delete('imagenes/{id}', [ImagenController::class, 'destroyImagen'])->name('imagenes.destroy');
    });
});
Route::get('/mantenimientos', [MantenimientoController::class, 'index'])->name('mantenimientos.index');
Route::delete('/mantenimientos/{mantenimiento}', [MantenimientoController::class, 'destroy'])->name('mantenimientos.destroy');
Route::put('mantenimientos/{id}/updateStatus', [MantenimientoController::class, 'updateStatus'])->name('mantenimientos.updateStatus');

Route::get('/categoria/{id}', [CategoriaController::class, 'productosPorCategoria'])->name('categoria.productos');

Route::get('/reseñas', [ReseñaController::class, 'index'])->name('reseñas.index'); // Para mostrar las reseñas (fuera del grupo)
Route::post('/reseñas', [ReseñaController::class, 'store'])->name('reseñas.store'); // Para guardar una nueva reseña

// Grupo de rutas para usuarios autenticados y verificados
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');
    Route::get('/carrito', fn() => view('carrito'))->name('carrito');
    Route::get('/direccion', fn() => view('direccion'))->name('direccion');

    // Rutas CRUD para las reseñas (solo clientes)
    Route::get('/reseñas/create', [ReseñaController::class, 'create'])->name('reseñas.create');
    Route::post('/reseñas', [ReseñaController::class, 'store'])->name('reseñas.store');

    //CRUD de direcciones(protegido)
    Route::resource('direcciones', DireccionController::class);

    // Carrito de compras
    Route::get('/carrito/{id_usuario}', [CarritoController::class, 'mostrarCarrito'])->name('carrito.mostrar'); // Mostrar carrito
    Route::get('/carrito/obtener/{id_usuario}', [CarritoController::class, 'obtener'])->name('carrito.obtener'); // Obtener productos
    Route::put('/carrito/actualizar/{id}', [CarritoController::class, 'actualizar'])->name('carrito.actualizar'); // Actualizar producto
    Route::delete('/carrito/eliminar/{id}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar'); // Eliminar producto
    Route::post('/carrito/agregar', [CarritoController::class, 'agregar'])->name('carrito.agregar');

});

// Página principal
Route::get('/', [HomeController::class, 'index']);

// Rutas de Index (protegidas)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/carrito', fn() => view('carrito'))->name('carrito');
    Route::get('/dirección', fn() => view('dirección'))->name('dirección');
    Route::get('/inicio', fn() => view('home'))->name('inicio');
    Route::get('/pagos', fn() => view('pago'))->name('pagos');
    Route::get('/pagar', fn() => view('carritopago'))->name('pagar');
    Route::get('/pedido', fn() => view('pedido'))->name('pedido');
    Route::post('/submit_mantenimiento', [MantenimientoController::class, 'store'])->name('submit_mantenimiento');

});

Route::get('/nosotros', fn() => view('nosotros'))->name('nosotros');
Route::get('/mantenimiento', fn() => view('mantenimiento'))->name('mantenimiento');
Route::get('/reparación', fn() => view('reparación'))->name('reparación');
Route::get('/vermas', fn() => view('vermas'))->name('vermas');

// Rutas de perfil de usuario
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas para colores
Route::delete('/colors/{color}', [ColorController::class, 'destroy'])->name('colors.destroy');
Route::middleware(['auth:employee'])->group(function () {
    Route::resource('colors', ColorController::class);
});


// Carga de rutas de autenticación
require __DIR__ . '/auth.php';

Route::get('/catalogo/{id_categoria}', [ProductoController::class, 'mostrarProductosPorCategoria'])->name('categoria.productos');
