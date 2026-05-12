<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e(config('app.name', 'Zarmex')); ?> / detalle producto</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo e(asset('css/vermas.css')); ?>">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root{
            --zx:#234d50;
            --zx2:rgba(35,77,80,.08);
            --bd:rgba(0,0,0,.08);
        }

        body{
            background:#fff;
        }

        .zx-wrap{
            max-width: 1200px;
            margin: 22px auto 0;
            padding: 0 14px;
        }

        .zx-card{
            background:#fff;
            border: 1px solid var(--bd);
            border-radius: 18px;
            box-shadow: 0 12px 28px rgba(0,0,0,.08);
            padding: 18px;
        }

        /* ===== layout ===== */
        .zx-layout{
            display:grid;
            grid-template-columns: 86px 1fr 420px;
            gap: 16px;
            align-items:start;
        }

        /* ===== miniaturas ===== */
        .zx-thumbs{
            display:flex;
            flex-direction:column;
            gap:10px;
            max-height: 520px;
            overflow-y:auto;
            padding-right:6px;
        }

        .zx-thumbs::-webkit-scrollbar{
            width:6px;
        }

        .zx-thumbs::-webkit-scrollbar-thumb{
            background: rgba(0,0,0,.18);
            border-radius:999px;
        }

        .zx-thumb{
            border:2px solid transparent;
            border-radius:12px;
            padding:3px;
            background:#fff;
            cursor:pointer;
            transition:.2s ease;
            width: 74px;
            flex: 0 0 auto;
        }

        .zx-thumb.active{
            border-color: var(--zx);
            box-shadow: 0 0 0 3px rgba(35,77,80,.15);
        }

        .zx-thumb img{
            width:100%;
            aspect-ratio: 1 / 1;
            object-fit: cover;
            border-radius:10px;
            background:#f1f3f5;
            display:block;
        }

        /* ===== imagen principal ===== */
        .zx-main{
            border: 1px solid var(--bd);
            border-radius: 18px;
            overflow: hidden;
            background:#fff;
            width: 100%;
            aspect-ratio: 1 / 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #carouselProducto,
        #carouselProducto .carousel-inner,
        #carouselProducto .carousel-item{
            width: 100%;
            height: 100%;
        }

        .zx-main-img{
            width: 100%;
            height: 100%;
            aspect-ratio: 1 / 1;
            object-fit: cover;
            background: #fff;
            display: block;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon{
            filter: invert(1);
            opacity:.9;
        }

        /* ===== info derecha ===== */
        .zx-info{
            border: 1px solid var(--bd);
            border-radius: 18px;
            padding: 16px;
            background:#fff;
        }

        .zx-brand{
            text-transform: uppercase;
            font-weight: 800;
            font-size: 14px;
            color:#222;
            letter-spacing:.6px;
            text-align:center;
            margin-bottom:6px;
        }

        .zx-title{
            font-weight: 900;
            font-size: 22px;
            color:#111;
            text-align:center;
            margin: 0 0 8px;
        }

        .zx-sub{
            text-align:center;
            color:#666;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .zx-row{
            display:flex;
            align-items:flex-start;
            justify-content: space-between;
            gap:12px;
            padding: 10px 0;
            border-top: 1px solid rgba(0,0,0,.06);
        }

        .zx-label{
            color:#444;
            font-weight:700;
            font-size: 14px;
            min-width: 92px;
        }

        .zx-val{
            color:#222;
            font-weight:700;
            font-size: 14px;
            text-align:right;
        }

        .zx-row-desc .zx-desc{
            text-align:right;
            line-height: 1.55;
            max-width: 240px;
        }

        .zx-price{
            display:flex;
            align-items:baseline;
            justify-content:center;
            gap:10px;
            margin: 14px 0 6px;
        }

        .zx-price strong{
            font-size: 22px;
            color: #0a0a0a;
            font-weight: 900;
        }

        .zx-iva{
            font-size: 12px;
            opacity:.65;
            text-align:center;
        }

        /* ===== colores ===== */
        .zx-colors{
            margin-top:20px;
            border-bottom:1px dashed rgba(0,0,0,.25);
            padding-bottom:14px;
        }

        .zx-colors-head{
            display:flex;
            justify-content:space-between;
            margin-bottom:10px;
            font-weight:800;
        }

        .zx-color-row{
            display:flex;
            gap:12px;
            flex-wrap: wrap;
        }

        .zx-color{
            width:22px;
            height:22px;
            border-radius:50%;
            border:2px solid rgba(0,0,0,.2);
            cursor:pointer;
            padding: 0;
        }

        .zx-color.active{
            border-color:#234d50;
            box-shadow:0 0 0 3px rgba(35,77,80,.18);
        }

        /* ===== documentos ===== */
        .docs-sm{
            margin-top: 18px;
            padding-top: 12px;
            border-top: 1px dashed #cfd6d6;
            display: grid;
            gap: 10px;
        }

        .docs-title{
            font-weight: 900;
            color: var(--zx);
            margin-bottom: 4px;
        }

        .doc-row{
            display:grid;
            grid-template-columns: 1fr auto auto;
            gap:10px;
            align-items:center;
            padding:10px;
            border-radius:12px;
            background: var(--zx2);
        }

        .doc-name{
            font-weight: 800;
            color: var(--zx);
        }

        .doc-btn{
            padding: 8px 10px;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 900;
            border:0;
            text-decoration:none;
            white-space:nowrap;
            cursor:pointer;
        }

        .doc-view{
            background: var(--zx);
            color:#fff;
        }

        .doc-download{
            background: rgba(35,77,80,.18);
            color: var(--zx);
        }

        .doc-preview{
            margin-top: 10px;
            border-radius: 12px;
            overflow:hidden;
            border: 1px solid rgba(0,0,0,.08);
            display:none;
            background:#fff;
        }

        .doc-preview iframe{
            width:100%;
            height: 280px;
            border:0;
            display:block;
        }

        .doc-preview img{
            width:100%;
            height:auto;
            display:block;
        }

        /* ===== regresar ===== */
        .zx-back-bottom{
            max-width: 1200px;
            margin: 14px auto 0;
            display:flex;
            justify-content:center;
            padding: 0 14px;
        }

        .zx-back-btn{
            padding: 12px 22px;
            background: var(--zx);
            color:#fff;
            border-radius: 12px;
            text-decoration:none;
            font-weight: 900;
        }

        /* ===== comentarios ===== */
        .comments-wrap{
            max-width: 980px;
            margin: 28px auto 0;
            padding: 0 12px;
        }

        .review-section{
            margin: 0 auto;
            text-align:center;
        }

        .review-section h3{
            font-weight: 900;
            letter-spacing:.7px;
            color: var(--zx);
            margin-bottom: 14px;
        }

        .review-section form{
            max-width: 760px;
            margin: 0 auto;
            text-align:left;
            background: var(--zx2);
            border: 1px solid var(--bd);
            padding: 18px;
            border-radius: 16px;
        }

        .review-section textarea{
            width:100%;
            border-radius: 12px;
            border: 1px solid rgba(0,0,0,.18);
            padding: 12px;
        }

        .rating-stars{
            display:flex;
            gap:6px;
            justify-content:center;
            margin: 8px 0 10px;
        }

        .comments-head{
            max-width: 760px;
            margin: 18px auto 0;
        }

        #comentarios-container{
            max-width: 760px;
            margin: 12px auto 0;
        }

        /* ===== responsive ===== */
        @media (max-width: 992px){
            .zx-layout{
                grid-template-columns: 86px 1fr;
            }

            .zx-info{
                grid-column: 1 / -1;
                margin-top: 16px;
            }

            .zx-main{
                aspect-ratio: 1 / 1;
            }
        }

        @media (max-width: 768px){
            .zx-layout{
                grid-template-columns: 1fr;
            }

            .zx-main{
                order: 1;
                width: 100%;
            }

            .zx-thumbs{
                order: 2;
                flex-direction: row;
                justify-content: flex-start;
                align-items: center;
                max-height: none;
                overflow-x: auto;
                overflow-y: hidden;
                gap: 8px;
                margin-top: 14px;
                padding: 0 0 4px 0;
            }

            .zx-thumb{
                min-width: 60px;
                width: 60px;
                padding: 3px;
                border-radius: 8px;
                border: 2px solid transparent;
                transition: .2s ease;
            }

            .zx-thumb img{
                width: 100%;
                aspect-ratio: 1 / 1;
                object-fit: cover;
                border-radius: 6px;
                background: #f1f3f5;
                display: block;
            }

            .zx-thumb.active{
                border-color: #234d50;
                box-shadow: 0 0 0 2px rgba(35,77,80,.15);
            }

            .zx-info{
                order: 3;
                margin-top: 18px;
            }

            .doc-row{
                grid-template-columns: 1fr;
            }

            .zx-row{
                flex-direction: column;
                gap: 4px;
            }

            .zx-val,
            .zx-row-desc .zx-desc{
                text-align: left;
                max-width: 100%;
            }
        }
    </style>
</head>

<body>
<?php echo $__env->make('header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<main class="zx-wrap">

<?php
    $thumbs = collect([$producto->imagen_url])
        ->merge(collect($imagenes)->pluck('ruta'))
        ->values();

    $descCorta = \Illuminate\Support\Str::limit(strip_tags($producto->descripcion), 180);
?>

<div class="zx-card">
    <div class="zx-layout">

        
        <div class="zx-thumbs" data-carousel="#carouselProducto">
            <?php $__currentLoopData = $thumbs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $ruta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <button
                    type="button"
                    class="zx-thumb <?php echo e($i === 0 ? 'active' : ''); ?>"
                    data-slide-to="<?php echo e($i); ?>"
                >
                    <img src="<?php echo e(asset($ruta)); ?>" alt="thumb <?php echo e($i); ?>">
                </button>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        
        <div class="zx-main">
            <div id="carouselProducto" class="carousel slide w-100 h-100" data-bs-ride="carousel" data-bs-interval="2500" data-bs-pause="hover" data-bs-touch="true">
                <div class="carousel-inner h-100">

                    <div class="carousel-item active h-100">
                        <img src="<?php echo e(asset($producto->imagen_url)); ?>" class="zx-main-img" alt="principal">
                    </div>

                    <?php $__currentLoopData = $imagenes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $imagen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="carousel-item h-100">
                            <img src="<?php echo e(asset($imagen->ruta)); ?>" class="zx-main-img" alt="extra">
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </div>

                <?php if($thumbs->count() > 1): ?>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselProducto" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>

                    <button class="carousel-control-next" type="button" data-bs-target="#carouselProducto" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                <?php endif; ?>
            </div>
        </div>

        
        <aside class="zx-info">
            <div class="zx-title"><?php echo e($producto->id); ?></div>
            <div class="zx-sub"><?php echo e($producto->nombre); ?></div>

            <div class="zx-row">
                <span class="zx-label">Categoría</span>
                <span class="zx-val"><?php echo e($nombreCategoria); ?></span>
            </div>

            <div class="zx-row">
                <span class="zx-label">Stock</span>
                <span class="zx-val"><?php echo e($producto->stock); ?></span>
            </div>

            <div class="zx-row zx-row-desc">
                <span class="zx-label">Descripción</span>
                <div class="zx-val zx-desc">
                    <?php echo e($descCorta); ?>

                </div>
            </div>

            <div class="zx-price">
                <strong>$<?php echo e(number_format($producto->precio, 2)); ?></strong>
                <span style="font-weight:800;color:#222;">MXN</span>
            </div>

            <div class="zx-iva">+ IVA 16%</div>

            
            <div class="zx-colors">
                <div class="zx-colors-head">
                    <div class="left">Color:</div>
                </div>

                <div class="zx-color-row" id="zxColorRow">
                    <button type="button" class="zx-color active" style="background:#1f2326;"></button>
                    <button type="button" class="zx-color" style="background:#4f89b8;"></button>
                    <button type="button" class="zx-color" style="background:#739f6a;"></button>
                    <button type="button" class="zx-color" style="background:#b1544d;"></button>
                    <button type="button" class="zx-color" style="background:#d06763;"></button>
                    <button type="button" class="zx-color" style="background:#e3778a;"></button>
                </div>
            </div>

            
            <div class="docs-sm">
                <div class="docs-title">Documentos</div>

                <?php
                    $docs = [
                        ['label' => 'Garantía', 'url' => $producto->doc1_url ?? null],
                        ['label' => 'Manual', 'url' => $producto->doc2_url ?? null],
                        ['label' => 'Ficha Técnica', 'url' => $producto->doc3_url ?? null],
                    ];
                ?>

                <?php $__currentLoopData = $docs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(!empty($doc['url'])): ?>
                        <?php
                            $fullUrl = asset($doc['url']);
                            $previewId = "docPreview" . $idx;

                            $ext = strtolower(pathinfo($doc['url'], PATHINFO_EXTENSION));
                            $isImage = in_array($ext, ['jpg','jpeg','png','gif','webp']);
                            $isPdf = ($ext === 'pdf');
                            $canPreview = $isImage || $isPdf;
                        ?>

                        <div class="doc-row">
                            <span class="doc-name"><?php echo e($doc['label']); ?></span>

                            <?php if($canPreview): ?>
                                <button type="button" class="doc-btn doc-view" onclick="togglePreview('<?php echo e($previewId); ?>')">
                                    Previsualizar
                                </button>
                            <?php else: ?>
                                <span style="opacity:.7;font-size:12px;">Sin preview</span>
                            <?php endif; ?>

                            <a class="doc-btn doc-download" href="<?php echo e($fullUrl); ?>" download>Descargar</a>
                        </div>

                        <?php if($canPreview): ?>
                            <div id="<?php echo e($previewId); ?>" class="doc-preview">
                                <?php if($isImage): ?>
                                    <img src="<?php echo e($fullUrl); ?>" alt="<?php echo e($doc['label']); ?>">
                                <?php else: ?>
                                    <iframe src="<?php echo e($fullUrl); ?>"></iframe>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <?php if(empty($producto->doc1_url) && empty($producto->doc2_url) && empty($producto->doc3_url)): ?>
                    <div style="opacity:.7;">No hay documentos disponibles.</div>
                <?php endif; ?>
            </div>
        </aside>

    </div>
</div>

</main>

<div class="zx-back-bottom">
    <a href="/catalogo/<?php echo e($producto->categoria_id); ?>" class="zx-back-btn">Regresar al catálogo</a>
</div>

<div class="comments-wrap">

    <div class="review-section">
        <h3>DEJA TU COMENTARIO DEL PRODUCTO</h3>

        <form action="<?php echo e(route('reviews.store', $producto->id)); ?>" method="POST">
            <?php echo csrf_field(); ?>

            <input type="hidden" name="producto_id" value="<?php echo e($producto->id); ?>">

            <div class="mb-3">
                <label class="fw-bold">Nombre (opcional)</label>
                <input type="text" name="guest_nombre" class="form-control" placeholder="Ej: Juan">
            </div>

            <div class="mb-3">
                <label class="fw-bold">Correo (opcional)</label>
                <input type="email" name="guest_email" class="form-control" placeholder="Ej: correo@gmail.com">
            </div>

            <center><label class="fw-bold">Calificación:</label></center>
            <div class="rating-stars">
                <?php for($i = 5; $i >= 1; $i--): ?>
                    <input type="radio" id="star<?php echo e($i); ?>" name="calificacion" value="<?php echo e($i); ?>" required>
                    <label for="star<?php echo e($i); ?>">★</label>
                <?php endfor; ?>
            </div>

            <center><label class="fw-bold">Reseña:</label></center>
            <textarea name="descripcion" rows="4" placeholder="Escribe tu opinión aquí..." required></textarea>

            <div class="text-center">
                <button type="submit" class="btn btn-primary mt-3">Enviar reseña</button>
            </div>
        </form>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-4 comments-head">
        <h3 class="m-0">Comentarios</h3>
        <select id="filtro-orden" class="form-select w-auto">
            <option value="recientes">Más recientes</option>
            <option value="antiguos">Más antiguos</option>
            <option value="mejor_calificacion">Mejor calificados</option>
            <option value="peor_calificacion">Peor calificados</option>
        </select>
    </div>

    <div id="comentarios-container" class="mt-3"></div>

    <div class="text-center">
        <button id="ver-mas" class="btn btn-secondary d-none">Ver más</button>
    </div>
</div>

<?php echo $__env->make('footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<script>
document.querySelectorAll(".zx-thumbs").forEach(wrap => {
    const carouselEl = document.querySelector(wrap.dataset.carousel);
    const carousel = bootstrap.Carousel.getOrCreateInstance(carouselEl);

    wrap.querySelectorAll(".zx-thumb").forEach(btn => {
        btn.addEventListener("click", () => {
            carousel.to(parseInt(btn.dataset.slideTo, 10));
            wrap.querySelectorAll(".zx-thumb").forEach(t => t.classList.remove("active"));
            btn.classList.add("active");
        });
    });

    carouselEl.addEventListener("slid.bs.carousel", (ev) => {
        wrap.querySelectorAll(".zx-thumb").forEach(t => t.classList.remove("active"));
        const active = wrap.querySelector(`.zx-thumb[data-slide-to="${ev.to}"]`);
        if (active) active.classList.add("active");
    });
});

function togglePreview(id){
    document.querySelectorAll('.doc-preview').forEach(el => {
        if (el.id !== id) el.style.display = 'none';
    });

    const el = document.getElementById(id);
    if (!el) return;

    el.style.display = (el.style.display === 'block') ? 'none' : 'block';
}

window.togglePreview = togglePreview;
</script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const row = document.getElementById('zxColorRow');
    if (!row) return;

    row.querySelectorAll('.zx-color').forEach(btn => {
        btn.addEventListener('click', () => {
            row.querySelectorAll('.zx-color').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
        });
    });
});
</script>

</body>
</html><?php /**PATH C:\xampp\htdocs\zarmex\resources\views/vermas.blade.php ENDPATH**/ ?>