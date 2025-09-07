<?php
    headerPage($data);
    $service =$data['service'];
    $services = $data['services'];
    $faq = $data['faq'];
    $productos = $data['productos'];
    $galeria = $data['gallery'];
    $company = getCompanyInfo();
?>
    <?=$data['modal']?>
    <div id="modalItem"></div>
    <div class=" bg-white p-2 mb-5">
        <main id="product">
            <div class="container p-2">
                <nav class="mt-5 mb-2" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a class="text-decoration-none" href="<?=base_url()?>">Home</a></li>
                      <li class="breadcrumb-item"><a class="text-decoration-none" href="<?=base_url()?>/Shop/">Shop</a></li>
                      <li class="breadcrumb-item"><a class="text-decoration-none" href="<?=base_url()?>/Shop/services/">Services</a></li>
                      <li class="breadcrumb-item active" aria-current="page"><?=$service['name']?></li>
                    </ol>
                </nav>
                <div class="row ps-2 pe-2 pb-4">
                    <div class="col-md-8 mb-3">
                        <?php if($service['picture'] !='category.jpg'){?>
                        <div class="product-image p-0 mt-2">
                            <img src="<?=media()."/images/uploads/".$service['picture']?>" class="d-block w-100 rounded" alt="<?=$service['name']?>">
                        </div>
                         <?php }?>
                        <h1><?=$service['name']?></h1>
                        <p class="mb-2 mt-2"><?=$service['short_description']?></p>
                        <div class="service-description"><?=$service['description']?></div>
                        
                    </div>
                    <div class="col-md-4 product-data">
                        <div class="mb-5 bg-light rounded">
                            <div class="p-3">
                                <h2 class="text-center">Other services</h2>
                                <?php  foreach ($services as $serv) { if($serv['name'] != $service['name']){ ?>
                                <div class="bg-color-2 p-2 rounded mb-1"><a class="t-color-4 text-center fs-4" href="<?=base_url()."/shop/service/".$serv['route']?>"><?=$serv['name']?></a></div>
                                <?php } }?>
                            </div>
                        </div>
                        <div class="rounded">
                            <div class="p-4">
                                <h3 class="section--title t-color-2 fw-bold fs-4 mb-0 text-center">Keep Your Boat in top condition</h3>
                                <div class="d-flex justify-content-center mt-4">
                                    <button type="button" class="btn btn-bg-2" onclick="openSchedule()">Schedule online</button>
                                </div>
                            </div>
                        </div>
                        <?php if(!empty($productos)){?>
                        <div class="mt-5 mb-5">
                            <h2 class="text-center">Our recent products</h2>
                            <div class="product-slider-cat owl-carousel owl-theme mb-5" data-bs-ride="carousel">
                                <?php for ($j=0; $j < count($productos); $j++) { $producto = $productos[$j]; getComponent("cardProduct",$producto);} ?>
                            </div>
                        </div>
                        <?php }?>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <?php getComponent("faqSection",$faq)?>
    <div class="container bg-white rounded">
        <?php getComponent("gallery",['titulo'=>"Our gallery","subtitulo"=>"","datos"=>$galeria]); ?>
    </div>
<?php
    footerPage($data);
?>