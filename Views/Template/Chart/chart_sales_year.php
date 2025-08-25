

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
            text: 'Year <?=$dataAnual[0]['year']?>'
        },
        subtitle: {
            text: `Sales: <?=formatNum($ingresosAnual)?>`
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
            text: 'Sales',
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
            name: 'Sales',
            data: [
                <?php
                    for ($i=0; $i < count($dataAnual) ; $i++) { 
                        echo '["'.$dataAnual[$i]['month'].'"'.",".''.$dataAnual[$i]['sale'].'],';
                    }    
                ?>
            ],
        }]
    });
</script>