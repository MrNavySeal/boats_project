<?php
    headerPage($data);
    $categories = $data['categories'];
    $productos = $data['products']['productos'];
    $paginas = $data['products']['paginas'];
    $urlCategory = "/".$data['ruta'];

    $nextPage = 2;
    $prevPage = 1;
    $current = isset($_GET['p']) ? intval(strClean($_GET['p'])) : 1 ;
    $urlSort =isset($_GET['s']) ?  "&s=".intval(strClean($_GET['s'])) : "";
    $nextPage = $current+1;
    $prevPage = $current-1;
    
    if($current >= $paginas){
        $nextPage = $paginas;
    }
    if($prevPage <= 0){
        $prevPage = 1;
    }
?>
    <div id="modalItem"></div>
    <div id="modalPoup"></div>
    <main class="addFilter">
         <div class="container bg-white rounded p-2 mt-5 mb-3">
            <nav class="mt-2 mb-2" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a class="text-decoration-none" href="<?=base_url()?>">Home</a></li>
                  <li class="breadcrumb-item"><a class="text-decoration-none" href="<?=base_url()?>/shop/">Shop</a></li>
                  <?php
                    if($productos[0]['routec']!=$data['ruta']){
                  ?>
                  <li class="breadcrumb-item"><a class="text-decoration-none" href="<?=base_url()."/shop/category/".$productos[0]['routec']?>"><?=$productos[0]['category']?></a></li>
                  <li class="breadcrumb-item active" aria-current="page"><?=$productos[0]['subcategory']?></li>
                  <?php }else{?>
                    <li class="breadcrumb-item active" aria-current="page"><?=$productos[0]['category']?></li>
                  <?php }?>
                </ol>
            </nav>
            <div class="row">
                <div class="col-3 col-lg-3 col-md-12">
                    <?php getComponent("asideFilter",$categories);?>
                </div>
                <div class="col-12 col-lg-9 col-md-12">
                    <div class="d-flex align-items-center justify-content-between shop-options">
                        <div class="me-2 c-p" id="filter"><i class="fas fa-filter"></i>Filtro</div>
                    </div>
                    <div class="row" id="productItems">
                        <?php for ($j=0; $j < count($productos); $j++) { 
                            $producto = $productos[$j]; 
                            echo '<div class="col-6 col-lg-3 col-md-6">' ;
                            getComponent("cardProduct",$producto);
                            echo '</div>';
                        } 
                        ?>
                    </div>
                    <div class="pagination">
                        <?php if($current > 1){?>
                        <a href="<?=base_url()."/shop/category".$urlCategory."?p=1".$urlSort?>" class="pagination-btn pagination-start"><i class="fas fa-angle-double-left" aria-hidden="true"></i></a>
                        <a href="<?=base_url()."/shop/category".$urlCategory."?p=".$prevPage.$urlSort?>" class="pagination-btn pagination-prev"><i class="fas fa-angle-left" aria-hidden="true"></i></a>
                        <?php }?>
                        <?php if($current < $paginas){?>
                        <a href="<?=base_url()."/shop/category".$urlCategory."?p=".$nextPage.$urlSort?>" class="pagination-btn pagination-next"><i class="fas fa-angle-right" aria-hidden="true"></i></a>
                        <a href="<?=base_url()."/shop/category".$urlCategory."?p=".$paginas.$urlSort?>" class="pagination-btn pagination-end"><i class="fas fa-angle-double-right" aria-hidden="true"></i></a>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
    </main>
<?php
    footerPage($data);
?>