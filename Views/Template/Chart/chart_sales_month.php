<?php 
    $ingresos = $data['dataingresos'];
    $costos = $data['datacostos'];
    $gastos = $data['datagastos'];
    $resultadoMensual = $ingresos['total'] -($costos['total']+$gastos['total']);
?>
<script>
    Highcharts.chart('monthChart', {
        chart: {
            type: 'line'
        },
        title: {
            text: '<?=$ingresos['month']." ".$ingresos['year']?>'
        },
        subtitle: {
            text: `Sales: <?=formatNum($ingresos['total'])?>`
        },
        xAxis: {
            categories: [
                <?php
                    
                    for ($i=0; $i < count($ingresos['sales']) ; $i++) { 
                        echo $ingresos['sales'][$i]['day'].",";
                    }
                ?>
            ]
        },
        yAxis: {
            title: {
                text: ''
            }
        },
        plotOptions: {
            line: {
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: false
            }
        },
        series: [{
            name: 'Sales',
            data: [
                <?php
                    
                    for ($i=0; $i < count($ingresos['sales']) ; $i++) { 
                        echo $ingresos['sales'][$i]['total'].",";
                    }
                ?>
            ]
        }]
    });
</script>