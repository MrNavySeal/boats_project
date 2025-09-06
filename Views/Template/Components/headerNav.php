<?php
    $qtyCart = 0;
    $total = 0;
    $arrProducts = array();
    $subLinks = navSubLinks();
    $company = getCompanyInfo();
    $navCategories=getNavCat();
    $navServices=getNavServices();
    if(isset($_SESSION['arrCart']) && !empty($_SESSION['arrCart'])){
        $arrProducts = $_SESSION['arrCart'];
        foreach ($arrProducts as $product) {
            $qtyCart += $product['qty'];
            $total+=$product['price']*$product['qty']; 
        }
    }
    
?>
<header class="bg-white">
    <nav class="nav--bar">
        <div class="d-flex align-items-center logo-desktop">
            <img class="me-2" src="<?=media()."/images/uploads/".$company['logo']?>" alt="<?=$company['name']?>" width="80">
            <span class="fs-3 fw-bold"><?=$company['name']?></span>
        </div>
        <div class="icon-mobile">
            <a href="<?=base_url()?>">
                <img src="<?=media()."/images/uploads/".$company['logo']?>" alt="<?=$company['name']?>">
            </a>
        </div>
        <ul class="nav--links">
            <li class="nav-link"><a href="<?=base_url()?>">Home</a></li>
            <div class="nav-link dropdown">
                <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    Shop
                    <i class="fas fa-angle-down dropdown-icon"></i>
                </a>
                <ul class="dropdown-menu">
                    <?php 
                        for ($i=0; $i < count($subLinks['categories']); $i++) { 
                            $link = $subLinks['categories'][$i];
                            if($i <= 8){
                    ?>
                    <li><a class="dropdown-item" href="<?=base_url()."/shop/category/".$link['route']?>"><?=$link['name']?></a></li>
                    <?php } }?>
                    <hr>
                    <li><a class="dropdown-item" href="<?=base_url()?>/shop/">All</a></li>
                </ul>
            </div>
            <div class="nav-link dropdown">
                <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    Services
                    <i class="fas fa-angle-down dropdown-icon"></i>
                </a>
                <ul class="dropdown-menu">
                    <?php 
                        for ($i=0; $i < count($subLinks['services']); $i++) { 
                            $link = $subLinks['services'][$i];
                    ?>
                    <li><a class="dropdown-item" href="<?=base_url()."/shop/service/".$link['route']?>"><?=$link['name']?></a></li>
                    <?php } ?>
                    <hr>
                    <li><a class="dropdown-item" href="<?=base_url()?>/shop/services/">All</a></li>
                </ul>
            </div>
            <li class="nav-link"><a href="<?=base_url()?>/about/">About</a></li>
            <li class="nav-link"><a href="<?=base_url()?>/gallery/">Gallery</a></li>
        </ul>
        <ul class="nav--links">
            <li class="nav--icon p-0" ><button type="button" onclick="window.open('tel:'<?='+1'.$company['phone']?>)" class="btn btn-primary w-100 "><i class="fas fa-phone" aria-hidden="true"></i> <?=$company['phone']?></button></li>
            <li class="nav--icon p-0" ><button type="button" class="btn btn-secondary w-100 " onclick="openSchedule()">Schedule online</button></li>
            <li class="nav--icon" id="btnSearch"><i class="fas fa-search"></i></li>
            <li class="nav--icon nav--icon-cart" id="btnCart">
                <span id="qtyCart"><?=$qtyCart?></span>
                <i class="fas fa-shopping-cart"></i>
            </li>
            <?php
                    if(isset($_SESSION['login'])){
                ?>
                <div class="nav-link dropdown">
                    <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user"></i>
                        <i class="fas fa-angle-down dropdown-icon"></i>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item " href="<?=base_url()?>/profile/">My profile</a></li>
                        <li id="logout"><a href="#" class="dropdown-item">Log out</a></li>
                    </ul>
                </div>
                <?php }else{ ?>
                <li onclick="openLoginModal();" title="My account" class="btn btn-bg-1" >Log in</li> 
            <?php }?>
            <li class="nav--icon" id="btnNav"><i class="fas fa-bars"></i></li>
        </ul>
    </nav>
</header>
<div class="search">
    <span id="closeSearch"><i class="fas fa-times"></i></span>
    <form action="<?=base_url()?>/shop/search/" method="GET">
        <input type="search" name="b" id="" placeholder="Search...">
        <button type="submit" class="btn"><i class="fas fa-search"></i></button>
    </form>
</div>
<?php getComponent("cartBar");getComponent("navMobile",['categories'=>$navCategories,'services'=>$subLinks['services']]);?>
