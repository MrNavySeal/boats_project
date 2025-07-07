<?php
    $titulo = $data['titulo'];
    $subtitulo = $data['subtitulo'];
    $productos = $data['datos'];
?>
<section class="container">
    <h2 class="section--title fs-2"><?=$titulo?></h2>
    <div class="row mb-3">
        <h3 class="t-color-1"><?=$subtitulo?></h3>
        <div class="row">
            <div class="product-slider-cat owl-carousel owl-theme mb-5" data-bs-ride="carousel">
                <?php for ($j=0; $j < count($productos); $j++) { $producto = $productos[$j]; getComponent("cardProduct",$producto);} ?>
            </div>
        </div>
    </div>
</section>