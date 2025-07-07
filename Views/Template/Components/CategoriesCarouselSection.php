<?php $categories = $data['datos']; ?>
<section class="container mt-5">
    <?php  for ($i=0; $i < count($categories) ; $i++) { ?>
    
    <div class="row mb-5">
        <h3 class="mb-3 t-color-1">
            <?=$categories[$i]['name']?>
        </h3>
        <div class="col-lg-4 col-md-12 ">
            <div class="card--category d-flex align-items-center">
                <div class="card--category-img">
                    <a href="<?=base_url()."/shop/category/".$categories[$i]['route']?>">
                        <img src="<?=media()."/images/uploads/".$categories[$i]['picture']?>" alt="<?=$categories[$i]['name']?>">
                    </a>
                    <h3><a href="<?=base_url()."/shop/category/".$categories[$i]['route']?>" class="text-white"><?=$categories[$i]['name']?></a></h3>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-md-12">
            <?php
                $productos =$categories[$i]['products'];
            ?>
            <div class="row">
                <div class="product-slider-cat-1 owl-carousel owl-theme">
                    <?php for ($j=0; $j < count($productos); $j++) { $producto = $productos[$j]; getComponent("cardProduct",$producto);} ?>
                </div>
            </div>
        </div>
    </div>
    <?php }?>
</section>