<?php 
    headerAdmin($data);
    getModal("Productos/modalProducto");
    getModal("Productos/modalProductoVer");
    getModal("Paginacion/modalPaginacionCategorias");
    getModal("Paginacion/modalPaginacionSubcategorias");
?>
<div class="row">
    <div class="col-md-4">
        <app-select label="Per page"  @change="search()" v-model="common.intPerPage">
            <option value="10" selected>10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
            <option value="1000">1000</option>
        </app-select>
    </div>
    <div class="col-md-8">
        <app-input label="Search" @input="subcategory.modalType='';category.modalType='';search();" v-model="common.strSearch"></app-input>
    </div>
</div>
<div class="table-responsive overflow-y no-more-tables" style="max-height:50vh">
    <table class="table align-middle table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Picture</th>
                <th>Name</th>
                <th>Reference</th>
                <th>Category</th>
                <th>Subcategory</th>
                <th class="text-nowrap">Purchase price</th>
                <th class="text-nowrap">Sale price</th>
                <th class="text-nowrap">Offer price</th>
                <th>Stock</th>
                <th>Date</th>
                <th>Status</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(data,index) in common.arrData" :key="index">
                <td data-title="ID">{{data.idproduct}}</td>
                <td data-title="Picture">
                    <img :src="data.image" :alt="data.name" class="img-thumbnail" style="width: 50px; height: 50px;">
                </td>
                <td data-title="Name">{{data.name}}</td>
                <td data-title="Reference">{{data.reference}}</td>
                <td data-title="Category">{{data.category}}</td>
                <td data-title="Subcategory">{{data.subcategory}}</td>
                <td data-title="Purchase price" class="text-center">{{data.product_type == 1 ? "From" : ""}} {{data.price_purchase}}</td>
                <td data-title="Sale price" class="text-end">{{data.product_type == 1 ? "From" : ""}} {{data.price_sell}}</td>
                <td data-title="Offer price" class="text-end">{{data.product_type == 1 ? "From" : ""}} {{data.price_discount}}</td>
                <td data-title="Stock" class="text-center">{{data.is_stock ? data.stock : "N/A"}}</td>
                <td data-title="Date" class="text-center">{{data.date}}</td>
                <td data-title="Status" class="text-center">
                    <span :class="data.status == '1' ? 'bg-success' : 'bg-danger'" class="badge text-white">
                        {{ data.status == '1' ? "Active" : "Inactive" }}
                    </span>
                </td>
                <td data-title="Options">
                    <div class="d-flex gap-2">
                        <app-button  v-if="(data.is_product || data.is_combo) && data.visible_category"  icon="globe" btn="primary" @click="view(data)"></app-button>
                        <?php if($_SESSION['permitsModule']['r']){ ?>
                        <app-button  icon="watch" btn="info" @click="edit(data,'view')"></app-button>
                        <?php } ?>
                        <?php if($_SESSION['permitsModule']['u']){ ?>
                        <app-button  icon="edit" btn="success" @click="edit(data,'edit')"></app-button>
                        <?php } ?>
                        <?php if($_SESSION['permitsModule']['d']){ ?>
                        <app-button  icon="delete" btn="danger" @click="del(data)"></app-button>
                        <?php } ?>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<app-pagination :common="common" @search="search"></app-pagination>
<?php footerAdmin($data)?>  