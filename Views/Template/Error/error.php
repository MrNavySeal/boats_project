
<?php
    headerPage($data);
?>
    <main class="container mt-4 mb-4 text-center">
        <div class="d-flex justify-content-center align-items-center p-5 text-center">
            <div>
                <h1 class="fs-1 t-color-2">Error <?=$data['error']['code']?></h1>
                <a href="<?=base_url()?>/shop/" class="btn btn-secondary me-2">Go shopping</a>
                <a href="<?=base_url()?>/shop/services/" class="btn btn-secondary">Our services</a>
            </div>
        </div>
    </main>
<?php
    footerPage($data);
?>