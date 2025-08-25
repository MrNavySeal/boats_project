<?php
    $titulo = $data['titulo'];
    $subtitulo = $data['subtitulo'];
    $servicios = $data['datos'];
?>
<div class="bg-color-2">
    <div class="container">
        <div class="py-2">
            <h3 class="section--title t-color-4 fs-4 mb-0 text-start"><?=$titulo?></h3>
            <h2 class="section--title fs-1 t-color-4 text-start"><?=$subtitulo?></h2>
            <div class="services-slider-cat owl-carousel owl-theme mb-5" data-bs-ride="carousel">
                <?php for ($j=0; $j < count($servicios); $j++) { $servicio = $servicios[$j]; getComponent("cardService",$servicio);} ?>
            </div>
        </div>
    </div>
</div>