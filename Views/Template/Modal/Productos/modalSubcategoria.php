<app-modal :title="common.subcategoryTitle" id="modalSubcategory" v-model="common.showModalSubcategory">
    <template #body>
        <app-input label="" type="hidden"  v-model="common.intId"></app-input>
        <div class="row">
            <div class="col-md-12">
                <app-input label="Name" type="text" v-model="common.strName" :errors="common.errors.name"></app-input>
            </div>
            <div class="col-md-12">
                <app-button-input title="Category" :errors="common.errors.category"
                btn="primary" icon="new" 
                :value="objCategory.name" 
                >
                    <template #left>
                        <app-button icon="new" btn="primary" @click="category.modalType='category';category.showModalPaginationCategory=true;search();"></app-button>
                    </template>
                </app-button-input>
            </div>
            <div class="col-md-12">
                <app-select label="Status"  v-model="intStatus">
                    <option value="1">Active</option>
                    <option value="2">Inactive</option>
                </app-select>
            </div>
        </div>
    </template>
    <template #footer>
        <app-button icon="save" @click="save()" btn="primary" title="Save" :disabled="common.processing" :processing="common.processing"></app-button>
    </template>
</app-modal>