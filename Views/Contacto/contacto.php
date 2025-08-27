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
<?php getComponent("pageCover",$data); ?>
    <div class="container mt-4">
        <?php getComponent("contactForm",['titulo'=>$data['page']['title'],"subtitulo"=>$data['page']['subtitle'],"datos"=>$servicios])?>
    </div>
<?php
    footerPage($data);
?>