<?php
    $titulo = $data['titulo'];
    $subtitulo = $data['subtitulo'];
    $arrData = $data['datos'];
?>
<section class="container bg-white mt-5 mb-5">
    <div class="mb-3 px-2">
        <h2 class="section--title fs-2 t-color-1"><?=$titulo?></h2>
        <h3 class="t-color-2"><?=$subtitulo?></h3>
        <div class="row">
            <div class="product-slider-cat owl-carousel owl-theme mb-5" data-bs-ride="carousel">
                <?php for ($j=0; $j < count($arrData); $j++) { $data = $arrData[$j]; getComponent("cardGallery",$data);} ?>
            </div>
        </div>
    </div>
</section>
