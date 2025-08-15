<?php
    $producto = $data;
    $id = openssl_encrypt($producto['idproduct'],METHOD,KEY);
?>
<div class="card--product bg-white">
    <div class="card--product-img">
        <a href="<?=base_url()."/shop/product/".$producto['route']?>">
            <img src="<?=$producto['url']?>" alt="<?=$producto['category']." ".$producto['subcategory']?>">
        </a>
    </div>
    <div class="card--product-info">
        <h4><a href="<?=base_url()."/shop/product/".$producto['route']?>"><?=$producto['name']?></a></h4>
    </div>
    <div class="card--product-btns">
        <div class="d-flex">
            <a href="<?=base_url()?>" class="btn btn-bg-1 w-100">Schedule now</a>
        </div>
    </div>
</div>