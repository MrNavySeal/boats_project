<?php
    //dep($data['categories']);exit;
    headerPage($data);
    $social = getSocialMedia();
    $company = getCompanyInfo();
    $links ="";
    $posts = $data['posts'];
    for ($i=0; $i < count($social) ; $i++) { 
        if($social[$i]['link']!=""){
            if($social[$i]['name']=="whatsapp"){
                $links.='<li><a href="https://wa.me/'.$social[$i]['link'].'" target="_blank"><i class="fab fa-'.$social[$i]['name'].'"></i></a></li>';
            }else{
                $links.='<li><a href="'.$social[$i]['link'].'" target="_blank"><i class="fab fa-'.$social[$i]['name'].'"></i></a></li>';
            }
        }
    }

    $tipos = $data['tipos'];
    $productos = $data['productos'];
    $banners = $data['banners'];
    $proCant = 4;
    $sliders = round(count($productos)/$proCant);
    $activeSlider = "active";
    $indexProduct=0;
    $categories = $data['categories'];
    $tipos = $data['tipos'];
?>
    <div id="modalItem"></div>
    <main>
        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php
                    for ($i=0; $i < count($banners); $i++) { 
                        $active="";
                        $a= $banners[$i]['button'] != "" ? '<button class="m-1 btn btn-bg-1">'.$banners[$i]['button'].'</button>' : "";
                        $p = $banners[$i]['description'] !="" ? '<p>'.$banners[$i]['description'].'</p>' : "";
                        if($i == 0)$active="active";
                        $img = media()."/images/uploads/".$banners[$i]['picture'];
                ?>
                <div class="carousel-item slider_item <?=$active?>">
                    <a href="<?=$banners[$i]['link']?>" class="slider_description">
                        <h2><?=$banners[$i]['name']?></h2>
                        <?=$p?>
                        <?=$a?>
                    </a>
                    <img src="<?=$img?>" class="d-block w-100" alt="<?=$banners[$i]['name']?>">
                </div>
                <?php }?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        <section class="container mt-5">
            <h2 class="section--title fs-2">Nuestra tienda</h2>
            <div class="row mb-3">
                <h3>Lo más reciente</h3>
                <div class="row">
                    <div class="product-slider-cat owl-carousel owl-theme mb-5" data-bs-ride="carousel">
                        <?php
                            for ($i=0; $i < count($productos); $i++) { 
                                $id = openssl_encrypt($productos[$i]['idproduct'],METHOD,KEY);
                                $resultDiscount = "";
                                if($productos[$i]['discount'] > 0){
                                    $resultDiscount = floor((1-($productos[$i]['discount']/$productos[$i]['price']))*100);
                                }
                                $discount = "";
                                $reference = $productos[$i]['reference']!="" ? "REF: ".$productos[$i]['reference'] : "";
                                $variant = $productos[$i]['product_type']? "Desde " : "";
                                $price ='</span><span class="current">'.$variant.formatNum($productos[$i]['price']).'</span>';
                                $favorite="";
                                if($productos[$i]['favorite']== 0){
                                    $favorite = '<button type="button" onclick="addWishList(this)" data-id="'.$id.'" class="btn btn-bg-3 btn-fav "><i class="far fa-heart "></i></button>';
                                }else{
                                    $favorite = '<button type="button" onclick="addWishList(this)" data-id="'.$id.'" class="btn btn-bg-3 btn-fav active"><i class="fas fa-heart text-danger "></i></button>';
                                }
                                if($productos[$i]['is_stock']){
                                    if($productos[$i]['discount'] > 0 && $productos[$i]['stock'] > 0){
                                        $discount = '<span class="discount">-'.$resultDiscount.'%</span>';
                                        $price ='<span class="current sale me-2">'.$variant.formatNum($productos[$i]['discount'],false).'</span><span class="compare">'.formatNum($productos[$i]['price']).'</span>';
                                    }else if($productos[$i]['stock'] <= 0){
                                        $price = '<span class="current sale me-2">Agotado</span>';
                                        $discount="";
                                    }
                                }else{
                                    if($productos[$i]['discount']>0){
                                        $discount = '<span class="discount">-'.$resultDiscount.'%</span>';
                                        $price ='<span class="current sale me-2">'.$variant.formatNum($productos[$i]['discount'],false).'</span><span class="compare">'.formatNum($productos[$i]['price']).'</span>';
                                    }
                                }
                        ?>
                        <div class="card--product">
                            <div class="card--product-img">
                                <a href="<?=base_url()."/tienda/producto/".$productos[$i]['route']?>">
                                    <?=$discount?>
                                    <img src="<?=$productos[$i]['url']?>" alt="<?=$productos[$i]['category']." ".$productos[$i]['subcategory']?>">
                                </a>
                            </div>
                            <div class="card--product-info">
                                <h4><a href="<?=base_url()."/tienda/producto/".$productos[$i]['route']?>"><?=$productos[$i]['name']?></a></h4>
                                <p class="text-center t-color-3 m-0 fs-6"><?=$reference?></p>
                                <div class="card--price">
                                    <?=$price?>
                                </div>
                                
                            </div>
                            <div class="card--product-btns">
                                <div class="d-flex">
                                    <?=$favorite?>
                                    <?php if(!$productos[$i]['product_type'] && $productos[$i]['is_stock'] && $productos[$i]['stock'] > 0){?>
                                    <button type="button" class="btn btn-bg-1" data-id="<?=$id?>" data-topic="2" onclick="addCart(this)"><i class="fas fa-shopping-cart"></i></button>
                                    <?php }else if(!$productos[$i]['product_type'] && !$productos[$i]['is_stock']){?>
                                    <button type="button" class="btn btn-bg-1" data-id="<?=$id?>" data-topic="2" onclick="addCart(this)"><i class="fas fa-shopping-cart"></i></button>
                                    <?php }else if($productos[$i]['product_type']){?>
                                    <a href="<?=base_url()."/tienda/producto/".$productos[$i]['route']?>" class="btn btn-bg-1 w-100"><i class="fas fa-exchange-alt"></i></a>
                                    <?php }?>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php
                
                for ($i=0; $i < count($categories) ; $i++) { 
            ?>
            <div class="row mb-5">
                <h3 class="mb-3">
                    <?=$categories[$i]['name']?>
                </h3>
                <div class="col-lg-4 col-md-12 ">
                    <div class="card--category d-flex align-items-center">
                        <div class="card--category-img">
                            <a href="<?=base_url()."/tienda/categoria/".$categories[$i]['route']?>">
                                <img src="<?=media()."/images/uploads/".$categories[$i]['picture']?>" alt="<?=$categories[$i]['name']?>">
                            </a>
                            <h3><a href="<?=base_url()."/tienda/categoria/".$categories[$i]['route']?>" class="text-white"><?=$categories[$i]['name']?></a></h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-12">
                    <?php
                        $productos =$categories[$i]['products'];
                    ?>
                    <div class="row">
                        <div class="product-slider-cat-1 owl-carousel owl-theme">
                            <?php
                                for ($j=0; $j < count($productos); $j++) { 
                                    $id = openssl_encrypt($productos[$j]['idproduct'],METHOD,KEY);
                                    $discount = "";
                                    $resultDiscount = "";
                                    if($productos[$j]['discount'] > 0){
                                        $resultDiscount = floor((1-($productos[$j]['discount']/$productos[$j]['price']))*100);
                                    }
                                    $reference = $productos[$j]['reference']!="" ? "REF: ".$productos[$j]['reference'] : "";
                                    $variant = $productos[$j]['product_type'] ? "Desde " : "";
                                    $price ='</span><span class="current">'.$variant.formatNum($productos[$j]['price']).'</span>';
                                    $favorite="";
                                    if($productos[$j]['favorite']== 0){
                                        $favorite = '<button type="button" onclick="addWishList(this)" data-id="'.$id.'" class="btn btn-bg-3 btn-fav "><i class="far fa-heart "></i></button>';
                                    }else{
                                        $favorite = '<button type="button" onclick="addWishList(this)" data-id="'.$id.'" class="btn btn-bg-3 btn-fav active"><i class="fas fa-heart text-danger "></i></button>';
                                    }
                                    if($productos[$j]['is_stock']){
                                        if($productos[$j]['discount'] > 0 && $productos[$j]['stock'] > 0){
                                            $discount = '<span class="discount">-'.$resultDiscount.'%</span>';
                                            $price ='<span class="current sale me-2">'.$variant.formatNum($productos[$j]['discount'],false).'</span><span class="compare">'.formatNum($productos[$j]['price']).'</span>';
                                        }else if($productos[$j]['stock'] <= 0){
                                            $price = '<span class="current sale me-2">Agotado</span>';
                                            $discount="";
                                        }
                                    }else{
                                        if($productos[$j]['discount'] > 0){
                                            $discount = '<span class="discount">-'.$resultDiscount.'%</span>';
                                            $price ='<span class="current sale me-2">'.$variant.formatNum($productos[$j]['discount'],false).'</span><span class="compare">'.formatNum($productos[$j]['price']).'</span>';
                                        }
                                    }
                            ?>
                            <div class="card--product">
                                <div class="card--product-img">
                                    <a href="<?=base_url()."/tienda/producto/".$productos[$j]['route']?>">
                                        <?=$discount?>
                                        <img src="<?=$productos[$j]['url']?>" alt="<?=$productos[$j]['category']." ".$productos[$j]['subcategory']?>">
                                    </a>
                                </div>
                                <div class="card--product-info">
                                    <h4><a href="<?=base_url()."/tienda/producto/".$productos[$j]['route']?>"><?=$productos[$j]['name']?></a></h4>
                                    <p class="text-center t-color-3 m-0 fs-6"><?=$reference?></p>
                                    <div class="card--price">
                                        <?=$price?>
                                    </div>
                                    
                                </div>
                                <div class="card--product-btns">
                                    <div class="d-flex">
                                        <?=$favorite?>
                                        <?php if(!$productos[$j]['product_type'] && $productos[$j]['is_stock'] && $productos[$j]['stock'] > 0){?>
                                        <button type="button" class="btn btn-bg-1" data-id="<?=$id?>" data-topic="2" onclick="addCart(this)"><i class="fas fa-shopping-cart"></i></button>
                                        <?php }else if(!$productos[$j]['product_type'] && !$productos[$j]['is_stock']){?>
                                        <button type="button" class="btn btn-bg-1" data-id="<?=$id?>" data-topic="2" onclick="addCart(this)"><i class="fas fa-shopping-cart"></i></button>
                                        <?php }else if($productos[$j]['product_type']){?>
                                        <a href="<?=base_url()."/tienda/producto/".$productos[$j]['route']?>" class="btn btn-bg-1 w-100"><i class="fas fa-exchange-alt"></i></a>
                                        <?php }?>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php }?>
        </section>
    </main>
<?php
    footerPage($data);
?>
    