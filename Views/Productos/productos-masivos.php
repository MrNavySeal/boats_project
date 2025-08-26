<?php 
    headerAdmin($data);
    getModal("Paginacion/modalPaginacionCategorias");
    getModal("Paginacion/modalPaginacionSubcategorias");
?>
<div id="modalItem"></div>
<ul class="nav nav-pills mt-5 mb-5" id="product-tab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab" aria-controls="info" aria-selected="true">Create</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="social-tab" data-bs-toggle="tab" data-bs-target="#social" type="button" role="tab" aria-controls="social" aria-selected="false">Edit</button>
    </li>
</ul>
<div class="tab-content mb-3" id="myTabContent">
    <div class="tab-pane show active" id="info" role="tabpanel" aria-labelledby="info-tab">
        <div class="mb-3">
            <h4>Step 1 - Download the excel</h4>
            <p class="text-secondary">Dowloand the excel template</p>
            <app-button btn="success" title="Download" @click="download()"></app-button>
        </div>
        <div class="mb-3">
            <h4>Step 2 - Complete the information</h4>
            <p class="text-secondary">Complete the information following the instructions.</p>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="mb-3">
                    <h4>Step 3 - Upload excel</h4>
                    <p class="text-secondary">Upload the excel template if you already have finished to fill its information.</p>
                    <div class="d-flex mb-3 align-items-center">
                        <input class="form-control" type="file" accept=".xlsx" @change="setFile">
                        <app-button btn="primary" title="Cargar" @click="uploadFile(1)" :disabled="category.processing" :processing="category.processing"></app-button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="social" role="tabpanel" aria-labelledby="social-tab">
        <div class="mb-3">
            <h4>Step 1 - Select products</h4>
            <p class="text-secondary">Select products per category or everything</p>
        </div>
        <div class="row">
            <div class="col-md-4">
                <app-button-input 
                    title="Categories"
                    :errors="category.errors.category"
                    btn="primary" icon="new" 
                    :value="objCategory.name" 
                    >
                    <template #left>
                        <app-button icon="new" btn="primary" @click="changeCategory()"></app-button>
                    </template>
                    <template #right>
                        <app-button icon="delete" btn="danger" @click="del()"></app-button>
                    </template>
                </app-button-input>
            </div>
            <div class="col-md-4" v-if="objCategory.id != ''">
                <app-button-input 
                    title="Subcategories"
                    :errors="subcategory.errors.category"
                    btn="primary" icon="new" 
                    :value="objSubcategory.name" 
                    >
                        <template #left>
                            <app-button icon="new" btn="primary" @click="changeCategory('subcategory')"></app-button>
                        </template>
                        <template #right>
                            <app-button icon="delete" btn="danger" @click="del('subcategory')">
                        </template>
                    </app-button>
                </app-button-input>
            </div>
        </div>
        <div class="mb-3">
            <h4>Step 2 - Download the excel</h4>
            <p class="text-secondary">Dowloand the excel template</p>
            <app-button btn="success" title="Descargar" @click="download('edit')"></app-button>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="mb-3">
                    <h4>Step 3 - upload the excel</h4>
                    <p class="text-secondary">Upload the excel if you already have finished to edit the products.</p>
                    <div class="d-flex mb-3 align-items-center">
                        <input class="form-control" type="file" accept=".xlsx" @change="setFile">
                        <app-button btn="primary" title="Cargar" @click="uploadFile(2)" :disabled="category.processing" :processing="category.processing"></app-button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php footerAdmin($data)?> 
