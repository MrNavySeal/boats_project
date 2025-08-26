<?php 
    headerAdmin($data);
    getModal("Sistema/modalRol"); 
    getModal("Sistema/modalPermisos"); 
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
        <app-input label="Buscar" @input="search()" v-model="common.strSearch"></app-input>
    </div>
</div>
<div class="table-responsive overflow-y no-more-tables" style="max-height:50vh">
    <table class="table align-middle table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(data,index) in common.arrData" :key="index">
                <td data-title="ID">{{data.id}}</td>
                <td data-title="Name">{{data.name}}</td>
                <td data-title="Options">
                    <div class="d-flex gap-2">
                        <?php if($_SESSION['permitsModule']['u']){ ?>
                        <app-button  icon="key" btn="secondary" @click="permissions(data)"></app-button>
                        <?php } ?>
                        <?php if($_SESSION['permitsModule']['u']){ ?>
                        <app-button  icon="edit" btn="success" @click="edit(data)"></app-button>
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
<?php footerAdmin($data); ?>