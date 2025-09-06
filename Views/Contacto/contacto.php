<?php
    headerPage($data);
    $company = getCompanyInfo();
    $social = getSocialMedia();

    $links ="";
    for ($i=0; $i < count($social) ; $i++) { 
        if($social[$i]['link']!=""){
            if($social[$i]['name']=="whatsapp"){
                $links.='<li><a href="https://wa.me/'.$social[$i]['link'].'" target="_blank"><i class="fab fa-'.$social[$i]['name'].'"></i></a></li>';
            }else{
                $links.='<li><a href="'.$social[$i]['link'].'" target="_blank"><i class="fab fa-'.$social[$i]['name'].'"></i></a></li>';
            }
        }
    }
    $servicios = $data['servicios'];
?>
    <div class="container p-2 mt-4 mb-5">
        <nav class="mt-2 mb-2" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a class="text-decoration-none" href="<?=base_url()?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Contact us</li>
            </ol>
        </nav>
         <?php getComponent("contactForm",['titulo'=>$data['page']['title'],"subtitulo"=>$data['page']['subtitle'],"datos"=>$servicios])?>
    </div>
<?php
    footerPage($data);
?>