<?php
    $producto = $data;
    $id = $producto['id'];
?>
<div class="card--product bg-white">
    <div class="card--product-img">
        <a href="<?=base_url()."/shop/service/".$producto['route']?>">
            <img src="<?=media()."/images/uploads/".$producto['picture']?>" alt="<?=$producto['name']?>">
        </a>
    </div>
    <div class="card--product-info">
        <h4><a href="<?=base_url()."/shop/service/".$producto['route']?>"><?=$producto['name']?></a></h4>
    </div>
    <div class="card--product-btns">
        <div class="d-flex">
            <a href="<?=base_url()."/shop/service/".$producto['route']?>" class="btn btn-bg-1 w-100">Read more</a>
        </div>
    </div>
</div>