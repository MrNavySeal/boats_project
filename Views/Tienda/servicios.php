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
    <div class="container p-2 mt-4 mb-5">
        <nav class="mt-2 mb-2" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a class="text-decoration-none" href="<?=base_url()?>">Home</a></li>
                <li class="breadcrumb-item"><a class="text-decoration-none" href="<?=base_url()?>/shop/">Shop</a></li>
                <li class="breadcrumb-item active" aria-current="page">Services</li>
            </ol>
        </nav>
        <div class="row">
            <?php for ($j=0; $j < count($services); $j++) { 
                $servicio = $services[$j]; 
                echo '<div class="col-md-3">';
                getComponent("cardService",$servicio);
                echo '</div>';
                } 
            ?>
        </div>
    </div>
<?php
    footerPage($data);
?>