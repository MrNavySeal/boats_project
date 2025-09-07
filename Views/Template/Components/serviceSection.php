<?php
    $titulo = $data['titulo'];
    $subtitulo = $data['subtitulo'];
    $servicios = $data['datos'];
?>
<div >
    <div class="container mt-4 mb-4">
        <div class="py-2">
            <h3 class="t-color-1 fs-1 mb-0 "><?=$titulo?></h3>
            <h2 class="fs-4 t-color-5 fw-bold"><?=$subtitulo?></h2>
            <div class="row mt-4">
                <?php for ($j=0; $j < 4; $j++) { 
                    $servicio = $servicios[$j]; 
                    echo '<div class="col-md-3">';
                    getComponent("cardService",$servicio);
                    echo '</div>';
                    } 
                ?>
            </div>
            <div class="d-flex justify-content-center mt-4 mb-4">
                <a href="<?=base_url()."/shop/services/"?>" class="btn btn-secondary">View all our services</a>
            </div>
        </div>
    </div>
</div>