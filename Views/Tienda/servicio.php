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
    <div class="container bg-white rounded p-2 mt-4 mb-5">
        <main id="product">
            <div class=" mt-4 mb-4">
                <nav class="mt-2 mb-2" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a class="text-decoration-none" href="<?=base_url()?>">Home</a></li>
                      <li class="breadcrumb-item">Shop</li>
                      <li class="breadcrumb-item">Services</li>
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
                        <?php foreach ($faq as $key) { ?>
                        <div class="navmobile-link accordion " id="accordionService<?=$key['id']?>">
                            <div class="accordion-item">
                                <h2 class="accordion-header " id="flush-services<?=$key['id']?>">
                                <button class="accordion-button collapsed bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseServices<?=$key['id']?>" aria-expanded="false" aria-controls="flush-collapseServices<?=$key['id']?>">
                                    <strong class="fs-5"><?= $key['question']?></strong>
                                </button>
                                </h2>
                                <div id="flush-collapseServices<?=$key['id']?>" class="accordion-collapse collapse " aria-labelledby="flush-services<?=$key['id']?>" data-bs-parent="#accordionFlushServices<?=$key['id']?>">
                                    <div class="accordion-body bg-light pe-2 ps-2">
                                        <div class="bg-white rounded pe-2 ps-2 fw-normal">
                                            <?= $key['answer']?> Lorem ipsum dolor sit amet consectetur adipisicing elit. Sint natus accusantium earum facilis alias illo nemo tempore esse voluptate ullam, hic, id delectus libero. Voluptatem exercitationem laborum recusandae eius totam!
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php }?>
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
                        <div class="bg-color-1 rounded">
                            <div class="p-4">
                                <h3 class="section--title t-color-4 fs-4 mb-0 text-start">- Keep Your Boat in top condition</h3>
                                <a href="<?=base_url()?>/contact/" class="pb-2 section--title t-color-4 text-start">Contact us today</a>
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
                <?php getComponent("gallery",['titulo'=>"Our gallery","subtitulo"=>"","datos"=>$galeria]); ?>
            </div>
        </main>
    </div>
<?php
    footerPage($data);
?>