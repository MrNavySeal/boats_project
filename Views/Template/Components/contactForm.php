
<?php 
    $company = getCompanyInfo();
    /* $company['addressfull']=str_replace(" ","+",$company['addressfull']); */
    $titulo = $data['titulo'];
    $subtitulo = $data['subtitulo'];
    $servicios = $data['datos'];
?>
<section class="container mt-5 mb-5 bg-white">
    <div class="contact-form p-2">
        <div class="row">
            <div class="col-md-6 rounded mt-2">
                <div class="p-4">
                    <h5 class="t-color-1 fw-bold fs-3"><?=$titulo?></h5>
                    <p class="t-color-5 mb-2 fw-bold"><?=$subtitulo?></p>
                    <ul class="list-unstyled p-0">
                        <li class="mb-2 d-flex gap-1 align-items-center"><i class="fas fa-map-marker-alt" aria-hidden="true"></i> <?=$company['addressfull']?></li>
                        <li class="mb-2 d-flex gap-1 align-items-center"><i class="fas fa-phone" aria-hidden="true"></i> <?=$company['phone']?></li>
                        <li class="mb-2 d-flex gap-1 align-items-center"><i class="fas fa-envelope" aria-hidden="true"></i> <?=$company['email']?></li>
                    </ul>
                    <!-- <ul class="social social--white mt-5"> <?=getRedesSociales()?></ul> -->
                    <div>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d114077.1275143609!2d-80.12298242990633!3d26.68335322496399!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x88d8d6f618523787%3A0x3ba092c7d7a6471a!2sPalm%20Beach%2C%20Florida%2C%20EE.%20UU.!5e0!3m2!1ses!2sco!4v1757286657598!5m2!1ses!2sco" 
                              style="border:0;" class="w-100" height=200 allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
            <div class="col-md-6 rounded mt-2">
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
