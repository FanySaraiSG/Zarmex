<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ProductoConImagenSeeder extends Seeder
{
    /**
     * Inserta todos los productos y sus imágenes en una sola ejecución.
     * Cada producto registra:
     *   orden 1 → imagen principal (img_* o principal.*)
     *   orden 2 → imagen extra    (extra_*)
     *   orden 3+ → imágenes extra adicionales (cuando hay más de una extra)
     */
    public function run()
    {
        $now = Carbon::now();

        // ── Limpiar tablas respetando foreign keys ─────────────────────────
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('imagenes_productos')->truncate();
        DB::table('productos')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // ── Definición de productos ────────────────────────────────────────
        // Formato: [ id, nombre, descripcion, precio, stock, categoria_id, imagen, imagen_extra ]
        // imagen       = ruta de la imagen principal (orden 1)
        // imagen_extra = ruta(s) extra (orden 2, 3, ...) — string o array
        $productos = [

            // ── CQP ───────────────────────────────────────────────────────
            [
                'id'          => 'ZAR-CQP-001',
                'nombre'      => 'Pelvic bench MOD ZARQ-001',
                'descripcion' => "Medidas\r\nLargo 180cm\r\nAncho 60cm\r\nAltura Std 55-60 cm (Opcional)\r\nBase de Herreria PTR 1 1/4\"\r\nForrada de vinil Automotriz\r\nPinturna electrostatica\r\nAcojinamiento firme de alta densidad\r\nCojin rectangular incluido\r\nEstructura de madera de Pino de 1ra",
                'precio'      => 4000.00,
                'stock'       => 0,
                'categoria_id'=> 'ZAR-CQP',
                'imagen'      => 'images/productos/ZAR-CQP-001/img_1780513993_6a207cc98a36c.jpeg',
                'imagen_extra'=> 'images/productos/ZAR-CQP-001/extra_1780513993_6a207cc9825e0.jpeg',
            ],
            [
                'id'          => 'ZAR-CQP-002',
                'nombre'      => 'Pelvic bench portátil MOD ZARQ-002',
                'descripcion' => "Medidas\r\nLargo 180cm\r\nAncho 60cm\r\nAltura Std 50-55cm (opcional)\r\nBase de Herreria PTR 1\"\r\nForrada de vinil Automotriz\r\nPinturna electrostatica\r\nAcojinamiento firme de alta densidad\r\nCojin rectangular incluido\r\nEstructura de madera de Pino de 1ra",
                'precio'      => 4500.00,
                'stock'       => 0,
                'categoria_id'=> 'ZAR-CQP',
                'imagen'      => 'images/productos/ZAR-CQP-002/img_1780514034_6a207cf2e330e.jpeg',
                'imagen_extra'=> 'images/productos/ZAR-CQP-002/extra_1780514034_6a207cf2e0a4b.jpeg',
            ],
            [
                'id'          => 'ZAR-CQP-003',
                'nombre'      => 'Pelvic bench portátil MOD ZARQ-003',
                'descripcion' => "Medidas\r\nLargo 180cm\r\nAncho 60cm\r\nAltura Std 50-55cm (opcional)\r\nBase de Herreria PTR 1\"\r\nForrada de vinil Automotriz\r\nPinturna electrostatica\r\nAcojinamiento firme de alta densidad\r\nCojin rectangular incluido\r\nEstructura de madera de Pino de 1ra",
                'precio'      => 4500.00,
                'stock'       => 0,
                'categoria_id'=> 'ZAR-CQP',
                'imagen'      => 'images/productos/ZAR-CQP-003/img_1780514034_6a207cf2e330e.jpeg',
                'imagen_extra'=> 'images/productos/ZAR-CQP-003/extra_1780514034_6a207cf2e0a4b.jpeg',
            ],
            [
                'id'          => 'ZAR-CQP-003-02',
                'nombre'      => 'Pelvic bench portátil MOD ZARQ-002',
                'descripcion' => "Medidas\r\nLargo 180cm\r\nAncho 60cm\r\nAltura Std 50-55cm (opcional)\r\nBase de Herreria PTR 1\"\r\nForrada de vinil Automotriz\r\nPinturna electrostatica\r\nAcojinamiento firme de alta densidad\r\nCojin rectangular incluido\r\nEstructura de madera de Pino de 1ra",
                'precio'      => 4500.00,
                'stock'       => 0,
                'categoria_id'=> 'ZAR-CQP',
                'imagen'      => 'images/productos/ZAR-CQP-003-02/img_1780514034_6a207cf2e330e.jpeg',
                'imagen_extra'=> 'images/productos/ZAR-CQP-003-02/extra_1780514034_6a207cf2e0a4b.jpeg',
            ],
            [
                'id'          => 'ZAR-CQP-004',
                'nombre'      => 'Mesa para embarazadas ZARQ-004',
                'descripcion' => "Medidas\r\nLargo 120cm\r\nAncho 50cm\r\nAltura 50cm\r\nEstructura de madera de Pino de 1ra\r\nForrada de vinil automotriz\r\nAcojinamiento firme de alta densidad",
                'precio'      => 4500.00,
                'stock'       => 1,
                'categoria_id'=> 'ZAR-CQP',
                'imagen'      => 'images/productos/ZAR-CQP-004/img_1780514524_6a207edc70db8.jpeg',
                'imagen_extra'=> 'images/productos/ZAR-CQP-004/extra_1780514524_6a207edc6f07f.jpeg',
            ],
            [
                'id'          => 'ZAR-CQP-005',
                'nombre'      => 'Mesa palancas 4 drops ZARQ-005',
                'descripcion' => "Medidas\r\nLargo 165cm\r\nAncho 55cm\r\nAlto 55-60cm\r\nBase de herreria PTR cal 11\r\nForrada vinial automotriz\r\nPintura electroestatica\r\nAcojinamiento firme de alta densidad\r\nDrop Cervical a 45 grados\r\nDrop Toracico, lumbar y pelvico elevación con dirección caudal\r\nPiecera extendible hasta 15cm\r\nFlexión y extención cervical\r\nPalancas y perillas de drops ocultas\r\nPorta papel y corta papel",
                'precio'      => 21000.00,
                'stock'       => 1,
                'categoria_id'=> 'ZAR-CQP',
                'imagen'      => 'images/productos/ZAR-CQP-005/img_1780514709_6a207f95e4dc3.jpeg',
                'imagen_extra'=> 'images/productos/ZAR-CQP-005/extra_1780514709_6a207f95d2ab0.jpeg',
            ],
            [
                'id'          => 'ZAR-CQP-006',
                'nombre'      => 'Mesa bench madera 1 drop ZARQ-006',
                'descripcion' => "Medidas\r\nLargo 180cm\r\nAncho 55cm\r\nAltura 55cm\r\nEstructura y base de madera de pino de 1ra\r\nForrada de vinil automotriz\r\nAcojinamiento firme de alta densidad\r\nDrop Lumbopelvico",
                'precio'      => 12000.00,
                'stock'       => 1,
                'categoria_id'=> 'ZAR-CQP',
                'imagen'      => 'images/productos/ZAR-CQP-006/img_1780514747_6a207fbbcbbe9.jpeg',
                'imagen_extra'=> 'images/productos/ZAR-CQP-006/extra_1780514789_6a207fe5d0978.jpeg',
            ],
            [
                'id'          => 'ZAR-CQP-007',
                'nombre'      => 'Mesa madera drops ZARQ-007',
                'descripcion' => "Medidas\r\nLargo 160cm\r\nAncho 55 cm\r\nAltura 55cm\r\nEstructura y base de madera de pino de 1ra\r\nForrada de vinil automotriz\r\nAcojinamiento firme de alta densidad\r\nPiecera extendible hasta 15cm\r\nFlexión y extención cervical\r\nElevación para upper cervical\r\nDrop cervical a 90 grados\r\nDrop toracico, lumbar y pelcivo con elevación caudal",
                'precio'      => 22000.00,
                'stock'       => 1,
                'categoria_id'=> 'ZAR-CQP',
                'imagen'      => 'images/productos/ZAR-CQP-007/img_1780514848_6a2080207cbcc.jpeg',
                'imagen_extra'=> [
                    'images/productos/ZAR-CQP-007/extra_1780514832_6a2080100655c.jpeg',
                    'images/productos/ZAR-CQP-007-02/img_1780516037_6a2084c5f1c63.jpeg',
                    'images/productos/ZAR-CQP-007-02/extra_1780516037_6a2084c5f1576.jpeg',
                    'images/productos/ZAR-CQP-007-03/img_1780516071_6a2084e790bc0.jpeg',
                    'images/productos/ZAR-CQP-007-03/extra_1780516071_6a2084e7903e6.jpeg',
                ],
            ],
            [
                'id'          => 'ZAR-CQP-008',
                'nombre'      => 'Mesa portátil 3 drops ZARQ-008',
                'descripcion' => "Medidas\r\nLargo 180cm\r\nAncho 55cm\r\nAltura Std 55cm \r\nBase de Herreria PTR 1\"\r\nForrada de vinil Automotriz\r\nPinturna electrostatica\r\nAcojinamiento firme de alta densidad\r\nEstructura de madera de Pino de 1ra\r\nFlexión y extención cervical\r\nDrop cervical 90 grados\r\nDrop toracico y lumbopelvico\r\n\r\nMesa plegable (portatil)\r\nMedidas 60x90x25",
                'precio'      => 16000.00,
                'stock'       => 0,
                'categoria_id'=> 'ZAR-CQP',
                'imagen'      => 'images/productos/ZAR-CQP-008/img_1780514881_6a208041ae9ba.jpeg',
                'imagen_extra'=> [
                    'images/productos/ZAR-CQP-008/extra_1780514881_6a208041ac8bc.jpeg',
                    'images/productos/ZAR-CQP-008-01/img_1780516357_6a20860509665.jpeg',
                    'images/productos/ZAR-CQP-008-01/extra_1780516357_6a20860508bf1.jpeg',
                    'images/productos/ZAR-CQP-008-02/img_1780516397_6a20862db49fa.jpeg',
                    'images/productos/ZAR-CQP-008-02/extra_1780516397_6a20862db4289.jpeg',
                ],
            ],
            [
                'id'          => 'ZAR-CQP-009',
                'nombre'      => 'Mesa herreria 4 drops con tracción lumbar eléctrica ZARQ-009',
                'descripcion' => "Medidas\r\nLargo 165cm\r\nAncho 55cm\r\nAlto 55-60cm\r\nBase de herreria PTR cal 11\r\nForrada vinial automotriz\r\nPintura electroestatica\r\nAcojinamiento firme de alta densidad\r\nDrop Cervical a 45 grados\r\nDrop Toracico, lumbar activación con pedal con dirección caudal\r\nDrop Pelvico Manual activación con palanca con dirección caudal\r\nPiecera extendible hasta 15cm\r\nFlexión y extención cervical\r\nPedales y perillas de drops ocultas\r\nPorta papel y corta papel\r\nTracción lumbar de hasta 20cm\r\nMotor 4000 newtons 110v\r\nPedal al piso para el motor",
                'precio'      => 33000.00,
                'stock'       => 1,
                'categoria_id'=> 'ZAR-CQP',
                'imagen'      => 'images/productos/ZAR-CQP-009/img_1780515103_6a20811f527c0.jpeg',
                'imagen_extra'=> 'images/productos/ZAR-CQP-009/extra_1780515103_6a20811f4f748.jpeg',
            ],
            [
                'id'          => 'ZAR-CQP-010',
                'nombre'      => 'Mesa herreria 4 drops elevación lumbar eléctrica ZARQ-010',
                'descripcion' => "Medidas\r\nLargo 165cm\r\nAncho 55cm\r\nAlto 55-60cm\r\nBase de herreria PTR cal 11\r\nForrada vinial automotriz\r\nPintura electroestatica\r\nAcojinamiento firme de alta densidad\r\nDrop Cervical a 45 grados\r\nDrop Toracico, lumbar activación con pedal con dirección caudal\r\nDrop Pelvico Manual activación con palanca con dirección caudal\r\nPiecera extendible hasta 15cm\r\nFlexión y extención cervical\r\nPedales y perillas de drops ocultas\r\nPorta papel y corta papel\r\nElevación pelvica de hasta 20cm\r\nMotor 4000 newtons 110v\r\nPedal al piso para el motor",
                'precio'      => 33000.00,
                'stock'       => 1,
                'categoria_id'=> 'ZAR-CQP',
                'imagen'      => 'images/productos/ZAR-CQP-010/img_1780515143_6a208147642d4.jpeg',
                'imagen_extra'=> 'images/productos/ZAR-CQP-010/extra_1780515143_6a20814762297.jpeg',
            ],
            [
                'id'          => 'ZAR-CQP-011',
                'nombre'      => 'Mesa herreria 4 drops 2 motores ZARQ-011',
                'descripcion' => "Medidas\r\nLargo 165cm\r\nAncho 55cm\r\nAlto 55-60cm\r\nBase de herreria PTR cal 11\r\nForrada vinial automotriz\r\nPintura electroestatica\r\nAcojinamiento firme de alta densidad\r\nDrop Cervical a 45 grados\r\nDrop Toracico, lumbar y pelvica manual activación con palanca con dirección caudal\r\nPiecera extendible hasta 15cm\r\nFlexión y extención cervical\r\nPalancas y perillas de drops ocultas\r\nPorta papel y corta papel\r\nElevación pelvica de hasta 20cm\r\nAscenso y descenso toracico total de hasta 35cm\r\n2 Motores 4000 newtons 110v\r\nPedales al piso para el motor",
                'precio'      => 35500.00,
                'stock'       => 1,
                'categoria_id'=> 'ZAR-CQP',
                'imagen'      => 'images/productos/ZAR-CQP-011/img_1780515205_6a20818561cbb.jpeg',
                'imagen_extra'=> 'images/productos/ZAR-CQP-011/extra_1780515205_6a2081855fa4b.jpeg',
            ],
            [
                'id'          => 'ZAR-CQP-012',
                'nombre'      => 'Mesa base eléctrica con tracción lumbar eléctrica ZARQ-012',
                'descripcion' => "Medidas\r\nLargo 165\r\nAncho 55\r\nFlexión y extención cervical manual\r\nTracción lumbar de 20 cm motor 110\r\nAltura min 55cm altura máxima 80 cm motor de 6000 newtons\r\nCorreas para sujetar al paciente\r\nDrop pélvico, torácico y cervical manual activación con palanca\r\nExtensión de piecera 15 cm\r\nPlaca base de ¼\r\nEstructura de ptr cal 14 (Todos los equipos)\r\nPintura electrostática\r\nVinil tipo automotriz\r\nControl de mano",
                'precio'      => 43000.00,
                'stock'       => 1,
                'categoria_id'=> 'ZAR-CQP',
                'imagen'      => 'images/productos/ZAR-CQP-012/img_1780515316_6a2081f403305.jpeg',
                'imagen_extra'=> 'images/productos/ZAR-CQP-012/extra_1780515316_6a2081f401477.jpeg',
            ],
            [
                'id'          => 'ZAR-CQP-013',
                'nombre'      => 'Mesa base eléctrica 4 drops ZARQ-013',
                'descripcion' => "Medidas\r\nLargo 165\r\nAncho 55\r\nFlexión y extención cervical manual\r\nAltura min 55cm altura máxima 80 cm motor de 6000 newtons\r\nCorreas para sujetar al paciente\r\nDrop pélvico, lumbar, torácico y cervical manual activación con palanca\r\nExtensión de piecera 15 cm\r\nPlaca base de ¼\r\nEstructura de ptr cal 14 (Todos los equipos)\r\nPintura electrostática\r\nVinil tipo automotriz\r\nControl de pie al piso",
                'precio'      => 37000.00,
                'stock'       => 1,
                'categoria_id'=> 'ZAR-CQP',
                'imagen'      => 'images/productos/ZAR-CQP-013/img_1780515384_6a2082382f753.jpeg',
                'imagen_extra'=> 'images/productos/ZAR-CQP-013/extra_1780515384_6a2082382d24c.jpeg',
            ],
            [
                'id'          => 'ZAR-CQP-014',
                'nombre'      => 'Mesa flexión manual ZARQ-014',
                'descripcion' => "Flexión cervical de 25º extensión cervical de 40º manual\r\nFlexión manual lumbar por 2 pistones de 1000 newtons cada 1\r\nBarra de apoyo desmontable para realizar la flexión lumbar\r\nCorreas para sujetar al paciente\r\nDrop pélvico, drop torácico y drop cervical\r\nLateralidad para escoliosis\r\nMov para pacientes embarazadas\r\nExtensión de piecera 10 cm\r\nEstructura de ptr cal 14 y cal 6\r\nPintura electrostática\r\nVinil tipo automotriz\r\nLargo 165, ancho 55 cm\r\nSoporta 200",
                'precio'      => 35000.00,
                'stock'       => 1,
                'categoria_id'=> 'ZAR-CQP',
                'imagen'      => 'images/productos/ZAR-CQP-014/img_1780515441_6a208271ec586.jpeg',
                'imagen_extra'=> 'images/productos/ZAR-CQP-014/extra_1780515441_6a208271ea34a.jpeg',
            ],
            [
                'id'          => 'ZAR-CQP-015',
                'nombre'      => 'Mesa flexión manual con tracción lumbar manual ZARQ-015',
                'descripcion' => "Flexión cervical de 25º extensión cervical de 40º manual\r\nFlexión manual lumbar por 2 pistones de 1000 newtons cada 1\r\nBarra de apoyo desmontable para realizar la flexión y tracción lumbar\r\nTracción lumbar de hasta 20cm\r\nSeguro para activación y desactivación de tracción\r\nCorreas para sujetar al paciente\r\nDrop pélvico, drop torácico y drop cervical\r\nLateralidad para escoliosis\r\nMov para pacientes embarazadas\r\nExtensión de piecera 10 cm\r\nEstructura de ptr cal 14 y cal 6\r\nPintura electrostática\r\nVinil tipo automotriz\r\nLargo 165, ancho 55 cm\r\nSoporta 200",
                'precio'      => 42000.00,
                'stock'       => 1,
                'categoria_id'=> 'ZAR-CQP',
                'imagen'      => 'images/productos/ZAR-CQP-015/img_1780515492_6a2082a4573e3.jpeg',
                'imagen_extra'=> 'images/productos/ZAR-CQP-015/extra_1780515492_6a2082a453022.jpeg',
            ],
            [
                'id'          => 'ZAR-CQP-017',
                'nombre'      => 'Mesa flexión manual con tracción cervical y tracción lumbar eléctrica ZARQ-017',
                'descripcion' => "Tracción cervical motor 110 abertura de 10 cm\r\nFlexión cervical de 25º extensión cervical de 40º con motor 110\r\nTracción lumbar de 20 cm motor 110\r\nFlexión manual lumbar por 2 pistones de 1000 newtons cada 1\r\nBarra de apoyo desmontable para realizar la flexión lumbar\r\nCorreas para sujetar al paciente\r\nDrop pélvico, torácico y cervical con activación manual\r\nLateralidad para escoliosis\r\nMov para pacientes embarazadas\r\nExtensión de piecera 10 cm\r\nEstructura de ptr cal 14 y cal 6\r\nPintura electrostática\r\nVinil tipo automotriz\r\nControl de mano\r\nLargo 165, ancho 55 cm alto 55- 60cm (opcional)",
                'precio'      => 60000.00,
                'stock'       => 1,
                'categoria_id'=> 'ZAR-CQP',
                'imagen'      => 'images/productos/ZAR-CQP-017/img_1780515638_6a208336059f9.jpeg',
                'imagen_extra'=> 'images/productos/ZAR-CQP-017/extra_1780515638_6a20833601cb7.jpeg',
            ],
            [
                'id'          => 'ZAR-CQP-018',
                'nombre'      => 'Mesa flexión eléctrica ZARQ-018',
                'descripcion' => "Flexión cervical de 25º extensión cervical de 40º manual\r\nFlexión electrica lumbar por 1 motor de 1hp\r\nReductor de velocidad\r\nControl de velocidad para la flexión electrica\r\nCorreas para sujetar al paciente\r\nDrop pélvico, torácico y cervical activación manual\r\nLateralidad para escoliosis\r\nMov para pacientes embarazadas\r\nExtensión de piecera 15 cm\r\nEstructura de ptr cal 14 y cal 6\r\nPintura electrostática\r\nVinil tipo automotriz\r\nLargo 165, ancho 55 cm alto 55-60cm\r\nSoporta 200",
                'precio'      => 67000.00,
                'stock'       => 1,
                'categoria_id'=> 'ZAR-CQP',
                'imagen'      => 'images/productos/ZAR-CQP-018/img_1780515684_6a20836456bc1.jpeg',
                'imagen_extra'=> 'images/productos/ZAR-CQP-018/extra_1780515684_6a20836454ebd.jpeg',
            ],
            [
                'id'          => 'ZAR-CQP-019',
                'nombre'      => 'Mesa flexión eléctrica con tracciones eléctricas ZARQ-019',
                'descripcion' => "Tracción cervical motor 110 abertura de 10 cm\r\nFlexión cervical de 25º extensión cervical de 40º con motor 110\r\nTracción lumbar de 20 cm motor 110\r\nFlexión electrica lumbar por 1 motor de 1hp\r\nReductor de velocidad\r\nControl de velocidad para la flexión electrica\r\nCorreas para sujetar al paciente\r\nDrop pélvico, torácico y cervical con activación manual\r\nLateralidad para escoliosis\r\nMov para pacientes embarazadas\r\nExtensión de piecera 15 cm\r\nEstructura de ptr cal 14 y cal 6\r\nPintura electrostática\r\nVinil tipo automotriz\r\nControl de mano\r\nLargo 165, ancho 55 cm alto 55- 60cm (opcional)",
                'precio'      => 79000.00,
                'stock'       => 1,
                'categoria_id'=> 'ZAR-CQP',
                'imagen'      => 'images/productos/ZAR-CQP-019/img_1780515749_6a2083a5ce1ea.jpeg',
                'imagen_extra'=> 'images/productos/ZAR-CQP-019/extra_1780515749_6a2083a5cb455.jpeg',
            ],
            [
                'id'          => 'ZAR-CQP-020',
                'nombre'      => 'Mesa flexión manual con base eléctrica y tracciones eléctricas ZARQ-020',
                'descripcion' => "Tracción cervical motor 110 abertura de 10 cm\r\nFlexión cervical de 25º extensión cervical de 40º con motor 110\r\nLateralidad manual cervical 40º por lado\r\nTracción lumbar de 20 cm motor 110\r\nAltura min 57cm altura máxima 80 cm motor de 6000 newtons\r\nFlexión manual lumbar por 2 pistones de 1000 newtons cada 1\r\nBarra de apoyo desmontable para realizar la flexión lumbar\r\nCorreas para sujetar al paciente\r\nDrop pélvico, drop torácico y drop cervical\r\nLateralidad para escoliosis\r\nMov para pacientes embarazadas\r\nExtensión de piecera 10 cm\r\nPlaca base de ¼\r\nEstructura de ptr cal 14 (Todos los equipos)\r\nPintura electrostática\r\nVinil tipo automotriz\r\nControl de mano\r\nLargo 165, ancho 55 cm",
                'precio'      => 100000.00,
                'stock'       => 1,
                'categoria_id'=> 'ZAR-CQP',
                'imagen'      => 'images/productos/ZAR-CQP-020/img_1780515802_6a2083da0532c.jpeg',
                'imagen_extra'=> 'images/productos/ZAR-CQP-020/extra_1780515802_6a2083da0309d.jpeg',
            ],
            [
                'id'          => 'ZAR-CQP-021',
                'nombre'      => 'Mesa Pedales 4 drops',
                'descripcion' => "Medidas\r\nLargo 165cm\r\nAncho 55cm\r\nAlto 55-60cm\r\nBase de herreria PTR cal 11\r\nForrada vinil automotriz\r\nPintura electroestatica\r\nAcojinamiento firme de alta densidad\r\nDrop Cervical a 45 grados\r\nDrop Toracico, lumbar y pelvico elevación con dirección caudal\r\nPiecera extendible hasta 15cm\r\nFlexión y extensión cervical\r\nPedales y perillas de drops ocultas\r\nPorta papel y corta papel",
                'precio'      => 24500.00,
                'stock'       => 1,
                'categoria_id'=> 'ZAR-CQP',
                'imagen'      => 'images/productos/ZAR-CQP-021/img_1780515852_6a20840cd39e8.jpeg',
                'imagen_extra'=> 'images/productos/ZAR-CQP-021/extra_1780515852_6a20840cd1dfc.jpeg',
            ],
            [
                'id'          => 'ZAR-CQP-040',
                'nombre'      => 'Equipo ZARQ-040',
                'descripcion' => "S/N",
                'precio'      => 0.00,
                'stock'       => 0,
                'categoria_id'=> 'ZAR-CQP',
                'imagen'      => 'images/productos/ZAR-CQP-040/img_1780604825_6a21df99bbff4.jpeg',
                'imagen_extra'=> 'images/productos/ZAR-CQP-040/extra_1780604825_6a21df99bb613.jpeg',
            ],

            // ── FTA ───────────────────────────────────────────────────────
            [
                'id'          => 'ZAR-FTA-027',
                'nombre'      => 'Mesa Bobath ZARF-027',
                'descripcion' => "Medidas\r\nAlto 40cm\r\nAncho 100cm\r\nLargo 200cm\r\nEstructura y base de madera de pino de 1ra\r\nForrada de vinil automotriz\r\nAcojinamiento firme de alta densidad",
                'precio'      => 12000.00,
                'stock'       => 0,
                'categoria_id'=> 'ZAR-FTA',
                'imagen'      => 'images/productos/ZAR-FTA-027/principal.jpg',
                'imagen_extra'=> 'images/productos/ZAR-FTA-027/extra_1774855228_69ca243ca2037.jpg',
            ],
            [
                'id'          => 'ZAR-FTA-028',
                'nombre'      => 'Mesa estándar ZARF-028',
                'descripcion' => "Medidas\r\nLargo 180cm\r\nAncho 70cm\r\nAltura Std 70-80 cm (Opcional)\r\nBase de Herreria PTR 1 1/4\"\r\nForrada de vinil Automotriz\r\nPintura electrostatica\r\nAcojinamiento firme de alta densidad\r\nEstructura de madera de Pino de 1ra",
                'precio'      => 5500.00,
                'stock'       => 0,
                'categoria_id'=> 'ZAR-FTA',
                'imagen'      => 'images/productos/ZAR-FTA-028/extra_1774855301_69ca2485956ec.jpg',
                'imagen_extra'=> null, // Solo hay una imagen en esta carpeta
            ],
            [
                'id'          => 'ZAR-FTA-029',
                'nombre'      => 'Mesa base eléctrica ZARF-029',
                'descripcion' => "Medidas\r\nLargo 180cm\r\nAncho 70cm\r\nAltura motorizada Std 55-80 cm (Opcional)\r\nBase de Herreria PTR 1 1/4\"\r\nPlaca base de 1/4 140cm x 48cm\r\nForrada de vinil Automotriz\r\nPintura electrostatica\r\nAcojinamiento firme de alta densidad\r\nEstructura de madera de Pino de 1ra",
                'precio'      => 22500.00,
                'stock'       => 0,
                'categoria_id'=> 'ZAR-FTA',
                'imagen'      => 'images/productos/ZAR-FTA-029/principal.jpg',
                'imagen_extra'=> 'images/productos/ZAR-FTA-029/extra_1774855439_69ca250fd88ae.jpg',
            ],

            // ── GNA ───────────────────────────────────────────────────────
            [
                'id'          => 'ZAR-GNA-034',
                'nombre'      => 'Equipo 4 motores especializado ZARG-034',
                'descripcion' => "Base eléctrica\r\nRespaldo eléctrico\r\nPieceras independientes eléctricas\r\nPiecera posa pie abatible y extensible hasta +10cm\r\nAcabado vinil automotriz\r\nPierneras acero inoxidable ajustables a altura\r\nLampara ginecológica con brazo articulado abatible\r\nControl de mano\r\nSoporta 200kg (Todos los equipos)\r\nBrazos abatibles\r\nEstructura de base placa de ¼\r\nPintura electroestática\r\nMedidas: 60cm ancho x 1.30 alto\r\nMedida extendida 1.60\r\nMotor 110v\r\nExtensión toma corriente 1.5m (todas las eléctricas)",
                'precio'      => 65000.00,
                'stock'       => 0,
                'categoria_id'=> 'ZAR-GNA',
                'imagen'      => 'images/productos/ZAR-GNA-034/principal.jpg',
                'imagen_extra'=> 'images/productos/ZAR-GNA-034/extra_1774855510_69ca255655b36.jpg',
            ],
            [
                'id'          => 'ZAR-GNA-035',
                'nombre'      => 'Equipo 2 motores exploración ZARG-035',
                'descripcion' => "Medidas:\r\nAlto 140cm\r\nAncho 70cm\r\nLargo180cm (extendido)\r\nPlaca ¼\r\nBrazo Abatible\r\nRespaldo y piecera reclinable motorizados (movimiento compartido)\r\nPiernera de aluminio\r\nGiro 340º\r\nAltura motorizada de 55cm mínima y de 75cm máxima\r\nMotor 110\r\nPintura Electrostatica\r\nVinil Tipo Automotriz\r\nCojin Cabezal Desmontable\r\nAcojinamiento firme de alta densidad\r\nControl Al Piso",
                'precio'      => 32000.00,
                'stock'       => 0,
                'categoria_id'=> 'ZAR-GNA',
                'imagen'      => 'images/productos/ZAR-GNA-035/principal.jpg',
                'imagen_extra'=> 'images/productos/ZAR-GNA-035/extra_1774855568_69ca25907b021.jpg',
            ],

            // ── ODN ───────────────────────────────────────────────────────
            [
                'id'          => 'ZAR-ODN-036',
                'nombre'      => 'Equipo ZARMEX eléctrico ZARDE-036',
                'descripcion' => "S/N",
                'precio'      => 31000.00,
                'stock'       => 0,
                'categoria_id'=> 'ZAR-ODN',
                'imagen'      => null,
                'imagen_extra'=> null,
            ],

            // ── OTN ───────────────────────────────────────────────────────
            [
                'id'          => 'ZAR-OTN-022',
                'nombre'      => 'Sillón giratorio 1 motor ZAROT-022',
                'descripcion' => "Medidas:\r\nAlto 140cm\r\nAncho 70cm\r\nLargo180cm (extendido)\r\nPlaca ¼\r\nBrazo Abatible\r\nRespaldo reclinable manual\r\nGiro 340º\r\nAltura motorizada de 55cm mínima y de 75cm máxima\r\nMotor 110\r\nPintura Electrostatica\r\nVinil Tipo Automotriz\r\nCojin Cabezal Desmontable\r\nAcojinamiento firme de alta densidad\r\nControl Al Piso",
                'precio'      => 27000.00,
                'stock'       => 1,
                'categoria_id'=> 'ZAR-OTN',
                'imagen'      => 'images/productos/ZAR-OTN-022/principal.jpg',
                'imagen_extra'=> 'images/productos/ZAR-OTN-022/extra_1774855638_69ca25d67fe2c.jpg',
            ],
            [
                'id'          => 'ZAR-OTN-023',
                'nombre'      => 'Sillón giratorio 2 motores ZAROT-023',
                'descripcion' => "Medidas:\r\nAlto 140cm\r\nAncho 70cm\r\nLargo180cm (extendido)\r\nPlaca ¼\r\nBrazo Abatible\r\nRespaldo y piecera reclinable motorizados (movimiento compartido)\r\nGiro 340º\r\nAltura motorizada de 55cm mínima y de 75cm máxima\r\nMotor 110\r\nPintura Electrostatica\r\nVinil Tipo Automotriz\r\nCojin Cabezal Desmontable\r\nAcojinamiento firme de alta densidad\r\nControl Al Piso",
                'precio'      => 30500.00,
                'stock'       => 0,
                'categoria_id'=> 'ZAR-OTN',
                'imagen'      => 'images/productos/ZAR-OTN-023/principal.jpg',
                'imagen_extra'=> 'images/productos/ZAR-OTN-023/extra_1774855680_69ca260044c56.jpg',
            ],
            [
                'id'          => 'ZAR-OTN-024',
                'nombre'      => 'Sillón giratorio 3 motores ZART-024',
                'descripcion' => "Medidas:\r\nAlto 140cm\r\nAncho 70cm\r\nLargo180cm (extendido)\r\nPlaca ¼\r\nBrazo Abatible\r\nRespaldo reclinable motorizado independiente\r\nPiecera motorizado independiente\r\nGiro 340º\r\nAltura motorizada de 55cm mínima y de 75cm máxima\r\nMotor 110\r\nPintura Electrostatica\r\nVinil Tipo Automotriz\r\nCojin Cabezal Desmontable\r\nAcojinamiento firme de alta densidad\r\nControl Al Piso",
                'precio'      => 35000.00,
                'stock'       => 0,
                'categoria_id'=> 'ZAR-OTN',
                'imagen'      => 'images/productos/ZAR-OTN-024/principal.jpg',
                'imagen_extra'=> 'images/productos/ZAR-OTN-024/extra_1774855722_69ca262a5a5ce.jpg',
            ],
            [
                'id'          => 'ZAR-OTN-025',
                'nombre'      => 'Unidad con sistema aspiración ZART-025',
                'descripcion' => "Medidas\r\nAlto 140cm\r\nAncho 70cm\r\nFondo 50cm\r\nEstructura de triplay de pino de 1ra\r\n5 cajoneras con barra independiente\r\nSeguros en cajoneras\r\nLlantas con freno\r\nForro de formaica\r\nMotor de 1hp para aspiración\r\n2 contenedores de 2lt c/u desmontables\r\n2 metros de manguera extendible\r\nApagador independiente para sistema de aspiración\r\n1.5metros de cable toma corriente a 110v",
                'precio'      => 14000.00,
                'stock'       => 0,
                'categoria_id'=> 'ZAR-OTN',
                'imagen'      => 'images/productos/ZAR-OTN-025/principal.jpg',
                'imagen_extra'=> 'images/productos/ZAR-OTN-025/extra_1774855836_69ca269c3d908.jpg',
            ],
            [
                'id'          => 'ZAR-OTN-026',
                'nombre'      => 'Unidad con sistema aspiración y aspersión ZART-026',
                'descripcion' => "Medidas\r\nAlto 140cm\r\nAncho 70cm\r\nFondo 50cm\r\nEstructura de triplay de pino de 1ra\r\n5 cajoneras con barra independiente\r\nSeguros en cajoneras\r\nLlantas con freno\r\nForro de formaica\r\nMotor de 1hp para aspiración\r\n2 contenedores de 2lt c/u desmontables\r\n2 metros de manguera extendible para aspiración\r\nApagador independiente para sistema de aspiración\r\nMotor independiente para aspersor\r\nDeposito de aire de 12 lt\r\nConector para botella de líquido de 1lt\r\n2 metros de manguera extendible para aspersión\r\nApagador independiente para sistema de aspersión\r\n1.5metros de cable toma corriente a 110v",
                'precio'      => 21000.00,
                'stock'       => 0,
                'categoria_id'=> 'ZAR-OTN',
                'imagen'      => 'images/productos/ZAR-OTN-026/principal.jpg',
                'imagen_extra'=> 'images/productos/ZAR-OTN-026/extra_1774855914_69ca26ea3e7dc.jpg',
            ],

            // ── PDA ───────────────────────────────────────────────────────
            [
                'id'          => 'ZAR-PDA-030',
                'nombre'      => 'Equipo base estándar ZARP-030',
                'descripcion' => "Placa base de ¼\r\nMotor 4000 newtons (Nw) 110 v\r\nAltura mínima 55 cm máxima 70 cm\r\nCharola de residuos de acero inoxidable ajustable\r\nLampara Steren con brazo reforzado articulado\r\nCojín circular\r\nPiecera extensible\r\nRespaldo manual reclinable\r\nCojín cabezal desmontable\r\nBanquillo importado\r\nMueble auxiliar\r\nControl al pie\r\nPintura electrostática\r\nVinil tipo automotriz",
                'precio'      => 24400.00,
                'stock'       => 0,
                'categoria_id'=> 'ZAR-PDA',
                'imagen'      => 'images/productos/ZAR-PDA-030/principal.jpg',
                'imagen_extra'=> 'images/productos/ZAR-PDA-030/extra_1774855976_69ca272879446.jpg',
            ],
            [
                'id'          => 'ZAR-PDA-031',
                'nombre'      => 'Equipo base tijera Equipo sistema trendelemburg ZARP-031',
                'descripcion' => "Placa base de ¼\r\nMotor 4000new 110v para sistema trendelemburg con control de pie al piso\r\nElevación de hasta 20 grados\r\nMotor 4000 newtons (Nw) 110 v\r\nAltura mínima 55 cm máxima 75 cm\r\nCharola de residuos de acero inoxidable ajustable\r\nLampara Steren con brazo reforzado articulado\r\nCojín circular\r\nPiecera extensible\r\nRespaldo electrico reclinable\r\nCojín cabezal desmontable\r\nBanquillo importado\r\nMueble auxiliar\r\nControl al pie\r\nPintura electrostática\r\nVinil tipo automotriz",
                'precio'      => 31900.00,
                'stock'       => 0,
                'categoria_id'=> 'ZAR-PDA',
                'imagen'      => 'images/productos/ZAR-PDA-031/principal.jpg',
                'imagen_extra'=> 'images/productos/ZAR-PDA-031/extra_1774856026_69ca275acd2f8.jpg',
            ],
            [
                'id'          => 'ZAR-PDA-032',
                'nombre'      => 'Equipo sistema flush ZARP-032',
                'descripcion' => "Placa base de ¼\r\nMotor 4000 newtons (Nw) 110 v\r\nAltura mínima 55 cm máxima 75 cm\r\nCharola de residuos de acero inoxidable ajustable\r\nLampara Steren con brazo reforzado articulado\r\nCojín circular\r\nPiecera extensible\r\nRespaldo manual reclinable\r\nBrazo auxiliar para laptop y cafe\r\nModulo con sistema de baja\r\n2 jeringas triples\r\nBarometro para medición de aire\r\nAdaptador para pieza de baja\r\nCojín cabezal desmontable\r\nBanquillo importado\r\nMueble auxiliar\r\nControl al pie\r\nPintura electrostática\r\nVinil tipo automotriz",
                'precio'      => 31950.00,
                'stock'       => 0,
                'categoria_id'=> 'ZAR-PDA',
                'imagen'      => 'images/productos/ZAR-PDA-032/principal.jpg',
                'imagen_extra'=> 'images/productos/ZAR-PDA-032/extra_1774856074_69ca278ad2100.jpg',
            ],
            [
                'id'          => 'ZAR-PDA-033',
                'nombre'      => 'Equipo base tijera ZARP-033',
                'descripcion' => "Placa base de ¼\r\nMotor 4000 newtons (Nw) 110 v\r\nAltura mínima 55 cm máxima 75 cm \r\nCharola de residuos de acero inoxidable ajustable \r\nlampara Steren con brazo reforzado articulado \r\ncojín circular\r\npiecera extensible \r\nrespaldo manual reclinable \r\ncojín cabezal desmontable\r\nbanquillo importado \r\nmueble auxiliar \r\ncontrol al pie \r\npintura electrostática \r\nvinil tipo automotriz",
                'precio'      => 26700.00,
                'stock'       => 0,
                'categoria_id'=> 'ZAR-PDA',
                'imagen'      => 'images/productos/ZAR-PDA-033/principal.jpg',
                'imagen_extra'=> 'images/productos/ZAR-PDA-033/extra_1774856123_69ca27bb464ba.jpg',
            ],
        ];

        // ── Insertar productos e imágenes ──────────────────────────────────
        $productosRows = [];
        $imagenesRows  = [];

        foreach ($productos as $p) {
            $productosRows[] = [
                'id'             => $p['id'],
                'nombre'         => $p['nombre'],
                'descripcion'    => $p['descripcion'],
                'precio'         => $p['precio'],
                'stock'          => $p['stock'],
                'categoria_id'   => $p['categoria_id'],
                'imagen_url'     => $p['imagen'],
                'fecha_creacion' => $now,
            ];

            // Imagen principal (orden 1)
            if ($p['imagen']) {
                $imagenesRows[] = [
                    'id'          => Str::uuid()->toString(),
                    'producto_id' => $p['id'],
                    'ruta'        => $p['imagen'],
                    'orden'       => 1,
                ];
            }

            // Imagen(es) extra (orden 2, 3, ...)
            if (!empty($p['imagen_extra'])) {
                $extras = is_array($p['imagen_extra']) ? $p['imagen_extra'] : [$p['imagen_extra']];
                foreach ($extras as $i => $extra) {
                    $imagenesRows[] = [
                        'id'          => Str::uuid()->toString(),
                        'producto_id' => $p['id'],
                        'ruta'        => $extra,
                        'orden'       => $i + 2, // 2, 3, 4...
                    ];
                }
            }
        }

        DB::table('productos')->insert($productosRows);
        DB::table('imagenes_productos')->insert($imagenesRows);

        $this->command->info('✅ ' . count($productosRows) . ' productos insertados.');
        $this->command->info('✅ ' . count($imagenesRows) . ' imágenes insertadas.');
    }
}