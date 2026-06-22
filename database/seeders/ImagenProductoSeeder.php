<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ImagenProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Puebla imagenes_productos con las imágenes principales (img_) de cada producto CQP.
     * La ruta se guarda relativa a public/ para usarse con asset().
     */
    public function run()
    {
        // Limpiar tabla antes de insertar
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('imagenes_productos')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $imagenes = [
            // producto_id => ruta principal
            'ZAR-CQP-001' => 'images/productos/ZAR-CQP-001/img_1780513993_6a207cc98a36c.jpeg',
            'ZAR-CQP-002' => 'images/productos/ZAR-CQP-002/img_1780514034_6a207cf2e330e.jpeg',
            'ZAR-CQP-004' => 'images/productos/ZAR-CQP-004/img_1780514524_6a207edc70db8.jpeg',
            'ZAR-CQP-005' => 'images/productos/ZAR-CQP-005/img_1780514709_6a207f95e4dc3.jpeg',
            'ZAR-CQP-006' => 'images/productos/ZAR-CQP-006/img_1780514747_6a207fbbcbbe9.jpeg',
            'ZAR-CQP-007' => 'images/productos/ZAR-CQP-007/img_1780514848_6a2080207cbcc.jpeg',
            'ZAR-CQP-008' => 'images/productos/ZAR-CQP-008/img_1780514881_6a208041ae9ba.jpeg',
            'ZAR-CQP-009' => 'images/productos/ZAR-CQP-009/img_1780515103_6a20811f527c0.jpeg',
            'ZAR-CQP-010' => 'images/productos/ZAR-CQP-010/img_1780515143_6a208147642d4.jpeg',
            'ZAR-CQP-011' => 'images/productos/ZAR-CQP-011/img_1780515205_6a20818561cbb.jpeg',
            'ZAR-CQP-012' => 'images/productos/ZAR-CQP-012/img_1780515316_6a2081f403305.jpeg',
            'ZAR-CQP-013' => 'images/productos/ZAR-CQP-013/img_1780515384_6a2082382f753.jpeg',
            'ZAR-CQP-014' => 'images/productos/ZAR-CQP-014/img_1780515441_6a208271ec586.jpeg',
            'ZAR-CQP-015' => 'images/productos/ZAR-CQP-015/img_1780515492_6a2082a4573e3.jpeg',
            'ZAR-CQP-017' => 'images/productos/ZAR-CQP-017/img_1780515638_6a208336059f9.jpeg',
            'ZAR-CQP-018' => 'images/productos/ZAR-CQP-018/img_1780515684_6a20836456bc1.jpeg',
            'ZAR-CQP-019' => 'images/productos/ZAR-CQP-019/img_1780515749_6a2083a5ce1ea.jpeg',
            'ZAR-CQP-020' => 'images/productos/ZAR-CQP-020/img_1780515802_6a2083da0532c.jpeg',
            'ZAR-CQP-021' => 'images/productos/ZAR-CQP-021/img_1780515852_6a20840cd39e8.jpeg',
            'ZAR-CQP-040' => 'images/productos/ZAR-CQP-040/img_1780604825_6a21df99bbff4.jpeg',
        ];

        $rows = [];
        foreach ($imagenes as $productoId => $ruta) {
            $rows[] = [
                'id'          => Str::uuid()->toString(),
                'producto_id' => $productoId,
                'ruta'        => $ruta,
                'orden'       => 1,
            ];
        }

        DB::table('imagenes_productos')->insert($rows);
    }
}
