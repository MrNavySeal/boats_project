<app-modal title="Search categories" id="modalCategory" v-model="category.showModalPaginationCategory" size="lg">
    <template #body>
        <div class="row">
            <div class="col-md-4">
                <app-select label="Per page"  @change="search()" v-model="category.intPerPage">
                    <option value="10" selected>10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                    <option value="1000">1000</option>
                </app-select>
            </div>
            <div class="col-md-8">
                <app-input label="Search" @input="search()" v-model="category.strSearch"></app-input>
            </div>
        </div>
        <div class="table-responsive overflow-y no-more-tables" style="max-height:50vh">
            <table class="table align-middle table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Picture</th>
                        <th>Name</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(data,index) in category.arrData" :key="index">
                        <td data-title="ID">{{data.id}}</td>
                        <td data-title="Picture">
                            <img :src="data.url" :alt="data.name" class="img-thumbnail" style="width: 50px; height: 50px;">
                        </td>
                        <td data-title="Name">{{data.name}}</td>
                        <td data-title="Options">
                            <div class="d-flex gap-2">
                                <app-button  icon="new" btn="primary" @click="selectItem(data,'category')"></app-button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <app-pagination :common="category" @search="search"></app-pagination>
    </template>
    <template #footer></template>
</app-modal>