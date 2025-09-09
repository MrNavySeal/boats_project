<app-modal :title="common.productTitle" id="modalViewProduct" v-model="common.showModalViewProduct" size="xl">
    <template #body>
        <app-input label="" type="hidden"  v-model="common.intId"></app-input>
        <ul class="nav nav-pills mt-5 mb-5" id="product-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="generalView-tab" data-bs-toggle="tab" data-bs-target="#generalView" type="button" role="tab" aria-controls="generalView" aria-selected="true">General</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="specificationsView-tab" data-bs-toggle="tab" data-bs-target="#specificationsView" type="button" role="tab" aria-controls="specificationsView" aria-selected="false">Features</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="variantsView-tab" data-bs-toggle="tab" data-bs-target="#variantsView" type="button" role="tab" aria-controls="variantsView" aria-selected="false">Variants</button>
            </li>
        </ul>
        <div class="tab-content mb-3" id="myTabContent">
            <div class="tab-pane show active" id="generalView" role="tabpanel" aria-labelledby="generalView-tab">
                <div class="row">
                    <div class="col-md-6">
                        <div>
                            <div  class="d-flex" style="overflow-x:auto;" id="upload-multiple">
                                <div class="upload-images d-flex">
                                    <div class="upload-image ms-3" v-for="(data,index) in arrImages" :key="index">
                                        <img :src="data.route">
                                    </div>
                                </div>
                            </div>
                            <div>
                                <h5>Information</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <app-input label="Name" :errors="errors.name" type="text" v-model="strName" disabled></app-input>
                                    </div>
                                    <div class="col-md-6">
                                        <app-input label="Reference" type="text" title="SKU code" v-model="strReference" disabled></app-input>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <h5>Description</h5>
                                <app-input label="descripcionCorta" type="text" title="Short description" v-model="strShortDescription" disabled></app-input>
                                <div class="mb-3">
                                    <label for="txtViewDescription" class="form-label">Description </label>
                                    <textarea class="form-control" id="txtViewDescription" name="txtViewDescription" rows="5" disabled></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6">
                                <app-button-input 
                                    title="Categories"
                                    btn="primary" icon="new" 
                                    :value="objCategory.name" 
                                    required="true"
                                    :errors="errors.category"
                                    disabled
                                    >
                                </app-button-input>
                            </div>
                            <div class="col-md-6">
                                <app-button-input 
                                    title="Subcategories"
                                    btn="primary" icon="new" 
                                    :value="objSubcategory.name" 
                                    required="true"
                                    :errors="errors.subcategory"
                                    disabled
                                    >
                                </app-button-input>
                            </div>
                        </div>
                        <!-- <div class="mb-3">
                            <h5>Tipo de artículo</h5>
                            <app-input disabled label="checkProduct" :errors="errors.product_type" @click="intCheckRecipe=false" title="Seleccione si el artículo es un producto" type="switch" v-model="intCheckProduct"></app-input>
                            <app-input disabled label="checkIngredient" :errors="errors.product_type" @click="intCheckRecipe=false" title="Seleccione si el artículo es un insumo" type="switch" v-model="intCheckIngredient"></app-input>
                            <app-input disabled label="checkRecipe" :errors="errors.product_type" @click="intCheckIngredient=false;intCheckProduct=false;" title="Seleccione si el artículo es una fórmula/servicio/combo" type="switch" v-model="intCheckRecipe"></app-input>
                        </div> -->
                        <app-select label="unidadMedida" title="Unit" v-model="intMeasure" disabled>
                            <option v-for="(data,index) in arrMeasures" :key="index" :value="data.id">{{data.name}}</option>
                        </app-select>
                        <div class="mb-3" v-if="!intCheckRecipe">
                            <h5>Inventory</h5>
                            <app-input label="checkInventory" title="Check if this product uses inventory" type="switch" disabled v-model="intCheckStock"></app-input>
                            <div class="row" v-if="intCheckStock">
                                <div class="col-md-6">
                                    <app-input label="stock" :errors="errors.stock" type="text" title="Stock" required="true" disabled v-model="intStock"></app-input>
                                </div>
                                <div class="col-md-6">
                                    <app-input label="minStock" :errors="errors.min_stock" type="text" title="Min stock" disabled v-model="intMinStock"></app-input>
                                </div>
                            </div>
                        </div>
                        <!-- <div>
                            <h5>Impuesto</h5>
                            <app-select label="impuesto" disabled title="Seleccione impuesto" required="true" v-model="intTax">
                                <option value="0">Ninguno</option>
                                <option value="19">IVA 19%</option>
                            </app-select>
                        </div> -->
                        <div>
                            <h5>Prices</h5>
                            <div class="row">
                                <div class="col-md-4" v-if="!intCheckRecipe">
                                    <app-input label="purchasePrice" type="number" :errors="errors.price_purchase" title="Purchase price" required="true" disabled v-model="intPurchasePrice"></app-input>
                                </div>
                                <div :class="intCheckRecipe ? 'col-md-6' : 'col-md-4'">
                                    <app-input label="sellPrice" type="number" :errors="errors.price_sell" title="Sale price" required="true" disabled v-model="intSellPrice"></app-input>
                                </div>
                                <div :class="intCheckRecipe ? 'col-md-6' : 'col-md-4'">
                                    <app-input label="offerPrice" type="number" :errors="errors.price_offer" title="Offer price" required="true" disabled v-model="intOfferPrice"></app-input>
                                </div>
                            </div>
                        </div>
                        <div>
                            <app-select label="Status"  v-model="intStatus" disabled>
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
                            </app-select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="specificationsView" role="tabpanel" aria-labelledby="specificationsView-tab">
                <div v-if="arrSpecsAdded.length > 0">
                    <div class="table-responsive overflow-y no-more-tables" style="max-height:50vh">
                        <table class="table align-middle">
                            <thead>
                                <th>Name</th>
                                <th>Value</th>
                            </thead>
                            <tbody id="tableSpecs">
                                <tr v-for="(data,index) in arrSpecsAdded" :key="index">
                                    <td data-title="Name">{{data.name}}</td>
                                    <td data-title="Value">
                                        <div><input type="text" disabled class="form-control" v-model="data.value"></div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="variantsView" role="tabpanel" aria-labelledby="variantsView-tab">
                <app-input label="checkVariant"   title="Allow it if the product has variants like size, color, etc." type="switch" disabled v-model="intCheckVariant"></app-input>
                <hr>
                <div class="mt-3" v-if="intCheckVariant">
                    <div v-if="arrVariantsAdded.length > 0">
                        <div class="table-responsive overflow-y no-more-tables" style="max-height:50vh">
                            <table class="table align-middle">
                                <thead>
                                    <th>Variant</th>
                                    <th>Options</th>
                                </thead>
                                <tbody >
                                    <tr v-for="(data,i) in arrVariantsAdded" :key="i">
                                        <td data-title="Variant">{{data.name}}</td>
                                        <td data-title="Options">
                                            <div class="d-flex gap-3 flex-wrap align-items-center">
                                                <app-input
                                                    @change="changeVariant()" 
                                                    v-for="(variant,j) in data.options" 
                                                    :label="'checkVariant'+variant.name"  
                                                    :title="variant.name" 
                                                    type="switch"
                                                    v-model="variant.checked"
                                                    disabled>
                                                </app-input>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <hr class="mb-3">
                    <div  v-if="arrCombination.length > 0" class="table-responsive overflow-auto no-more-tables" style="max-height:50vh" id="tableVariantsCombination">
                        <table class="table align-middle">
                            <thead>
                                <th class="text-nowrap">Variant</th>
                                <th class="text-nowrap">Purchase price</th>
                                <th class="text-nowrap">Sale price</th>
                                <th class="text-nowrap">Offer price</th>
                                <th class="text-nowrap d-flex">
                                    <app-input label="checkVariantStock"  title="Stock/Min stock" type="switch" v-model="intCheckStock"></app-input>
                                </th>
                                <th class="text-nowrap">Reference</th>
                                <!-- <th>Mostrar</th> -->
                            </thead>
                            <tbody>
                                <tr v-for="(data,index) in arrCombination" :key="index">
                                    <td data-title="Variant">{{data.name}}</td>
                                    <td data-title="Purchase price"><div><input type="text" class="form-control" v-model="data.price_purchase" ></div></td>
                                    <td data-title="Sale price"><div><input type="text" class="form-control" v-model="data.price_sell" ></div></td>
                                    <td data-title="Offer price"><div><input type="text" class="form-control" v-model="data.price_offer" ></div></td>
                                    <td data-title="Stock/Min stock">
                                        <div class="d-flex">
                                            <input type="number" class="form-control" v-model="data.stock" :disabled = "intCheckStock ? false : true">
                                            <input type="number" class="form-control" v-model="data.min_stock" :disabled = "intCheckStock ? false : true">
                                        </div>
                                    </td>
                                    <td data-title="Reference"><div><input type="text" class="form-control" v-model="data.sku" ></div></td>
                                    <!-- <td data-title="Mostrar"><div><app-input :label="'checkVariant'+data.name" type="switch" v-model="data.status"></app-input></div></td> -->
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="pricesView" role="tabpanel" aria-labelledby="pricesView-tab"></div>
        </div>
    </template>
</app-modal>