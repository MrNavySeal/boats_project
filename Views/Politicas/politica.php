<?php
    headerPage($data);
?>
<main >
    <div class="section-about container mt-5 mb-5 bg-white p-4">
        <div><?=$data['page']['description']?></div>
    </div>
</main>
<?php footerPage($data);?>