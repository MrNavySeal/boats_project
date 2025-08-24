<?php
    headerPage($data);
    $social = getSocialMedia();
?>
<main>
    <?php getComponent("pageCover",$data); ?>
    <?php getComponent("AboutSection"); ?>
    <?php getComponent("whyUs"); ?>
</main>
<?php footerPage($data);?>