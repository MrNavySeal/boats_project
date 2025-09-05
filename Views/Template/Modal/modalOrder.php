<?php
    $status="";
    for ($i=0; $i < count(STATUS) ; $i++) { 
        if(STATUS[$i]!="anulado"){
            $status .='<option value="'.$i.'">'.STATUS[$i].'</option>';
        }
    }

?>
<div class="modal fade" tabindex="-1" id="modalPurchase">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Checkout</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div>
                    <label for="" class="form-label">Customer</label>
                    <input class="form-control" type="search" placeholder="Search" aria-label="Search" id="searchItems" name="searchItems">
                </div>
                <div class="position-relative" id="selectItems">
                    <div id="items" class="bg-white position-absolute w-100 border border-primary" style="overflow-y:scroll; max-height:30vh;"></div>
                </div>
                <div id="selectedItem"></div>
                <form id="formSetOrder">
                    <input type="hidden" name="id" id="id" value ="">
                    <div class="row" id="contentPurchase">
                        <div class="col-md-6">
                            <div class="mt-3 mb-3">
                                <label for="" class="form-label">Sale date</label>
                                <input type="date" name="strDate" id="txtDate" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mt-3 mb-3">
                                <label for="" class="form-label">Payment type <span class="text-danger">*</span></label>
                                <select class="form-control" aria-label="Default select example" id="paymentList" name="paymentList" required>
                                    <option value="paypal">Paypal</option>
                                    <option value="cash">Cash</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mt-3 mb-3">
                                <label for="" class="form-label">Notes</label>
                                <textarea rows="3" name="strNote" id="txtNote" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div id="contentQuote" class="d-none">
                        <div class="mt-3 mb-3">
                            <label for="" class="form-label">Fecha de cotización</label>
                            <input type="date" name="strDateQuote" id="strDateQuote" class="form-control">
                        </div>
                        <div class="mt-3 mb-3">
                            <label for="" class="form-label">Notas</label>
                            <textarea rows="3" name="strNoteQuote" id="strNoteQuote" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <div class="d-flex p-2 fw-bold">
                            <p class="me-2">Total: </p>
                            <p id="totalPurchase">$0</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="btnSetPurchase"><i class="fas fa-save"></i> Save</button>
                        <button type="button" class="btn btn-danger text-white" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>