<div class="modal fade" id="modalCase">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">{{strTituloModal}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="getBuscar(1,'casos')"></button>
            </div>
            <div class="modal-body">
                <form id="formItem" name="formItem" class="mb-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="" class="form-label">Set service <span class="text-danger">*</span></label>
                                <div class="d-flex">
                                    <button type="button" @click="showModal('servicios')" class="btn btn-primary"><i class="fas fa-plus"></i></button>
                                    <input type="text" class="form-control"  :value="objServicio.name" required disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="" class="form-label">Set customer <span class="text-danger">*</span></label>
                                <div class="d-flex">
                                    <button :disabled="strEstadoPedido =='approved' && intId > 0" type="button" @click="showModal('clientes')" class="btn btn-primary"><i class="fas fa-plus"></i></button>
                                    <input type="text" class="form-control"  :value="objCliente.firstname+' '+objCliente.lastname" required disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="" class="form-label">Set date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" v-model="strFecha">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="" class="form-label">Set time <span class="text-danger">*</span></label>
                                <select class="form-control" aria-label="Default select example" v-model="strHora" required>
                                    <option v-for="(data,index) in computedHorario" :key="index" :value="data.value" >{{data.value}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="" class="form-label">Total <span class="text-danger">*</span></label>
                            <input  type="text" class="form-control text-end" :value="valorBase" aria-describedby="basic-addon1" @keyup="setBase($event)">
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="strEstadoPedido" class="form-label">Payment status <span class="text-danger">*</span></label>
                                <select class="form-control" aria-label="Default select example" id="strEstadoPedido" v-model="strEstadoPedido" name="strEstadoPedido" required>
                                    <option value="approved">Approved</option>
                                    <option value="pendent">Pendent</option>
                                    <option value="canceled">Canceled</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" v-if="intId > 0">
                            <div class="mb-3">
                                <label for="strEstado" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-control" aria-label="Default select example" id="strEstado" v-model="strEstado" name="strEstado" required>
                                    <option v-for="(data,index) in arrEstados" :key="index" :value="data" >{{data}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="setDatos()" class="btn btn-primary" ref="btnAdd">Save <i class="fas fa-save"></i></button>
                        <button type="button" class="btn btn-secondary text-white" @click="getBuscar(1,'casos')" data-bs-dismiss="modal">close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>