<?php
    headerPage($data);
    $galeria = $data['gallery'];
    $servicios = $data['servicios'];
    $about = $data['about'];
?>
<main>
    <div class="container p-2 mt-4 mb-5">
        <nav class="mt-2 mb-2" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a class="text-decoration-none" href="<?=base_url()?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">About us</li>
            </ol>
        </nav>
        <?php getComponent("AboutSection",$about); ?>
    </div>
    <?php getComponent("serviceSection",['titulo'=>"Our services","subtitulo"=>"Full suite of underwater cleaning services","datos"=>$servicios])?>
    <?php getComponent("gallery",['titulo'=>"Our gallery","subtitulo"=>"","datos"=>$galeria]); ?>
</main>
<?php footerPage($data);?>