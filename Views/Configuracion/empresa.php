<?php 
    headerAdmin($data);
    $countries="";
    $states="";
    $cities="";
    $currencies ="";

    for ($i=0; $i < count($data['currencies']) ; $i++) { 
        if($data['company']['currency']['id'] == $data['currencies'][$i]['id']){
            $currencies.='<option value="'.$data['currencies'][$i]['id'].'" selected>'.$data['currencies'][$i]['code'].' - '.$data['currencies'][$i]['symbol'].'</option>';
        }else{
            $currencies.='<option value="'.$data['countries'][$i]['id'].'">'.$data['currencies'][$i]['code'].' - '.$data['currencies'][$i]['symbol'].'</option>';
        }
    }
    for ($i=0; $i < count($data['countries']) ; $i++) { 
        if($data['company']['country'] == $data['countries'][$i]['id']){
            $countries.='<option value="'.$data['countries'][$i]['id'].'" selected>'.$data['countries'][$i]['name'].'</option>';
        }else{
            $countries.='<option value="'.$data['countries'][$i]['id'].'">'.$data['countries'][$i]['name'].'</option>';
        }
    }
    for ($i=0; $i < count($data['states']) ; $i++) { 
        if($data['company']['state'] == $data['states'][$i]['id']){
            $states.='<option value="'.$data['states'][$i]['id'].'" selected>'.$data['states'][$i]['name'].'</option>';
        }else{
            $states.='<option value="'.$data['states'][$i]['id'].'">'.$data['states'][$i]['name'].'</option>';
        }
    }
    for ($i=0; $i < count($data['cities']) ; $i++) { 
        if($data['company']['city'] == $data['cities'][$i]['id']){
            $cities.='<option value="'.$data['cities'][$i]['id'].'" selected>'.$data['cities'][$i]['name'].'</option>';
        }else{
            $cities.='<option value="'.$data['cities'][$i]['id'].'">'.$data['cities'][$i]['name'].'</option>';
        }
    }
?>
<div id="modalItem"></div>
<div class="body flex-grow-1 px-3" id="<?=$data['page_name']?>">
    <ul class="nav nav-pills" id="product-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab" aria-controls="info" aria-selected="true">My company</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="social-tab" data-bs-toggle="tab" data-bs-target="#social" type="button" role="tab" aria-controls="social" aria-selected="false">Social media</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="schedule-tab" data-bs-toggle="tab" data-bs-target="#schedule" type="button" role="tab" aria-controls="schedule" aria-selected="false">My schedule</button>
        </li>
        <?php if($_SESSION['idUser'] == 1){?>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="payment-tab" data-bs-toggle="tab" data-bs-target="#payment" type="button" role="tab" aria-controls="payment" aria-selected="true">Payment</button>
        </li>
        <?php }?>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane show active" id="info" role="tabpanel" aria-labelledby="info-tab">
            <form id="formCompany" class="mb-4">
                <div class="mb-3 uploadImg">
                    <img src="<?=media()."/images/uploads/".$data['company']['logo']?>">
                    <label for="txtImg"><a class="btn btn-info text-white"><i class="fas fa-camera"></i></a></label>
                    <input class="d-none" type="file" id="txtImg" name="txtImg" accept="image/*"> 
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="txtName" class="form-label">Company name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="txtName" name="txtName" value="<?=$data['company']['name']?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="txtNit" class="form-label">ID Number <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="txtNit" name="txtNit" value="<?=$data['company']['nit']?>" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="txtEmail" class="form-label">Company email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="txtCompanyEmail" name="txtCompanyEmail" value="<?=$data['company']['email']?>" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="txtEmail" class="form-label">Secondary email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="txtEmail" name="txtEmail" value="<?=$data['company']['secondary_email']?>" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="txtPassword" class="form-label">Company email password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="txtPassword" name="txtPassword" required value="<?=$data['company']['password']?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="countryList" class="form-label">Country <span class="text-danger">*</span></label>
                            <select class="form-control" aria-label="Default select example" id="countryList" name="countryList" required><?=$countries?></select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="stateList" class="form-label">State <span class="text-danger">*</span></label>
                            <select class="form-control" aria-label="Default select example" id="stateList" name="stateList" required><?=$states?></select>
                            
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="cityList" class="form-label">City <span class="text-danger">*</span></label>
                            <select class="form-control" aria-label="Default select example" id="cityList" name="cityList" required><?=$cities?></select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <div class="mb-3">
                            <label for="txtPhone" class="form-label">Phone <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="txtPhone" name="txtPhone" value="<?=$data['company']['phone']?>" required>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="mb-3">
                            <label for="txtPhoneS" class="form-label">Secondary phone <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="txtPhoneS" name="txtPhoneS" value="<?=$data['company']['phones']?>" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="txtAddress" class="form-label">Address <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="txtAddress" name="txtAddress" value="<?=$data['company']['address']?>" required>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="txtKeywords" class="form-label">Keywords</label>
                    <input type="text" class="form-control" id="txtKeywords" name="txtKeywords" placeholder="ropa,zapatos" value="<?=$data['company']['keywords']?>"></input>
                </div>
                <div class="mb-3">
                    <label for="txtDescription" class="form-label">Description</label>
                    <textarea class="form-control" id="txtDescription" name="txtDescription" rows="5" placeholder="Descripción del negocio"><?=$data['company']['description']?></textarea>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="btnCompany"> Save</button>
                </div>
            </form>
        </div>
        <div class="tab-pane fade" id="social" role="tabpanel" aria-labelledby="social-tab">
            <form id="formSocial" class="mt-3">
                <h2 class="mb-5">Social media</h2>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3 d-flex">
                            <div class="d-flex justify-content-center bg-primary align-items-center text-white fs-5" style="width:40px; height:40px;"><i class="fab fa-facebook-f"></i></div>
                            <input type="text" class="form-control" id="txtFacebook" name="txtFacebook" placeholder="www.facebook.com" value ="<?=$data['social']['facebook']?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3 d-flex">
                            <div class="d-flex justify-content-center bg-primary align-items-center text-white fs-5" style="width:40px; height:40px;"><i class="fab fa-instagram"></i></div>
                            <input type="text" class="form-control" id="txtInstagram" name="txtInstagram" placeholder="www.instagram.com" value ="<?=$data['social']['instagram']?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3 d-flex">
                            <div class="d-flex justify-content-center bg-primary align-items-center text-white fs-5" style="width:40px; height:40px;"><i class="fab fa-twitter"></i></div>
                            <input type="text" class="form-control" id="txtTwitter" name="txtTwitter" placeholder="www.twitter.com" value ="<?=$data['social']['twitter']?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3 d-flex">
                            <div class="d-flex justify-content-center bg-primary align-items-center text-white fs-5" style="width:40px; height:40px;"><i class="fab fa-linkedin-in"></i></div>
                            <input type="text" class="form-control" id="txtLinkedin" name="txtLinkedin" placeholder="www.linkedin.com" value ="<?=$data['social']['linkedin']?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3 d-flex">
                            <div class="d-flex justify-content-center bg-primary align-items-center text-white fs-5" style="width:40px; height:40px;"><i class="fab fa-youtube"></i></div>
                            <input type="text" class="form-control" id="txtYoutube" name="txtYoutube" placeholder="www.youtube.com" value ="<?=$data['social']['youtube']?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3 d-flex">
                            <div class="d-flex justify-content-center bg-primary align-items-center text-white fs-5" style="width:40px; height:40px;"><i class="fab fa-whatsapp"></i></div>
                            <input type="text" class="form-control" id="txtWhatsapp" name="txtWhatsapp" placeholder="+<?=$data['company']['phonecode'].$data['company']['phone']?>" value ="<?=$data['social']['whatsapp']?>">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="btnSocial"> Save</button>
                </div>
            </form>
        </div>
        <div class="tab-pane fade" id="schedule" role="tabpanel" aria-labelledby="schedule-tab">
            <div class="overflow-y">
                <div class="row">
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label for="countryList" class="form-label">Type</label>
                            <select class="form-control" aria-label="Default select example" id="typeSchedule">
                                <option value="1" selected>Monday-Friday</option>
                                <option value="2">Saturday</option>
                                <option value="3">Sunday</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3 ">
                            <label for="txtName" class="form-label">From </label>
                            <input type="time" class="form-control" id="timeFrom">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label for="txtName" class="form-label">To </label>
                            <input type="time" class="form-control" id="timeTo">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3 ">
                            <label for="txtName" class="form-label">Break time from </label>
                            <input type="time" class="form-control" id="breakFrom">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label for="txtName" class="form-label">Break time to </label>
                            <input type="time" class="form-control" id="breakTo">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label for="txtName" class="form-label">Interval </label>
                            <div class="d-flex">
                                <input type="number" class="form-control" id="interval">
                                <button type="button" class="btn btn-primary" onclick="genSchedule()">Generate</button>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <div class="fw-bold">Monday to friday</div>
                        <div id="scheduleMonday"></div>
                    </div>
                    <div class="col-md-4">
                        <div class="fw-bold">Saturday</div>
                        <div id="scheduleSaturday"></div>
                    </div>
                    <div class="col-md-4">
                        <div class="fw-bold">Sunday</div>
                        <div id="scheduleSunday"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="btnSchedule"> Save</button>
            </div>
        </div>
        <?php if($_SESSION['idUser'] == 1){?>
        <div class="tab-pane fade" id="payment" role="tabpanel" aria-labelledby="payment-tab">
            <div class="d-flex justify-content-between align-items-center flex-wrap mt-3">
                <img src="<?=media()?>/images/uploads/mercadopago.jpg" style="width=100px;height:100px;" alt="">
            </div>
            <form id="formPayment">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="txtName" class="form-label">PUBLIC KEY <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="txtClient" name="txtClient" value="<?=$data['paypal']['client']?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="txtName" class="form-label">TOKEN <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="txtSecret" name="txtSecret" value="<?=$data['paypal']['secret']?>" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="btnPayment"> Guardar</button>
                </div>
            </form>
        </div>
        <?php }?>
    </div>
</div>
<?php footerAdmin($data)?>        