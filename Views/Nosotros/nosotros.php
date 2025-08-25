<?php
    headerPage($data);
    $galeria = $data['gallery'];
?>
<main>
    <?php getComponent("pageCover",$data); ?>
    <?php getComponent("AboutSection"); ?>
    <?php getComponent("whyUs"); ?>
    <?php getComponent("gallery",['titulo'=>"Our gallery","subtitulo"=>"","datos"=>$galeria]); ?>
</main>
<?php footerPage($data);?>