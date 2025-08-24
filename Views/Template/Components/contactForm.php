
<?php $company = getCompanyInfo();?>
<section class="container mt-5 mb-5 bg-white">
    <div class="contact-form p-2">
        <div class="row">
            <div class="col-md-5 bg-color-2 rounded">
                <div class="p-4">
                    <h5 class="t-color-4 fw-bold fs-3 mb-4">Contact us</h5>
                    <h2 class="t-color-4 mb-5 fs-1 fw-bold">Feel free to contact with us for any kind of query.</h2>
                    <ul class="social social--white mt-5"> <?=getRedesSociales()?></ul>
                </div>
            </div>
            <div class="col-md-7 rounded">
                <form>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="txtName" class="form-label">Firstname <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="txtName" name="txtName" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="txtLastname" class="form-label">Lastname <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="txtLastname" name="txtLastname" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="txtPhone" class="form-label">Phone <span class="text-danger">*</span></label>
                                <input type="phone" class="form-control" id="txtPhone" name="txtPhone" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="txtEmail" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="txtEmail" name="txtEmail" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="serviceList" class="form-label">Services <span class="text-danger">*</span></label>
                                <select class="form-control" aria-label="Default select example" id="serviceList" name="serviceList" required>
                                    <?php
                                        foreach ($data as $det) {
                                            echo '<option value="'.$det['id'].'">'.$det['name'].'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">Message <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-bg-1" >Send us a message</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
