<?php
    headerPage($data);
    $total = 0;

    $arrProducts = $_SESSION['arrCart'];
    $arrShipping = $data['shipping'];
    $total = 0;
    $cupon = 0;
    $subtotal = 0;
    $envio = 0;
    $urlCupon="";
    $situ = isset($_GET['situ']) ? "?situ=".$_GET['situ'] : "";

    for ($i=0; $i < count($arrProducts) ; $i++) { 
        if($arrProducts[$i]['topic'] == 2){
            if($arrProducts[$i]['producttype'] == 2){
                $subtotal+=$arrProducts[$i]['qty']*$arrProducts[$i]['variant']['price'];
            }else{
                $subtotal+=$arrProducts[$i]['qty']*$arrProducts[$i]['price'];
            }
        }else{
            $subtotal += $arrProducts[$i]['price']*$arrProducts[$i]['qty']; 
        }
    }

    if(isset($data['cupon']) && !$data['cupon']['check']){
        $cupon = $subtotal-($subtotal*($data['cupon']['discount']/100));
        $total = $cupon;
    }else{
        $total = $subtotal;
    }
    if($arrShipping['id'] < 3 || $arrShipping['id'] == 4){
        $envio = $arrShipping['value'];
        $total+=$envio;
    }else if($arrShipping['id'] == 3 && isset($_SESSION['shippingcity'])){
        $envio = $_SESSION['shippingcity'];
        $total+= $envio;
    }
?>
<script src="https://www.paypal.com/sdk/js?client-id=<?=$data['credentials']['client']?>&currency=USD"></script>
<main id="<?=$data['page_name']?>">
    <div class="container bg-white">
        <nav class="mt-2 mb-2 p-2" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a class="text-decoration-none" href="<?=base_url()?>">Home</a></li>
                <li class="breadcrumb-item"><a class="text-decoration-none" href="<?=base_url()?>/cart/">Cart</a></li>
                <li class="breadcrumb-item active" aria-current="page">Checkout</li>
            </ol>
        </nav>
        <div class="row">
           <div class="col-lg-7 order-lg-1 order-md-5 order-sm-5">
                <form id="formOrder" name="formOrder" class="p-4">
                    <h2>Checkout</h2>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="txtNameOrder" class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="txtNameOrder" name="txtNameOrder" value="<?=$_SESSION['userData']['firstname']?>" required="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="txtLastNameOrder" class="form-label">Lastname <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="txtLastNameOrder" name="txtLastNameOrder" value="<?=$_SESSION['userData']['lastname']?>" required="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="txtDocument" class="form-label">ID number <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="txtDocument" name="txtDocument" value="<?=$_SESSION['userData']['identification']?>" placeholder="12345678" required="">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="txtEmailOrder" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="txtEmailOrder" name="txtEmailOrder" value="<?=$_SESSION['userData']['email']?>" required="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="txtPhoneOrder" class="form-label">Phone <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="txtPhoneOrder" name="txtPhoneOrder" required placeholder="312 345 6789">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="txtAddressOrder" class="form-label">Address<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="txtAddressOrder" name="txtAddressOrder" required="" placeholder="Carrera, calle, barrio...">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="listCountry" class="form-label">Country <span class="text-danger">*</span></label>
                                <select class="form-select" id="listCountry" name="listCountry" aria-label="Default select example" required="">
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="listState" class="form-label">State <span class="text-danger">*</span></label>
                                <select class="form-select" id="listState" name="listState" aria-label="Default select example" required="">
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="listCity" class="form-label">City <span class="text-danger">*</span></label>
                                <select class="form-select" id="listCity" name="listCity" aria-label="Default select example" required="">
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="txtPostCodeOrder" class="form-label"> ZIP code</label>
                                <input type="text" class="form-control" id="txtPostCodeOrder" name="txtPostCodeOrder" >
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="txtNote" class="form-label">Notes</label>
                        <textarea class="form-control" id="txtNote" name="txtNote" rows="5"></textarea>
                    </div>
                </form>
            </div>
            <div class="col-lg-5 order-lg-5 order-md-5 order-sm-1 mb-4">
                <div class="p-4 mb-4">
                    <h2>Resume</h2>
                    <?php 
                        for ($i=0; $i < count($arrProducts) ; $i++) { 
                            $price =0;
                            if($arrProducts[$i]['topic'] == 2 && $arrProducts[$i]['producttype'] == 2){

                                $price = $arrProducts[$i]['variant']['price']*$arrProducts[$i]['qty'];
                            }else{
                                $price = $arrProducts[$i]['price']*$arrProducts[$i]['qty'];
                            }
                    ?>
                    <div class="d-flex justify-content-between">
                        <p><?=$arrProducts[$i]['name']." x ".$arrProducts[$i]['qty']?></p>
                        <p><?=formatNum($price,false)?></p>
                    </div>
                    <?php }?>
                    <div class="d-flex justify-content-between mb-3">
                        <p class="m-0 fw-bold">Subtotal:</p>
                        <p class="m-0" id="subtotal"><?=formatNum($subtotal)?></p>
                    </div>
                    <div class="d-flex justify-content-between mb-3 position-relative af-b-line">
                        <p class="m-0 fw-bold">Shippment <?= $arrShipping['id'] == 4 ? "cash on delivery": ""?>:</p>
                        <p class="m-0 fw-bold"><?=formatNum($envio)?></p>
                    </div>
                    <div class="d-flex justify-content-between mb-3 position-relative af-b-line">
                        <p class="m-0 fw-bold fs-5">Total</p>
                        <p class="m-0 fw-bold fs-5" id="totalResume"><?=formatNum($total)?></p>
                    </div>
                    <div id="paypal-button-container"></div>
                    <!-- <button type="button" class="mb-3 w-100 btn btn-bg-1" id="btnOrder">Pagar</button> -->
                </div>
            </div>
        </div>
    </div>
</main>
<?php  footerPage($data); ?>