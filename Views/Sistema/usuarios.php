<?php 
    headerAdmin($data);
    getModal("Sistema/modalUsuarios"); 
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
        <app-input label="Search" @input="search()" v-model="common.strSearch"></app-input>
    </div>
</div>
<div class="table-responsive overflow-y no-more-tables" style="max-height:50vh">
    <table class="table align-middle table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Picture</th>
                <th>Name</th>
                <th>ID number</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Country</th>
                <th>State</th>
                <th>City</th>
                <th>Address</th>
                <th>Role</th>
                <th>Date</th>
                <th>Status</th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(data,index) in common.arrData" :key="index">
                <td data-title="ID" class="text-center">{{data.id}}</td>
                <td data-title="Picture">
                    <img :src="data.url" :alt="data.name" class="img-thumbnail" style="width: 50px; height: 50px;">
                </td>
                <td data-title="Name">{{data.nombre}}</td>
                <td data-title="ID number">{{data.documento}}</td>
                <td data-title="Email">{{data.email}}</td>
                <td data-title="Phone" class="text-nowrap">{{data.telefono}}</td>
                <td data-title="Country">{{data.pais}}</td>
                <td data-title="State">{{data.departamento}}</td>
                <td data-title="City">{{data.ciudad}}</td>
                <td data-title="Address">{{data.direccion}}</td>
                <td data-title="Role">{{data.role}}</td>
                <td data-title="Date">{{data.fecha}}</td>
                <td data-title="Status" class="text-center">
                    <span :class="data.status == '1' ? 'bg-success' : 'bg-danger'" class="badge text-white">
                        {{ data.status == '1' ? "Active" : "Inactive" }}
                    </span>
                </td>
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