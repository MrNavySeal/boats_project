
<?php 
    $company = getCompanyInfo();
    $titulo = $data['titulo'];
    $subtitulo = $data['subtitulo'];
    $servicios = $data['datos'];
?>
<section class="container mt-5 mb-5 bg-white">
    <div class="contact-form p-2">
        <div class="row">
            <div class="col-md-5 bg-color-2 rounded mt-2">
                <div class="p-4">
                    <h5 class="t-color-4 fw-bold fs-3 mb-4"><?=$titulo?></h5>
                    <h2 class="t-color-4 mb-5 fs-1 fw-bold"><?=$subtitulo?></h2>
                    <ul class="social social--white mt-5"> <?=getRedesSociales()?></ul>
                </div>
            </div>
            <div class="col-md-7 rounded mt-2">
                <form id="formContact">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="txtContactName" class="form-label">Firstname <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="txtContactName" name="txtContactName" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="txtContactlastname" class="form-label">Lastname <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="txtContactlastname" name="txtContactlastname" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="txtContactPhone" class="form-label">Phone <span class="text-danger">*</span></label>
                                <input type="phone" class="form-control" id="txtContactPhone" name="txtContactPhone" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="txtContactEmail" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="txtContactEmail" name="txtContactEmail" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="serviceList" class="form-label">Services <span class="text-danger">*</span></label>
                                <select class="form-control" aria-label="Default select example" id="serviceList" name="serviceList" required>
                                    <?php
                                        foreach ($servicios as $det) {
                                            echo '<option value="'.$det['id'].'">'.$det['name'].'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="txtContactMessage" class="form-label">Message <span class="text-danger">*</span></label>
                                <textarea class="form-control" name="txtContactMessage" id="txtContactMessage" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="alert alert-danger mt-3 d-none" id="alertContact" role="alert"></div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-bg-1" id="btnMessage" >Send us a message</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
