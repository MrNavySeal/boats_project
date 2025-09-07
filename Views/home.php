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

    $productos = $data['productos'];
    $servicios = $data['servicios'];
    $galeria = $data['galeria'];
    $banners = $data['banners'];
    $proCant = 4;
    $sliders = round(count($productos)/$proCant);
    $activeSlider = "active";
    $categories = $data['categories'];
    $contact = $data['contact'];
    $about = $data['about'];
?>
    <div id="modalItem"></div>
    <main>
        <div id="carouselExampleControls" class="carousel slide bg-white" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php
                    for ($i=0; $i < count($banners); $i++) { 
                        $active="";
                        $a= $banners[$i]['button'] != "" ? '<a href="'.$banners[$i]['link'].'" class="btn btn-primary">'.$banners[$i]['button'].'</a>' : "";
                        $p = $banners[$i]['description'] !="" ? '<p>'.$banners[$i]['description'].'</p>' : "";
                        if($i == 0)$active="active";
                        $img = media()."/images/uploads/".$banners[$i]['picture'];
                ?>
                <div class="carousel-item <?=$active?>">
                    <div class="row p-4 mt-4" style="height:500px">
                        <div class="col-md-6 d-flex align-items-center  mb-3">
                            <div>
                                <h2 class="fs-1 fw-bold"><?=$banners[$i]['name']?></h2>
                                <?=$p?>
                                <div class="d-flex gap-2">
                                    <?=$a?>
                                    <button type="button" class="btn btn-secondary" onclick="openSchedule()">Schedule online</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 d-flex align-items-center mb-3 overflow-hidden">
                            <img src="<?=$img?>" class="img-fluid border rounded" alt="<?=$banners[$i]['name']?>">
                        </div>
                    </div>
                    <!-- <div class="d-flex">
                        <img src="<?=$img?>" class="object-fit-fill border rounded" alt="<?=$banners[$i]['name']?>">
                        <a href="<?=$banners[$i]['link']?>" class="slider_description">
                            <h2><?=$banners[$i]['name']?></h2>
                            <?=$p?>
                            <?=$a?>
                        </a>
                    </div> -->
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
        <?php getComponent("serviceSection",['titulo'=>"Our services","subtitulo"=>"We offer a full suite of underwater cleaning services to keep your vessel and dock sparkling clean.","datos"=>$servicios])?>
        <?php getComponent("ProductsCarouselSection",['titulo'=>"Marine Products","subtitulo"=>"Professional-grade cleaning and maintenance products trusted by boat owners and marine professionals","datos"=>$productos]);?>
        <?php getComponent("AboutSection",$about); ?>
        <?php getComponent("faqSection",$data['faq']);?>
        <?php getComponent("gallery",['titulo'=>"Our gallery","subtitulo"=>"","datos"=>$galeria]); ?>
        <?php getComponent("contactForm",['titulo'=>$contact['title'],"subtitulo"=>$contact['subtitle'],"datos"=>$servicios])?>
    </main>
<?php
    footerPage($data);
?>
    