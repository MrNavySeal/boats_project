<?php
    $company = getCompanyInfo();
    $navCategories=$data;
?>
<div class="navmobile">
    <div class="navmobile--mask"></div>
    <div class="navmobile--elements">
        <div class="navmobile--header align-items-center">
            <div class="d-flex align-items-center logo-desktop">
                <img class="me-2" src="<?=media()."/images/uploads/".$company['logo']?>" alt="<?=$company['name']?>" width="80">
                <span class="fs-2 fw-bold t-color-2"><?=$company['name']?></span>
            </div>
            <span id="closeNav" class="t-color-2"><i class="fas fa-times"></i></span>
        </div>
        <ul class="navmobile-links d-none" id="navProfile">                      
            <?php
                if(!isset($_SESSION['login'])){
            ?>
            <li class="navmobile-link" onclick="openLoginModal();"><a href="#">Log in</a></li>
            <?php }?>
        </ul>
        <ul class="navmobile-links d-none" id="filterNav">
            <div class="navmobile-link accordion" id="accordionCategory">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-categories">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseCategories" aria-expanded="false" aria-controls="flush-collapseCategories">
                        <strong class="fs-5">Shop</strong>
                    </button>
                    </h2>
                    <div id="flush-collapseCategories" class="accordion-collapse collapse show" aria-labelledby="flush-categories" data-bs-parent="#accordionFlushCategories">
                    <div class="accordion-body">
                        <div class="accordion accordion-flush" id="accordionFlushCategorie">
                            <?php
                                for ($i=0; $i < count($navCategories) ; $i++) { 
                                    $routeC = base_url()."/shop/category/".$navCategories[$i]['route'];
                            ?>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-categorie<?=$i?>">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseCategorie<?=$i?>" aria-expanded="false" aria-controls="flush-collapseCategorie<?=$i?>">
                                </button>
                                <a href="<?=$routeC?>" class="text-decoration-none"><?=$navCategories[$i]['name']?></a>
                                </h2>
                                <div id="flush-collapseCategorie<?=$i?>" class="accordion-collapse collapse" aria-labelledby="flush-categorie<?=$i?>" data-bs-parent="#accordionFlushCategorie<?=$i?>">
                                <div class="accordion-body">
                                    <ul class="list-group">
                                        <?php
                                            for ($j=0; $j < count($navCategories[$i]['subcategories']) ; $j++) { 
                                                $navSubCategories = $navCategories[$i]['subcategories'][$j];
                                                if($navSubCategories['total'] >0){
                                                    $routeS = base_url()."/shop/category/".$navCategories[$i]['route']."/".$navSubCategories['route'];
                                            ?>
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        <a href="<?=$routeS?>"><?=$navSubCategories['name']?></a>
                                                        <span class="badge bg-color-2 rounded-pill"><?=$navSubCategories['total']?></span>
                                                    </li>
                                        <?php } }?>
                                    </ul>
                                </div>
                                </div>
                            </div>
                            <?php }?>
                            <li class="navmobile-link"><a href="<?=base_url()?>/shop">All</a></li>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            <li class="navmobile-link"><a href="<?=base_url()?>/services/"><strong class="fs-5">Services</strong></a></li>
            <li class="navmobile-link"><a href="<?=base_url()?>/about/"><strong class="fs-5">About</strong></a></li>
            <li class="navmobile-link"><a href="<?=base_url()?>/contact/"><strong class="fs-5">Contact us</strong></a></li>
            <?php if(!isset($_SESSION['login'])){ ?>
            <li class="navmobile-link" onclick="openLoginModal();"><a href="#"><strong class="fs-5">Log in</strong></a></li>
            <?php }else {?>
            <li class="navmobile-link"><a href="<?=base_url()?>/profile/"><strong class="fs-5">My profile</strong></a></li>
            <?php }?>
        </ul>
    </div>
</div>