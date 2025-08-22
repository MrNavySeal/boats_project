<?php
    headerPage($data);
    $service =$data['service'];
    $services = $data['services'];
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
                    <div class="col-md-7 mb-3">
                        <h1><?=$service['name']?></h1>
                        <?php if($service['picture'] !='category.jpg'){?>
                        <div class="product-image p-0 mt-2">
                            <img src="<?=media()."/images/uploads/".$service['picture']?>" class="d-block w-100" alt="<?=$service['name']?>">
                        </div>
                         <?php }?>
                        <p class="mb-2 mt-2"><?=$service['short_description']?></p>
                        <div><?=$service['description']?></div>
                        <div class="d-flex justify-content-center align-items-center">
                            <button type="button" class="btn btn-bg-1 me-3 mb-3">Don't wait more and contact us!</button>
                        </div>
                    </div>
                    <div class="col-md-5 product-data">
                        <h2 class="text-center">Other services</h2>
                        <div class="bg-light p-3">
                            <?php  foreach ($services as $serv) { if($serv['name'] != $service['name']){ ?>
                            <div class="bg-color-2 p-2 rounded mb-1"><a class="t-color-4 text-center fs-4" href="<?=base_url()."/shop/service/".$serv['route']?>"><?=$serv['name']?></a></div>
                            <?php } }?>
                        </div>

                    </div>
                </div>
            </div>
        </main>
    </div>
    <div class="bg-color-2">
        <div class="container">
            <div class="py-2">
                <h3 class="section--title t-color-1 fs-4 mb-0 text-start">- Keep Your Boat at Its Best</h3>
                <a href="#" class="pb-2 section--title fs-1 t-color-4 text-start">Contact us today</a>
            </div>
        </div>
    </div>
<?php
    footerPage($data);
?>