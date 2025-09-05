<?php  headerAdmin($data); ?>
<div id="modalItem"></div>
<input type="hidden" ref="intTipoPagina" value="<?=$data['tipo_pagina']?>">
<div class="body flex-grow-1 px-3" id="<?=$data['page_name']?>">
    <ul class="nav nav-pills" id="product-tab" role="tablist">
        <?php if($_SESSION['permitsModule']['w']){?>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="new-tab" data-bs-toggle="tab" data-bs-target="#new" type="button" role="tab" aria-controls="new" aria-selected="true">Send a message</button>
        </li>
        <?php }?>
        <li class="nav-item" role="presentation" @click="getBuscar(1,'recibidos')">
            <button class="nav-link active" id="inbox-tab" data-bs-toggle="tab" data-bs-target="#inbox" type="button" role="tab" aria-controls="inbox" aria-selected="true">
                Mailbox
                <span class="badge bg-danger" v-if="arrNuevos.length > 0">{{arrNuevos.length}}</span>
            </button>
        </li>
        <li class="nav-item" role="presentation" @click="getBuscar(1,'enviados')">
            <button class="nav-link" id="sent-tab" data-bs-toggle="tab" data-bs-target="#sent" type="button" role="tab" aria-controls="sent" aria-selected="false">Sent</button>
        </li>
    </ul>
    
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade" id="new" role="tabpanel" aria-labelledby="new-tab">
            <form id="formEmail" name="formEmail" class="mb-4 mt-4">
                <div class="mb-3">
                    <label for="txtEmail" class="form-label">To: <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="txtEmail" v-model="strCorreo"  required>
                </div>
                <div class="mb-3">
                    <label for="txtEmailCC" class="form-label">CC:</label>
                    <input type="email" class="form-control" id="txtEmailCC" v-model="strCorreoCopia">
                </div>
                <div class="mb-3">
                    <label for="txtSubject" class="form-label">Subject:</label>
                    <input type="text" class="form-control" id="txtSubject" v-model="strAsunto">
                </div>
                <div class="mb-3">
                    <label for="txtMessage" class="form-label">Message: <span class="text-danger">*</span></label>
                    <textarea class="form-control" v-model="strMensaje" rows="5"></textarea>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" @click="setMensaje" ref="btnAdd">Send <i class="fas fa-paper-plane"></i></button>
                </div>
            </form>
        </div>
        <div class="tab-pane show active" id="inbox" role="tabpanel" aria-labelledby="inbox-tab">
            <div class="table-responsive overflow-y no-more-tables" style="max-height:60vh">
                <table class="table align-middle table-hover">
                    <thead>
                        <tr class="text-center">
                            <th>Name</th>
                            <th>Subject</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(data,index) in arrRecibidos" :key="index">
                            <td data-title="Name" class="text-nowrap">{{data.name}}</td>
                            <td data-title="Subject" >{{data.asunto}}</td>
                            <td data-title="Phone" class="text-nowrap">{{data.telefono}}</td>
                            <td data-title="Email" class="text-nowrap">{{data.email}}</td>
                            <td data-title="Fecha" class="text-center">{{data.date}}</td>
                            <td data-title="Estado" class="text-center">
                                <span :class="data.reply != '' ? 'bg-success text-white' : data.status == '1' ? 'bg-warning text-dark' : 'bg-danger text-white'" class="badge ">
                                    {{ data.reply != '' ? "replied" : data.status == '1' ? "seen" : "unread" }}
                                </span>
                            </td>
                            <td data-title="Opciones" class="text-center">
                                <div class="d-flex justify-content-center">
                                    <button class="btn btn-info m-1 text-white" type="button" title="Ver mensaje" v-if="data.edit" @click="getDatos(data.id)" ><i class="fas fa-eye"></i></button>
                                    <button class="btn btn-success m-1"  title="Whatsapp" v-if="data.edit" @click="openBotones('wpp',data.phonecode+data.phone)"><i class="fab fa-whatsapp"></i></button>
                                    <button class="btn btn-danger m-1" type="button" title="Eliminar" v-if="data.delete" @click="delDatos(data.id,'recibidos')" ><i class="fas fa-trash-alt"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="arrRecibidos.length == 0">
                            <td colspan="9" class="text-center fw-bold">There are no data</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <?php getComponent("paginationAdmin",["tipo" =>"recibidos","variable" =>"arrRecibidos","funcion" =>"getBuscar"]);?>
        </div>
        <div class="tab-pane fade" id="sent" role="tabpanel" aria-labelledby="sent-tab">
            <div class="table-responsive overflow-y no-more-tables" style="max-height:60vh">
                <table class="table align-middle table-hover">
                    <thead>
                        <tr class="text-center">
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Date</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(data,index) in arrEnviados" :key="index">
                            <td data-title="Email" class="text-nowrap">{{data.email}}</td>
                            <td data-title="Subject" >{{data.subject}}</td>
                            <td data-title="Date" class="text-center">{{data.date}}</td>
                            <td data-title="Options" class="text-center">
                                <div class="d-flex justify-content-center">
                                    <button class="btn btn-info m-1 text-white" type="button" title="Ver mensaje" v-if="data.edit" @click="getDatos(data.id,2)" ><i class="fas fa-eye"></i></button>
                                    <button class="btn btn-danger m-1" type="button" title="Eliminar" v-if="data.delete" @click="delDatos(data.id,'enviados')" ><i class="fas fa-trash-alt"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="arrEnviados.length == 0">
                            <td colspan="4" class="text-center fw-bold">there are no data</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <?php getComponent("paginationAdmin",["tipo" =>"enviados","variable" =>"arrEnviados","funcion" =>"getBuscar"]);?>
        </div>
    </div>
</div> 
<?php footerAdmin($data)?>        