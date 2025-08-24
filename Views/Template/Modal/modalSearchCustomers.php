<div class="modal fade" id="modalSearchCustomers">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Search customers</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label for="intPorPagina" class="form-label">Per page</label>
                            <select class="form-control" aria-label="Default select example" id="intPorPagina" v-model="intPorPagina" @change="getBuscar(1,'clientes')">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="1000">1000</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="mb-3">
                            <label for="strBuscar" class="form-label">Search</label>
                            <input type="text" class="form-control" id="strBuscar" v-model="strBuscar" @keyup="getBuscar(1,'clientes')">
                        </div>
                    </div> 
                </div>
                <div class="table-responsive overflow-y no-more-tables" style="max-height:50vh">
                    <table class="table align-middle table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Picture</th>
                                <th>Name</th>
                                <th>ID number</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(data,index) in arrData" :key="index">
                                <td data-title="ID" class="text-center">{{data.id}}</td>
                                <td data-title="Picture">
                                    <img :src="data.url" :alt="data.name" class="img-thumbnail" style="width: 50px; height: 50px;">
                                </td>
                                <td data-title="Name">{{data.firstname+" "+data.lastname}}</td>
                                <td data-title="ID number">{{data.identification}}</td>
                                <td data-title="Email">{{data.email}}</td>
                                <td data-title="Phone" class="text-nowrap">{{data.telefono}}</td>
                                <td data-title="Options">
                                    <div class="d-flex justify-content-center">
                                        <button type="button" @click="setItem(data,'clientes')" class="btn btn-primary text-nowrap"><i class="fas fa-plus"></i></button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <?php getComponent("paginationAdmin","clientes");?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>