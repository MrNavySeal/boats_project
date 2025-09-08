<app-modal :title="common.modulesTitle" id="modalModules" v-model="common.showModalModule" size="lg">
    <template #body>
        <app-input label="" type="hidden"  v-model="common.intId"></app-input>
        <div class="mb-3 uploadImg">
            <img :src="strImgUrl">
            <label for="strImagen"><a class="btn btn-info text-white"><i class="fas fa-camera"></i></a></label>
            <input class="d-none" type="file" id="strImagen" @change="uploadImagen"  accept="image/*"> 
        </div>
        <div class="row">
            <div class="col-md-6">
                <app-input label="Name" type="text" v-model="strNombre" required="true"></app-input>
            </div>
            <div class="col-md-6">
                <app-input label="Lastname" type="text" v-model="strApellido"></app-input>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <app-input label="Id number" type="text" v-model="strDocumento"></app-input>
            </div>
            <div class="col-md-6">
                <app-input label="Email" type="email" v-model="strCorreo"></app-input>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <app-select label="Country"  v-model="intPais" @change="setFiltro('paises')">
                    <option v-for="(data,index) in arrPaises" :value="data.id">{{data.name}}</option>
                </app-select>
            </div>
            <div class="col-md-4">
                <app-select label="State"  v-model="intDepartamento" @change="setFiltro('departamentos')">
                    <option v-for="(data,index) in arrDepartamentos" :value="data.id">{{data.name}}</option>
                </app-select>
            </div>
            <div class="col-md-4">
                <app-select label="City"  v-model="intCiudad">
                    <option v-for="(data,index) in arrCiudades" :value="data.id">{{data.name}}</option>
                </app-select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <app-input label="Phone" type="phone" v-model="strTelefono" required="true"></app-input>
            </div>
            <div class="col-md-6">
                <app-input label="Address" type="text" v-model="strDireccion"></app-input>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <app-select label="Role"  v-model="intRol" required="true">
                    <option v-for="(data,index) in arrRoles" :value="data.idrole">{{data.name}}</option>
                </app-select>
            </div>
            <div class="col-md-4">
                <app-select label="Status"  v-model="intEstado">
                    <option value="1">Active</option>
                    <option value="2">Inactive</option>
                </app-select>
            </div>
            <div class="col-md-4">
                <app-input label="Password" type="password" v-model="strContrasena"></app-input>
            </div>
        </div>
    </template>
    <template #footer>
        <app-button icon="save" @click="save()" btn="primary" title="Save" :disabled="common.processing" :processing="common.processing"></app-button>
    </template>
</app-modal>