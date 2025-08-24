<?php headerAdmin($data)?>
<div id="modalItem"></div>
<div class="body flex-grow-1 px-3" id="<?=$data['page_name']?>">
    <div class="scroll-y">
        <table class="table items align-middle" id="table<?=$data['page_title']?>">
            <thead>
                <tr>
                    <th>Picture</th>
                    <th>Status</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody id="listItem">
                <?=$data['data']['data']?>
            </tbody>
        </table>
    </div>
</div>   
<?php footerAdmin($data)?>        