<?php 
//dep($data['salesMonth']);exit;
    headerAdmin($data);
    $orders = $data['orders'];
    $productos = $data['products'];
    $costos=$data['resumenMensual']['costos']['total'];
    $gastos = $data['resumenMensual']['gastos']['total'];
    $ingresos = $data['resumenMensual']['ingresos']['total'];

    $ingresosAnual = $data['resumenAnual']['total'];
    $costosAnual = $data['resumenAnual']['costos'];
    $gastosAnual = $data['resumenAnual']['gastos'];

    $resultadoAnual = $ingresosAnual-($costosAnual+$gastosAnual);
    $resultadoMensual = $ingresos -($costos+$gastos);

    $dataAnual = $data['resumenAnual']['data'];
?>
    
    <div class="body flex-grow-1 px-3" id="<?=$data['page_name']?>">
        <div class="row">
        <?php if($_SESSION['userData']['roleid'] != 2 && $_SESSION['permitsModule']['r']){?>
        <div class="col-md-3">
            <div class="card mb-4 position-relative">
                <div style="font-size:5rem; color:#fff" class="p-5 card-header bg-primary position-relative d-flex justify-content-center align-items-center">
                    <i class="fas fa-users"></i>
                </div>
                <div class="card-body row text-center">
                    <div class="col">
                        <div class="fs-5 fw-semibold"><?=$data['totalUsers']?></div>
                        <div class="text-uppercase text-medium-emphasis small">Users</div>
                    </div>
                </div>
                <a href="<?=base_url();?>/system/users/" class="position-absolute w-100 h-100"></a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card mb-4 position-relative">
                <div style="font-size:5rem; color:#fff" class="p-5 card-header bg-info position-relative d-flex justify-content-center align-items-center">
                    <i class="fas fa-user"></i>
                </div>
                <div class="card-body row text-center">
                    <div class="col">
                        <div class="fs-5 fw-semibold"><?=$data['totalCustomers']?></div>
                        <div class="text-uppercase text-medium-emphasis small">Customers</div>
                    </div>
                </div>
                <a href="<?=base_url();?>/customers/" class="position-absolute w-100 h-100"></a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card mb-4 position-relative">
                <div style="font-size:5rem; color:#fff" class="p-5 card-header bg-success position-relative d-flex justify-content-center align-items-center">
                    <i class="fas fa-coins"></i>
                </div>
                <div class="card-body row text-center">
                    <div class="col">
                        <div class="fs-5 fw-semibold"><?=$data['totalSales']?></div>
                        <div class="text-uppercase text-medium-emphasis small">Sales</div>
                    </div>
                </div>
                <a href="#" class="position-absolute w-100 h-100"></a>
            </div>
        </div>
        <?php }?>
        <div class="col-md-3">
            <div class="card mb-4 position-relative">
                <div style="font-size:5rem; color:#fff" class="p-5 card-header bg-danger position-relative d-flex justify-content-center align-items-center">
                    <i class="fas fa-receipt"></i>
                </div>
                <div class="card-body row text-center">
                    <div class="col">
                        <div class="fs-5 fw-semibold"><?=$data['totalOrders']?></div>
                        <div class="text-uppercase text-medium-emphasis small">Orders</div>
                    </div>
                </div>
                <a href="<?=base_url();?>/orders/" class="position-absolute w-100 h-100"></a>
            </div>
        </div>
    </div>
    <?php if($_SESSION['userData']['roleid'] != 2 && $_SESSION['permitsModule']['r']){?>
    <div class="card mb-4">
        <h2 class="p-4">Sales</h2>
        <div class="row">
            <div class="col-md-6">
                <div class="card-body">
                    <div class="d-flex justify-content-end mb-3">
                        <div class="d-flex align-items-center">
                            <input  class="date-picker contabilidadMes" name="contabilidadMes" placeholder="Month and year" required>
                            <button class="btn btn-sm btn-primary" id="btnContabilidadMes"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                    <figure class="highcharts-figure mb-3 mt-3"><div id="monthChart"></div></figure>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card-body">
                    <div class="d-flex justify-content-end mb-3">
                        <div class="d-flex align-items-center">
                            <input type="number" name="contabilidadAnio" id="sYear" placeholder="Year" min="2000" max="9999">
                            <button class="btn btn-sm btn-primary" id="btnContabilidadAnio"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                    <figure class="highcharts-figure"><div id="yearChart"></div></figure>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-4">
        <h2 class="p-4">Customers</h2>
        <div class="row">
            <div class="col-md-6">
                <div class="card-body">
                    <div class="d-flex justify-content-end mb-3">
                        <div class="d-flex align-items-center">
                            <input  class="date-picker clientesMes" name="clientesMes" placeholder="Month and year" required>
                            <button class="btn btn-sm btn-primary" id="btnClientesMes"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                    <figure class="highcharts-figure mb-3 mt-3"><div id="monthChartCustomers"></div></figure>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card-body">
                    <div class="d-flex justify-content-end mb-3">
                        <div class="d-flex align-items-center">
                            <input type="number" name="clientessAnio" id="customerYear" placeholder="Year" min="2000" max="9999">
                            <button class="btn btn-sm btn-primary" id="btnClientesAnio"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                    <figure class="highcharts-figure"><div id="yearChartCustomers"></div></figure>
                </div>
            </div>
        </div>
    </div>
    <?php }?>
    
<?php footerAdmin($data)?>     
