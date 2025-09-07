<?php
    $titulo = $data['titulo'];
    $subtitulo = $data['subtitulo'];
    $productos = $data['datos'];
?>
<section class="bg-white">
    <div class="mb-3 px-2 pb-2 pt-2 container">
        <h3 class="t-color-1 fs-1 mb-0"><?=$titulo?></h3>
        <h2 class="fs-4 t-color-5 fw-bold"><?=$subtitulo?></h2>
        <div class="row mt-4">
            <div class="row">
                <?php for ($j=0; $j < 4; $j++) { 
                    $producto = $productos[$j]; 
                    if(!empty($producto)){
                        echo '<div class="col-md-3">';
                        getComponent("cardProduct",$producto);
                        echo '</div>';
                        } 
                    }
                ?>
            </div>
        </div>
        <div class="d-flex justify-content-center mt-4 mb-4">
            <a href="<?=base_url()."/shop/"?>" class="btn btn-secondary">View all our products</a>
        </div>
    </div>
</section>