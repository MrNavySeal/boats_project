<?php
    headerPage($data);
    $company = getCompanyInfo();
    $product = $data['product'];
    $productos = $data['products'];
    $reviews = $data['reviews'];
    $price ='<span class="current me-2">'.formatNum($product['price'],false).'</span>';
    $rate="";
    $stock ="";
    $showBtns = !$product['is_stock'] || ($product['is_stock'] && $product['stock'] > 0) ? "" : "d-none";
    $resultDiscount = floor((1-($product['discount']/$product['price']))*100);
    $discount = $product['discount'] > 0 ? '<span class="discount" id="productDiscount">-'.$product['discount'].'%</span>' : "";
    $reference = $product['reference']!="" ? "REF: ".$product['reference'] : "";

    if($product['reference'] !=""){
        $reference = '<a href="'.base_url()."/tienda/producto/".$product['route'].'" class="m-0">Referencia:<strong> '.$product['reference'].'</strong></a><br>';
    }
    if($product['is_stock']){
        $stock = 'max="'.$product['stock'].'"';
        if($product['discount'] > 0 && $product['stock'] > 0){
            $discount = '<span class="discount" id="productDiscount">-'.$resultDiscount.'%</span>';
            $price ='<span class="current sale me-2">'.formatNum($product['discount'],false).'</span><span class="compare">'.formatNum($product['price']).'</span>';
        }else if($product['stock'] <= 0){
            $price = '<span class="current sale me-2">Agotado</span>';
            $discount="";
        }
    }else{
        if($product['discount']>0){
            $discount = '<span class="discount" id="productDiscount">-'.$resultDiscount.'%</span>';
            $price ='<span class="current sale me-2">'.formatNum($product['discount'],false).'</span><span class="compare">'.formatNum($product['price']).'</span>';
        }
    }
    for ($i = 0; $i < 5; $i++) {
        if($product['rate']>0 && $i >= intval($product['rate'])){
            $rate.='<i class="far fa-star"></i>';
        }else if($product['rate'] == 0){
            $rate.='<i class="far fa-star"></i>';
        }else{
            $rate.='<i class="fas fa-star"></i>';
        }
    }

    $favorite="";

    

    $id = openssl_encrypt($product['idproduct'],METHOD,KEY);
    $urlShare = base_url()."/tienda/producto/".$product['route'];

    if($product['favorite']== 0){
        $favorite = '<button type="button" onclick="addFav(this)" data-id="'.$id.'" class="mb-3 btn btn-bg-3 btn-fav "><i class="far fa-heart "></i> Agregar a favoritos </button>';
    }else{
        $favorite = '<button type="button" onclick="addFav(this)" data-id="'.$id.'" class="mb-3 btn btn-bg-3 btn-fav active"><i class="fas fa-heart text-danger "></i> Mi favorito</button>';
    }
?>
    <?=$data['modal']?>
    <div id="modalItem"></div>
    <div class="container bg-white rounded p-2 mt-4 mb-5">
        <main id="product">
            <div class=" mt-4 mb-4">
                <nav class="mt-2 mb-2" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a class="text-decoration-none" href="<?=base_url()?>">Home</a></li>
                      <li class="breadcrumb-item"><a class="text-decoration-none" href="<?=base_url()?>/shop/">Shop</a></li>
                      <li class="breadcrumb-item"><a class="text-decoration-none" href="<?=base_url()."/shop/category/".$product['routec']?>"><?=$product['category']?></a></li>
                      <li class="breadcrumb-item"><a class="text-decoration-none" href="<?=base_url()."/shop/category/".$product['routec']."/".$product['routes']?>"><?=$product['subcategory']?></a></li>
                      <li class="breadcrumb-item active" aria-current="page"><?=$product['name']?></li>
                    </ol>
                </nav>
                <div class="row ps-2 pe-2 pb-4">
                    <div class="col-md-5 mb-3">
                        <div class="product-image">
                            <?=$discount?>
                            <img src="<?=$product['image'][0]['url']?>" class="d-block w-100" alt="<?=$product['category']." ".$product['subcategory']?>">
                        </div>
                        <div class="product-image-slider">
                            <div class="slider-btn-left"><i class="fas fa-angle-left" aria-hidden="true"></i></div>
                            <div class="product-image-inner">
                                <?php
                                    for ($i=0; $i < count($product['image']) ; $i++) { 
                                        $active="";
                                        if($i== 0){
                                            $active = "active";
                                        }
                                ?>
                                <div class="product-image-item <?=$active?>"><img src="<?=$product['image'][$i]['url']?>" alt="<?=$product['category']." ".$product['subcategory']?>"></div>
                                <?php }?>
                            </div>
                            <div class="slider-btn-right"><i class="fas fa-angle-right" aria-hidden="true"></i></div>
                        </div>
                    </div>
                    <div class="col-md-7 product-data">
                        <h1><a href="<?=base_url()."/shop/product/".$product['route']?>"><strong><?=$product['name']?></strong></a></h1>
                        <p class="fs-3 mt-3"><strong class="t-p" id="productPrice"><?=$price?></strong></p>
                        <?php
                        if($product['product_type'] == 1){
                            $variants = $product['variation'];
                            $default = $product['default'];
                        ?>
                        <div class="mb-3">
                            
                            <?php
                                for ($i=0; $i < count($variants); $i++) { 
                                    $options = $variants[$i]['options'];
                                    $selected = $default[$i]; 
                            ?>
                                <p class="t-color-3 m-0"><?=$variants[$i]['name']?></p>
                                <div class="contentVariant">
                                <?php for ($j=0; $j < count($options) ; $j++) { 
                                    $active= $selected == $options[$j] ? "active" : "";
                                ?>
                                <button onclick ="selVariant(this)" data-idp="<?=$id?>" data-name="<?= $options[$j]?>" 
                                type="button" class="<?=$active?> btn btnv btn-bg-2 m-1">
                                    <?= $options[$j]?>
                                </button>
                                <?php  } ?>
                                </div>
                                <?php } ?>
                        </div>
                        <?php  }?>
                        <p class="mb-3"><?=$product['shortdescription']?></p>
                        <?=$reference?>
                        <a href="<?=base_url()."/tienda/categoria/".$product['routec']?>" class="m-0">Category:<strong> <?=$product['category']?></strong></a><br>
                        <a href="<?=base_url()."/tienda/categoria/".$product['routec']."/".$product['routes']?>" class="m-0">Subcategory:<strong> <?=$product['subcategory']?></strong></a>
                        
                        <div class="mt-4 mb-4 d-flex align-items-center">
                            <div class="d-flex justify-content-center align-items-center flex-wrap mt-3">
                                <div class="d-flex justify-content-center align-items-center flex-wrap <?=$showBtns?>" id="showBtns">
                                    <div class="btn-qty-1 mb-3 me-3" id="btnPqty">
                                        <button class="btn" id="btnPDecrement"><i class="fas fa-minus"></i></button>
                                        <input type="number" name="txtQty" id="txtQty" min="1" <?=$stock?> value="1">
                                        <button class="btn" id="btnPIncrement"><i class="fas fa-plus"></i></button>
                                    </div>
                                    <button type="button" class="btn btn-bg-1 me-3 mb-3" onclick="addProductCart(this)" data-id="<?=$id?>" data-topic="2" data-type="<?=$product['product_type']?>"><i class="fas fa-shopping-cart"></i> Add</button>
                                </div>
                            </div>
                        </div>
                        <section class="mt-3">
                            <ul class="nav nav-pills mb-3" id="product-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pills-specification-tab" data-bs-toggle="pill" data-bs-target="#pills-specification" type="button" role="tab" aria-controls="pills-specification" aria-selected="true">Features</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-description-tab" data-bs-toggle="pill" data-bs-target="#pills-description" type="button" role="tab" aria-controls="pills-description" aria-selected="false">Description</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-specification" role="tabpanel" aria-labelledby="pills-specification-tab" tabindex="0">
                                    <?php
                                        $spec = "";
                                        if(!empty($product['specifications'])){
                                            $spec = $product['specifications'];
                                    ?>
                                    <table class="table table-bordered">
                                        <tbody>
                                                <?php
                                                for ($i=0; $i < count($spec) ; $i++) {
                                                ?>
                                                <tr>
                                                    <td class="bg-light"><?=$spec[$i]['name']?></td>
                                                    <td><?=$spec[$i]['value']?></td>
                                                </tr>
                                                <?php  }?>
                                        </tbody>
                                    </table>
                                    <?php  }?>
                                </div>
                                <div class="tab-pane fade" id="pills-description" role="tabpanel" aria-labelledby="pills-description-tab" tabindex="0">
                                    <?=$product['description']?>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </main>
        <section class="mt-4">
            <?php if(!empty($productos)){?>
            <h2 class="section--title">More products</h2>
            <div class="row">
                <div class="product-slider-cat owl-carousel owl-theme">
                <?php for ($j=0; $j < count($productos); $j++) {  $producto = $productos[$j];  getComponent("cardProduct",$producto); }  ?>
            </div>
            <?php }?> 
        </section>
    </div>
<?php
    footerPage($data);
?>