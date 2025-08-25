<?php
    headerPage($data);
    $galeria = $data['gallery'];
?>
    <div id="modalItem"></div>
    <div class="container bg-white rounded p-2 mt-4 mb-5">
        <main id="product">
            <div class=" mt-4 mb-4">
                <nav class="mt-2 mb-2" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a class="text-decoration-none" href="<?=base_url()?>">Home</a></li>
                      <li class="breadcrumb-item">Gallery</li>
                    </ol>
                </nav>
                <div class="row">
                    <?php
                        foreach ($galeria as $det) {
                            echo '<div class="col-md-3">';
                            getComponent("cardGallery",$det);
                            echo "</div>";
                        }
                    ?>
                </div>
            </div>
        </main>
    </div>
<?php
    footerPage($data);
?>