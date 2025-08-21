<?php
    $paginas = $data['pages'];

    $nextPage = $data['next'];
    $prevPage = $data['prev'];
    $current = $data['data'];
    $urlSort =$data['sort'];
    $urlSearch = $data['search'];

?>
<div class="pagination">
    <?php if($current > 1){?>
    <a href="<?=base_url()."/tienda/buscar?p=1".$urlSort.$urlSearch?>" class="pagination-btn pagination-start"><i class="fas fa-angle-double-left" aria-hidden="true"></i></a>
    <a href="<?=base_url()."/tienda/buscar?p=".$prevPage.$urlSort.$urlSearch?>" class="pagination-btn pagination-prev"><i class="fas fa-angle-left" aria-hidden="true"></i></a>
    <?php }?>
    <?php if($current < $paginas){?>
    <a href="<?=base_url()."/tienda/buscar?p=".$nextPage.$urlSort.$urlSearch?>" class="pagination-btn pagination-next"><i class="fas fa-angle-right" aria-hidden="true"></i></a>
    <a href="<?=base_url()."/tienda/buscar?p=".$paginas.$urlSort.$urlSearch?>" class="pagination-btn pagination-end"><i class="fas fa-angle-double-right" aria-hidden="true"></i></a>
    <?php }?>
</div>