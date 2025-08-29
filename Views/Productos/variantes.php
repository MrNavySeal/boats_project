<?php 
    headerAdmin($data);
    getModal("modalVariant");
?>
<div class="body flex-grow-1 px-3" id="<?=$data['page_name']?>">
    <table class="table align-middle" id="tableData">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Qty</th>
                <th>Status</th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
<?php footerAdmin($data)?>         