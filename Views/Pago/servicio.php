<?php
    headerPage($data);
    $arrOrden = $data['data'];
    $arrCliente = $arrOrden['cliente'];
    $arrServicio = $arrOrden['servicio'];
    $strLlave = getCredentials()['client'];
?>
<script src="https://www.paypal.com/sdk/js?client-id=<?=$strLlave?>&currency=USD"></script>
<input type="hidden" value = "<?=$data['id_encrypt']?>" id="idOrder">
<main class="container bg-white">
    <div class="row">
        <div class="col-md-8 mb-4">
            <h2 class="mt-5 mb-4">Checkout</h2>
            <div class="table-responsive">
                <table class="table">
                    <tbody>
                        <tr>
                            <td class="w-25  fw-bold">Firstname</td>
                            <td><?=$arrCliente['firstname']?></td>
                        </tr>
                        <tr>
                            <td class="w-25  fw-bold">Lastname</td>
                            <td><?=$arrCliente['lastname']?></td>
                        </tr>
                        <tr>
                            <td class="w-25  fw-bold">ID number</td>
                            <td><?=$arrCliente['identification']?></td>
                        </tr>
                        <tr>
                            <td class="w-25  fw-bold">Email</td>
                            <td><?=$arrCliente['email']?></td>
                        </tr>
                        <tr>
                            <td class="w-25  fw-bold">Phone</td>
                            <td><?=$arrCliente['telefono']?></td>
                        </tr>
                        <tr>
                            <td class="w-25  fw-bold">Address</td>
                            <td><?=$arrCliente['pais']."/".$arrCliente['departamento']."/".$arrCliente['ciudad']."/".$arrCliente['address'];?></td>
                        </tr>
                        <tr>
                            <td class="w-25  fw-bold">Scheduled date</td>
                            <td><?=$arrOrden['date']. " ".$arrOrden['time'] ?></td>
                        </tr>
                        <tr>
                            <td class="w-25  fw-bold">Description</td>
                            <td><?=$arrServicio['servicio']?></td>
                        </tr>
                        <tr>
                            <td class="w-25  fw-bold">Total</td>
                            <td><?=formatNum($arrOrden['total'])?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <h2 class="mb-4">Payment methods</h2>
            <div id="paypal-button-container"></div>
        </div>
    </div>
</main>
<?php footerPage($data); ?>