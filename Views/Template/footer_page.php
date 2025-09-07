<?php 
$discount = statusCoupon();
$company = getCompanyInfo();
$social = getSocialMedia();
$services = getNavServices();

$links ="";
for ($i=0; $i < count($social) ; $i++) { 
    if($social[$i]['link']!=""){
        if($social[$i]['name']=="whatsapp"){
            $links.='<li><a href="https://wa.me/'.$social[$i]['link'].'" target="_blank"><i class="fab fa-'.$social[$i]['name'].'"></i></a></li>';
        }else{
            $links.='<li><a href="'.$social[$i]['link'].'" target="_blank"><i class="fab fa-'.$social[$i]['name'].'"></i></a></li>';
        }
    }
}

?>

    <footer>
        <div class="row m-0 mt-3">
            <div class="col-lg-6 p-5">
                <div class="logo">
                    <img src="<?=media()."/images/uploads/".$company['logo']?>" alt="<?=$company['name']?>">
                </div>
                <p><?=$company['description']?></p>
                <p class="fw-bold fs-4">Follow us</p>
                <ul class="social social--dark">
                    <?=$links?>
                </ul>
            </div>
            <div class="col-lg-6 p-0">
                <div class="footer--info">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="footer--data">
                                <div class="footer--title">
                                    <h3>Services
                                        <span class="title--decoration">
                                            <span></span><span></span><span></span><span></span><span></span>
                                        </span>
                                    </h3>
                                </div>
                                <ul>
                                    <?php
                                        foreach ($services as $det) {
                                            echo '<li><a href="'.base_url()."/shop/service/".$det['route'].'">'.$det['name'].'</a></li>';
                                        }
                                    ?>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="footer--data">
                                <div class="footer--title">
                                    <h3>Official information
                                        <span class="title--decoration">
                                            <span></span><span></span><span></span><span></span><span></span>
                                        </span>
                                    </h3>
                                </div>
                                <ul>
                                    <li><?=$company['addressfull']?></li>
                                    <li><?=$company['phone']?></li>
                                    <li><?=$company['email']?></li>
                                </ul>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="row m-0">
            <div class="col-md-12 p-0">
                <div class="footer--bar">
                    <p>Copyright © <?=date("Y")." ".$company['name']?></p>
                    <ul>
                        <li><a href="<?=base_url()?>">Home</a></li>
                        <li><a href="<?=base_url()?>/terms/">Terms and conditions</a></li>
                        <li><a href="<?=base_url()?>/privacy/">Privacy terms</a></li>
                        <li><a href="<?=base_url()?>/contact/">Contact</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    </div>
    <!------------------------------Frameworks--------------------------------->
    <script src="<?= media();?>/frameworks/jquery/jquery.js"></script>
    <script src="<?= media(); ?>/frameworks/bootstrap/popper.min.js?n=1"></script>
    <script src="<?= media(); ?>/frameworks/bootstrap/bootstrap.min.js?n=1"></script>
    
    
    <!------------------------------Plugins--------------------------------->
    <script src="<?= media();?>/plugins/fontawesome/fontawesome.js"></script>
    <script src="<?= media();?>/plugins/sweetalert/sweetalert.js"></script>
    <script src="<?= media();?>/plugins/owlcarousel/owl.carousel.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>

    <script src="<?= media();?>/plugins/datepicker/jquery-ui.min.js"></script>
    <script src="<?= media();?>/plugins/sheetjs/sheetjs.js"></script>
    <script src="<?= media();?>/plugins/print/print.min.js"></script>
    <!--<script src="<?= media();?>/plugins/datatables/pdfmake.min.js"></script>
    <script src="<?= media();?>/plugins/datatables/vfs_fonts.min.js"></script>-->
    <script src="<?= media();?>/plugins/datatables/datatables.min.js"></script>
    <script src="<?= media();?>/plugins/datatables/jszip.min.js"></script>
    <script src="<?= media();?>/plugins/vue/vue.js"></script>
    <!------------------------------My functions--------------------------------->
    <script>
        const base_url = "<?= base_url(); ?>";
        const MS = "<?=$company['currency']['symbol'];?>";
        const MD = "<?=$company['currency']['code']?>";
        const COMPANY = "<?=$company['name']?>";
        const SHAREDHASH ="<?=strtolower(str_replace(" ","",$company['name']))?>";
    </script>
    
    <script src="<?=media();?>/js/functions.js?v=<?=rand()?>"></script>
    <script src="<?=media();?>/template/Assets/js/functions_general.js?v=<?=rand()?>"></script>
    <?php if(isset($data['app'])){?>
    <script src="<?=media();?>/template/Assets/js/<?=$data['app']."?v=".rand()?>"></script>
    <?php }?>
    <?php if(isset($data['panelapp'])){?>
    <script src="<?=media();?>/js/<?=$data['panelapp']."?v=".rand()?>"></script>
    <?php }?>
    <?php if(isset($data['page_functions'])){
        $functions = $data['page_functions'];
        foreach ($functions as $det) { 
    ?>
    <script src="<?=media();?>/template/Assets/js/<?=$det."?v=".rand()?>"></script>
    <?php }}?>
</body>
</html>