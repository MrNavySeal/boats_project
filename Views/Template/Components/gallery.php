<?php
    $titulo = $data['titulo'];
    $subtitulo = $data['subtitulo'];
    $arrData = $data['datos'];
?>
<section class=" bg-white mt-5 mb-5">
    <div class="mb-3 px-2 container">
        <h2 class="fs-2 t-color-1"><?=$titulo?></h2>
        <h3 class="t-color-2"><?=$subtitulo?></h3>
        <div class="row">
            <div class="gallery-slider-cat owl-carousel owl-theme mb-5" data-bs-ride="carousel">
                <?php for ($j=0; $j < count($arrData); $j++) { $data = $arrData[$j]; getComponent("cardGallery",$data);} ?>
            </div>
        </div>
    </div>
</section>
