<app-modal :title="common.modulesTitle" id="modalModules" v-model="common.showModalModule">
    <template #body>
        <app-input label="" type="hidden"  v-model="common.intId"></app-input>
        <div class="mb-3 uploadImg">
            <img :src="strImgUrl">
            <label for="strImage"><a class="btn btn-info text-white"><i class="fas fa-camera"></i></a></label>
            <input class="d-none" type="file" id="strImage" @change="uploadImagen"  accept="image/*"> 
        </div>
        <div class="row">
            <div class="col-md-6">
                <app-input label="Name" type="text" v-model="common.strName" required="true"></app-input>
            </div>
            <div class="col-md-6">
                <app-select label="Status"  v-model="intStatus">
                    <option value="1">Active</option>
                    <option value="2">Inactive</option>
                </app-select>
            </div>
        </div>
        <app-input label="isVisible" title="Allow it if this category is visible on your e-commerce" type="switch" v-model="intVisible"></app-input>
        <app-textarea label="Description" v-model="strDescription" rows="5"></app-textarea>
    </template>
    <template #footer>
        <app-button icon="save" @click="save()" btn="primary" title="Save" :disabled="common.processing" :processing="common.processing"></app-button>
    </template>
</app-modal>