<?php

    $title = $company['name'];
    $urlWeb = base_url();
    $urlImg =media()."/images/uploads/".$company['logo'];
    $description =$company['description'];
    $company = getCompanyInfo();
    if(!empty($data['product'])){
        $urlWeb = base_url()."/tienda/producto/".$data['product']['route'];
        $urlImg = $data['product']['image'][0]['url'];
        $title = $data['product']['name'];
        $description = $data['product']['shortdescription'];
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?=$company['description']?>">
    <meta name="author" content="<?=$company['name']?>" />
    <meta name="copyright" content="<?=$company['name']?>"/>
    <meta name="robots" content="index,follow"/>
    <meta name="keywords" content="<?=$company['keywords']?>"/>

    <title><?=$data['page_title']?></title>
    <link rel ="shortcut icon" href="<?=media()."/images/uploads/".$company['logo']?>" sizes="114x114" type="image/png">

    <meta property="fb:app_id"          content="1234567890" /> 
    <meta property="og:locale" 		content='es_ES'/>
    <meta property="og:type"        content="article" />
    <meta property="og:site_name"	content="<?= $company['name']; ?>"/>
    <meta property="og:description" content="<?=$description?>"/>
    <meta property="og:title"       content="<?= $title; ?>" />
    <meta property="og:url"         content="<?= $urlWeb; ?>" />
    <meta property="og:image"       content="<?= $urlImg; ?>" />
    <meta name="twitter:card" content="summary"></meta>
    <meta name="twitter:site" content="<?= $urlWeb; ?>"></meta>
    <meta name="twitter:creator" content="<?= $company['name']; ?>"></meta>
    <link rel="canonical" href="<?= $urlWeb?>"/>

    <!------------------------------Frameworks--------------------------------->
    <link rel="stylesheet" href="<?=media();?>/frameworks/bootstrap/bootstrap.min.css">
    
    <!------------------------------Plugins--------------------------------->
    <link href="<?= media();?>/plugins/datepicker/jquery-ui.min.css" rel="stylesheet">
    <link href="<?=media();?>/plugins/fontawesome/font-awesome.min.css">
    <link rel="stylesheet" href="<?=media();?>/plugins/owlcarousel/owl.carousel.min.css">
    <link rel="stylesheet" href="<?=media();?>/plugins/owlcarousel/owl.theme.default.min.css">
    <link rel="stylesheet" href="<?=media();?>/plugins/datatables/datatables.min.css">
    <!------------------------------------Styles--------------------------->
    <link rel="stylesheet" href="<?=media()?>/template/Assets/css/normalize.css">
    <link rel="stylesheet" href="<?=media()."/template/Assets/css/style.css?v=".rand()?>">
    <script src="<?= media();?>/plugins/tinymce/tinymce.min.js"></script>
    

</head>
<body class="bg-light">
    <div class="gallery-container d-none d-flex justify-content-center align-items-center">
       <div class="container d-flex justify-content-between align-items-center">
            <div onclick="getGallery('','left')" class="c-p fs-1 fw-bold p-4 text-white d-flex justify-content-center align-items-center mt-2" style="height: 100vh;"><i class="fas fa-caret-left"></i></div>
            <div class="position-absolute top-0 end-0 text-white bg-color-1 fs-4 rounded-circle ps-3 pe-3 c-p closeGallery">x</div>
            <div class="position-relative" style="height:50%">
                <img src="<?=media()?>/images/uploads/about.jpg" class="img-fluid rounded gallery-picture" data-id="0" alt="...">
            </div>
            <div onclick="getGallery('','right')" class="c-p fs-1 fw-bold p-4 text-white d-flex justify-content-center align-items-center" style="height: 100vh;"><i class="fas fa-caret-right"></i></div>
       </div>
    </div>
    <div id="app">
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
            <img src="..." class="rounded me-2" alt="..." height="20" width="20">
            <strong class="me-auto" id="toastProduct"></strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
            Hello, world! This is a toast message.
            </div>
        </div>
    </div>
    <!-- <div id="divLoading"> <div></div> <span>Cargando...</span> </div> -->
    <?php getComponent("headerNav");?>
    <div id="modalLogin"></div>
    
    