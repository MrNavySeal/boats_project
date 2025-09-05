<?php 
    headerAdmin($data);
    if($_SESSION['permitsModule']['u']){
        getModal("modalOrderEdit");
    }
    getModal("modalOrderDetail");
    $status='<option value="">All</option>';
    for ($i=0; $i < count(STATUS) ; $i++) { 
        $status .='<option value="'.STATUS[$i].'">'.STATUS[$i].'</option>';
    }
?>
<div class="body flex-grow-1 px-3" id="<?=$data['page_name']?>">
    <div class="mt-3">
        <div class="row">
            <div class="col-md-2">
                <div class="mb-3">
                    <label for="perPage" class="form-label">Per page</label>
                    <select class="form-control" aria-label="Default select example" id="perPage" name="perPage">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                        <option value="1000">1000</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="mb-3">
                    <label for="txtInitialDate" class="form-label">From</label>
                    <input type="date" class="form-control" id="txtInitialDate" name="txtInitialDate">
                </div>
            </div>
            <div class="col-md-2">
                <div class="mb-3">
                    <label for="txtFinalDate" class="form-label">To</label>
                    <input type="date" class="form-control" id="txtFinalDate" name="txtFinalDate">
                </div>
            </div>
            <div class="col-md-3">
                <label for="selectPago" class="form-label">Status</label>
                <select class="form-control" aria-label="Default select example" id="selectPago" name="selectPago">
                    <option value="">All</option>
                    <option value="pendent">Pendent</option>
                    <option value="approved">Approved</option>
                    <option value="canceled">Canceled</option>
                </select>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <label for="txtSearch" class="form-label">Search</label>
                    <input type="text" class="form-control" id="txtSearch" name="txtSearch">
                </div>
            </div>
        </div>
        <div class="table-responsive overflow-y no-more-tables" style="max-height:50vh">
            <table class="table align-middle table-hover">
                <thead>
                    <tr class="text-center">
                        <th>ID</th>
                        <th>Transaction</th>
                        <th>Date</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>ID number</th>
                        <th>Payment</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody id="tableData"></tbody>
            </table>
        </div>
        <div class="no-more-tables">
            <p id="totalRecords" class="text-center m-0 mb-1"><strong>Total: </strong> 0</p>
            <nav aria-label="Page navigation example" class="d-flex justify-content-center w-100">
                <ul class="pagination" id="pagination">
                    <li class="page-item">
                        <a class="page-link text-secondary" href="#" aria-label="Next">
                            <span aria-hidden="true"><i class="fas fa-angle-double-left"></i></span>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link text-secondary" href="#" aria-label="Previous">
                            <span aria-hidden="true"><i class="fas fa-angle-left"></i></span>
                        </a>
                    </li>
                    <li class="page-item"><a class="page-link text-secondary" href="#">1</a></li>
                    <li class="page-item"><a class="page-link text-secondary" href="#">2</a></li>
                    <li class="page-item"><a class="page-link text-secondary" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link text-secondary" href="#" aria-label="Next">
                            <span aria-hidden="true"><i class="fas fa-angle-right"></i></span>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link text-secondary" href="#" aria-label="Next">
                            <span aria-hidden="true"><i class="fas fa-angle-double-right"></i></span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
<?php footerAdmin($data)?>         
