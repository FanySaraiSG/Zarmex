<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property int $id_usuario
 * @property string $id_producto
 * @property string $id_color
 * @property int $cantidad
 * @property string $precio
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Color $color
 * @property-read \App\Models\Producto $producto
 * @property-read \App\Models\User $usuario
 * @method static \Illuminate\Database\Eloquent\Builder|Carrito newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Carrito newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Carrito query()
 * @method static \Illuminate\Database\Eloquent\Builder|Carrito whereCantidad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Carrito whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Carrito whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Carrito whereIdColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Carrito whereIdProducto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Carrito whereIdUsuario($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Carrito wherePrecio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Carrito whereUpdatedAt($value)
 */
	class Carrito extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $id_categoria
 * @property string $nombre
 * @property string|null $descripcion
 * @property string $creado_en
 * @property string|null $actualizado_en
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Producto> $productos
 * @property-read int|null $productos_count
 * @method static \Illuminate\Database\Eloquent\Builder|Categoria newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Categoria newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Categoria query()
 * @method static \Illuminate\Database\Eloquent\Builder|Categoria whereActualizadoEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Categoria whereCreadoEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Categoria whereDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Categoria whereIdCategoria($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Categoria whereNombre($value)
 */
	class Categoria extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $id_color
 * @property string $nombre
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Color newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Color newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Color query()
 * @method static \Illuminate\Database\Eloquent\Builder|Color whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Color whereIdColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Color whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Color whereUpdatedAt($value)
 */
	class Color extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $id_direccion
 * @property int $user_id
 * @property string $tipo
 * @property string $telefono
 * @property string $pais
 * @property string $estado
 * @property string $ciudad
 * @property string|null $codigo_postal
 * @property string $calle
 * @property string $numero_exterior
 * @property string|null $numero_interior
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Direccion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Direccion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Direccion query()
 * @method static \Illuminate\Database\Eloquent\Builder|Direccion whereCalle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Direccion whereCiudad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Direccion whereCodigoPostal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Direccion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Direccion whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Direccion whereIdDireccion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Direccion whereNumeroExterior($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Direccion whereNumeroInterior($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Direccion wherePais($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Direccion whereTelefono($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Direccion whereTipo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Direccion whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Direccion whereUserId($value)
 */
	class Direccion extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id_empleado
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string|null $telefono
 * @property string $rol
 * @property \Illuminate\Support\Carbon $creado_en
 * @property \Illuminate\Support\Carbon $actualizado_en
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|Employee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee query()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereActualizadoEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereCreadoEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereIdEmpleado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereRol($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereTelefono($value)
 */
	class Employee extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $nombre
 * @property string $imagen_url
 * @property string $seccion
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Imagen newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Imagen newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Imagen query()
 * @method static \Illuminate\Database\Eloquent\Builder|Imagen whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Imagen whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Imagen whereImagenUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Imagen whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Imagen whereSeccion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Imagen whereUpdatedAt($value)
 */
	class Imagen extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $producto_id
 * @property int $orden
 * @property string $ruta
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Producto $producto
 * @method static \Illuminate\Database\Eloquent\Builder|ImagenProducto newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ImagenProducto newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ImagenProducto query()
 * @method static \Illuminate\Database\Eloquent\Builder|ImagenProducto whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImagenProducto whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImagenProducto whereOrden($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImagenProducto whereProductoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImagenProducto whereRuta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImagenProducto whereUpdatedAt($value)
 */
	class ImagenProducto extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $nombre
 * @property string $ocupacion
 * @property string $tipo_maquina
 * @property string $codigo_equipo
 * @property string $descripcion
 * @property string $direccion
 * @property string $estado
 * @property string $codigo_postal
 * @property string|null $correo_electronico
 * @property string|null $numero_celular
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Mantenimiento newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Mantenimiento newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Mantenimiento query()
 * @method static \Illuminate\Database\Eloquent\Builder|Mantenimiento whereCodigoEquipo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mantenimiento whereCodigoPostal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mantenimiento whereCorreoElectronico($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mantenimiento whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mantenimiento whereDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mantenimiento whereDireccion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mantenimiento whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mantenimiento whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mantenimiento whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mantenimiento whereNumeroCelular($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mantenimiento whereOcupacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mantenimiento whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mantenimiento whereTipoMaquina($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mantenimiento whereUpdatedAt($value)
 */
	class Mantenimiento extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $producto_id
 * @property string $largo
 * @property string $ancho
 * @property string $altura
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Producto $producto
 * @method static \Illuminate\Database\Eloquent\Builder|Medida newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Medida newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Medida query()
 * @method static \Illuminate\Database\Eloquent\Builder|Medida whereAltura($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Medida whereAncho($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Medida whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Medida whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Medida whereLargo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Medida whereProductoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Medida whereUpdatedAt($value)
 */
	class Medida extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string $direccion_id
 * @property string $metodo_pago
 * @property string $monto_total
 * @property string $estado
 * @property string|null $transaccion_id
 * @property string|null $detalles
 * @property string|null $productos
 * @property string $estado_interno
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Direccion|null $direccion
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Pago newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pago newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pago query()
 * @method static \Illuminate\Database\Eloquent\Builder|Pago whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pago whereDetalles($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pago whereDireccionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pago whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pago whereEstadoInterno($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pago whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pago whereMetodoPago($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pago whereMontoTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pago whereProductos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pago whereTransaccionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pago whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pago whereUserId($value)
 */
	class Pago extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $nombre
 * @property string|null $descripcion
 * @property string $precio
 * @property int $stock
 * @property string $categoria_id
 * @property string|null $imagen_url
 * @property string $fecha_creacion
 * @property string|null $doc1_url
 * @property string|null $doc2_url
 * @property string|null $doc3_url
 * @property string|null $video_url
 * @property-read \App\Models\Categoria $categoria
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ImagenProducto> $imagenes
 * @property-read int|null $imagenes_count
 * @property-read \App\Models\Medida|null $medida
 * @method static \Illuminate\Database\Eloquent\Builder|Producto newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Producto newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Producto query()
 * @method static \Illuminate\Database\Eloquent\Builder|Producto whereCategoriaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Producto whereDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Producto whereDoc1Url($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Producto whereDoc2Url($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Producto whereDoc3Url($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Producto whereFechaCreacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Producto whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Producto whereImagenUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Producto whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Producto wherePrecio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Producto whereStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Producto whereVideoUrl($value)
 */
	class Producto extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id_reporte
 * @property int $id
 * @property string $tipo_reporte
 * @property string $descripcion
 * @property string $estado
 * @property int|null $id_empleado
 * @property \Illuminate\Support\Carbon $creado_en
 * @property \Illuminate\Support\Carbon $actualizado_en
 * @property-read \App\Models\Employee|null $empleado
 * @property-read \App\Models\User $usuario
 * @method static \Illuminate\Database\Eloquent\Builder|Reporte newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Reporte newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Reporte query()
 * @method static \Illuminate\Database\Eloquent\Builder|Reporte whereActualizadoEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reporte whereCreadoEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reporte whereDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reporte whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reporte whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reporte whereIdEmpleado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reporte whereIdReporte($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reporte whereTipoReporte($value)
 */
	class Reporte extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $producto_id
 * @property string|null $guest_nombre
 * @property string|null $guest_email
 * @property int $calificacion
 * @property string $descripcion
 * @property string $estatus
 * @property string|null $ip
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Review newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Review newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Review query()
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereCalificacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereEstatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereGuestEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereGuestNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereProductoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereUpdatedAt($value)
 */
	class Review extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $key
 * @property string|null $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting query()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereValue($value)
 */
	class Setting extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string|null $product_id
 * @property string $section
 * @property string|null $seccion
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Producto|null $product
 * @method static \Illuminate\Database\Eloquent\Builder|TopProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TopProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TopProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|TopProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TopProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TopProduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TopProduct whereSeccion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TopProduct whereSection($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TopProduct whereUpdatedAt($value)
 */
	class TopProduct extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property mixed $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent implements \Illuminate\Contracts\Auth\MustVerifyEmail {}
}

