

<?php 
    $dataAnual = $data['data'];
    $ingresosAnual = $data['total'];
    $costosAnual = $data['costos'];
    $gastosAnual = $data['gastos'];
    $resultadoAnual = $ingresosAnual-($costosAnual+$gastosAnual);
?>
<script>
    Highcharts.chart('yearChart', {
        chart: {
            type: 'bar'
        },
        title: {
            text: 'Gráfico del año <?=$dataAnual[0]['year']?>'
        },
        subtitle: {
            text: `Ingresos: <?=formatNum($ingresosAnual)?> - Costos: <?=formatNum($costosAnual)?> - Gastos: <?=formatNum($gastosAnual)?><br>
                   Neto: <?=formatNum($resultadoAnual)?>`
        },
        xAxis: {
            categories: [
                <?php
                        for ($i=0; $i < count($dataAnual) ; $i++) { 
                            echo '"'.$dataAnual[$i]['month'].'",';
                        }    
                ?>
            ],
            title: {
            text: null
            }
        },
        yAxis: {
            min: 0,
            title: {
            text: 'Ingresos y egresos',
            align: 'high'
            },
            labels: {
            overflow: 'justify'
            }
        },
        tooltip: {
            valueSuffix: ` ${MD}`
        },
        plotOptions: {
            bar: {
            dataLabels: {
                enabled: true
            }
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            x: -40,
            y: 80,
            floating: true,
            borderWidth: 1,
            backgroundColor:
            Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
            shadow: true
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Ingresos',
            data: [
                <?php
                    for ($i=0; $i < count($dataAnual) ; $i++) { 
                        echo '["'.$dataAnual[$i]['month'].'"'.",".''.$dataAnual[$i]['sale'].'],';
                    }    
                ?>
            ],
        }, {
            name: 'Costos',
            data: [
                <?php
                    for ($i=0; $i < count($dataAnual) ; $i++) { 
                        echo '["'.$dataAnual[$i]['month'].'"'.",".''.$dataAnual[$i]['costos'].'],';
                    }    
                ?>
            ],
        }, {
            name: 'Gastos',
            data: [
                <?php
                    for ($i=0; $i < count($dataAnual) ; $i++) { 
                        echo '["'.$dataAnual[$i]['month'].'"'.",".''.$dataAnual[$i]['gastos'].'],';
                    }    
                ?>
            ],
        }]
    });
</script>