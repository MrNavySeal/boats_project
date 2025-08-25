<?php
    headerPage($data);
    $galeria = $data['gallery'];
    $servicios = $data['servicios'];
?>
<main>
    <?php getComponent("pageCover",$data); ?>
    <?php getComponent("AboutSection"); ?>
    <?php getComponent("whyUs"); ?>
    <?php getComponent("serviceSection",['titulo'=>"Our services","subtitulo"=>"Full suite of underwater cleaning services","datos"=>$servicios])?>
    <?php getComponent("gallery",['titulo'=>"Our gallery","subtitulo"=>"","datos"=>$galeria]); ?>
</main>
<?php footerPage($data);?>