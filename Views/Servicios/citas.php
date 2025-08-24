<?php 
    headerAdmin($data);
    getModal("Servicios/modalCitas");
    getModal("modalSearchServices");
    getModal("modalSearchCustomers");
?>
<div class="body flex-grow-1 px-3" id="<?=$data['page_name']?>">
    <div class="mt-3">
        <div class="row">
            <div class="col-md-2">
                <div class="mb-3">
                    <label for="intPorPagina" class="form-label">Per page</label>
                    <select class="form-control" aria-label="Default select example" id="intPorPagina" v-model="intPorPagina" @change="getBuscar(1,'casos')">
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
                    <input type="text" class="form-control" id="strBuscar" v-model="strBuscar" @keyup="getBuscar(1,'casos')">
                </div>
            </div> 
        </div>
        <div class="table-responsive overflow-y no-more-tables" style="max-height:50vh">
            <table class="table align-middle table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Transaction</th>
                        <th>Name</th>
                        <th>ID number</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Appointment</th>
                        <th>Total</th>
                        <th>Payment status</th>
                        <th>Appointment status</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(data,index) in arrData" :key="index">
                        <td data-title="ID" class="text-center">{{data.idorder}}</td>
                        <td data-title="Transaction">{{data.idtransaction}}</td>
                        <td data-title="Name">{{data.firstname+" "+data.lastname}}</td>
                        <td data-title="ID number">{{data.identification}}</td>
                        <td data-title="Phone" class="text-nowrap">{{data.telefono}}</td>
                        <td data-title="Email">{{data.email}}</td>
                        <td data-title="Appointment" class="text-center text-nowrap">{{data.date}}</td>
                        <td data-title="Total" class="text-end text-nowrap">{{formatMoney(data.amount)}}</td>
                        <td data-title="Payment status" class="text-center">
                            <span :class="data.status == 'approved' ? 'bg-success text-white' : data.status == 'pendent' ? 'bg-warning text-black' :'bg-danger text-white'" class="badge">
                                {{ data.status == 'approved' ? "approved" : data.status == 'pendent' ? "pendent" : "canceled" }}
                            </span>
                        </td>
                        <td data-title="Appointment status" class="text-center">
                            <span :class="data.statusorder == 'confirmado' ? 'bg-black text-white' : data.statusorder == 'en proceso' ? 'bg-warning text-black' : data.statusorder == 'finalizado' ? 'bg-success text-white' :'bg-danger text-white'" class="badge">
                                {{ data.statusorder == 'confirmado' ? 'confirmed' : data.statusorder == 'en proceso' ? 'in process' : data.statusorder == 'finalizado' ? 'finished' :'canceled'}}
                            </span>
                        </td>
                        <td data-title="Options">
                            <div class="d-flex justify-content-center">
                                <button class="btn btn-primary text-white m-1" :id="'btnPopover'+data.idorder" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top" data-bs-content="Copiado!" type="button" title="Paypal"  @click="copiar(data,'btnPopover'+data.idorder)" v-if="data.status != 'approved'"><i class="fab fa-paypal"></i></button>
                                <button class="btn btn-info text-white m-1" type="button" title="Correo"  @click="openBotones('correo',data.email)" ><i class="fa fa-envelope"></i></button>
                                <button class="btn btn-success m-1"  title="Whatsapp"  @click="openBotones('wpp',data.phonecode+data.phone)"><i class="fab fa-whatsapp"></i></button>
                                <?php if($_SESSION['permitsModule']['u']){ ?>
                                <button class="btn btn-success m-1" type="button" title="Editar"  @click="getDatos(data.idorder)" ><i class="fas fa-pencil-alt"></i></button>
                                <?php } ?>
                                <?php if($_SESSION['permitsModule']['d']){ ?>
                                <button class="btn btn-danger m-1" type="button" title="Eliminar" @click="delDatos(data.idorder)"  v-if="data.status != 'approved'"><i class="fas fa-trash-alt"></i></button>
                                 <?php } ?>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <?php getComponent("paginationAdmin","casos");?>
</div>
<?php footerAdmin($data)?>         