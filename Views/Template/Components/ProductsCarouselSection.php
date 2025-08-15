<?php
    $titulo = $data['titulo'];
    $subtitulo = $data['subtitulo'];
    $productos = $data['datos'];
?>
<section class="container bg-white">
    <div class="mb-3 px-2">
        <h2 class="section--title fs-2 t-color-1"><?=$titulo?></h2>
        <h3 class="t-color-2"><?=$subtitulo?></h3>
        <div class="row">
            <div class="product-slider-cat owl-carousel owl-theme mb-5" data-bs-ride="carousel">
                <?php for ($j=0; $j < count($productos); $j++) { $producto = $productos[$j]; getComponent("cardProduct",$producto);} ?>
            </div>
        </div>
    </div>
</section>