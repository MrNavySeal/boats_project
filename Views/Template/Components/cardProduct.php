<?php
    $producto = $data;
    $id = openssl_encrypt($producto['idproduct'],METHOD,KEY);
    $discount = "";
    $resultDiscount = "";
    if($producto['discount'] > 0){
        $resultDiscount = floor((1-($producto['discount']/$producto['price']))*100);
    }
    $reference = $producto['reference']!="" ? "REF: ".$producto['reference'] : "";
    $variant = $producto['product_type'] ? "From " : "";
    $price ='</span><span class="current">'.$variant.formatNum($producto['price']).'</span>';
    if($producto['is_stock']){
        if($producto['discount'] > 0 && $producto['stock'] > 0){
            $discount = '<span class="discount">-'.$resultDiscount.'%</span>';
            $price ='<span class="current sale me-2">'.$variant.formatNum($producto['discount'],false).'</span><span class="compare">'.formatNum($producto['price']).'</span>';
        }else if($producto['stock'] <= 0){
            $price = '<span class="current sale me-2">Out of stock</span>';
            $discount="";
        }
    }else{
        if($producto['discount'] > 0){
            $discount = '<span class="discount">-'.$resultDiscount.'%</span>';
            $price ='<span class="current sale me-2">'.$variant.formatNum($producto['discount'],false).'</span><span class="compare">'.formatNum($producto['price']).'</span>';
        }
    }
?>
<div class="card--product bg-white">
    <div class="card--product-img">
        <a href="<?=base_url()."/shop/product/".$producto['route']?>">
            <?=$discount?>
            <img src="<?=$producto['url']?>" alt="<?=$producto['category']." ".$producto['subcategory']?>">
        </a>
    </div>
    <div class="card--product-info">
        <h4><a href="<?=base_url()."/shop/product/".$producto['route']?>"><?=$producto['name']?></a></h4>
        <p class="text-center t-color-3 m-0 fs-6"><?=$reference?></p>
        <div class="card--price">
            <?=$price?>
        </div>
        
    </div>
    <div class="card--product-btns">
        <div class="d-flex">
            <?php if(!$producto['product_type'] && $producto['is_stock'] && $producto['stock'] > 0){?>
            <button type="button" class="btn btn-bg-1" data-id="<?=$id?>" data-topic="2" onclick="addCart(this)">Add to cart <i class="fas fa-shopping-cart"></i></button>
            <?php }else if(!$producto['product_type'] && !$producto['is_stock']){?>
            <button type="button" class="btn btn-bg-1" data-id="<?=$id?>" data-topic="2" onclick="addCart(this)">Add to cart <i class="fas fa-shopping-cart"></i></button>
            <?php }else if($producto['product_type']){?>
            <a href="<?=base_url()."/shop/product/".$producto['route']?>" class="btn btn-bg-1 t-color-4 w-100">Select options <i class="fas fa-exchange-alt"></i></a>
            <?php }?>
        </div>
    </div>
</div>