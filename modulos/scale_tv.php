<?php
session_start();
require_once 'clases/vm_grafico_alarmas.php';
require_once 'vista/vw_scale_tv.php';

$Fecha=getdate();
$Anio=$Fecha["year"];

$mi_usuario = cl_usuario::traer_usuario($_SESSION["username"]);
$mi_area = $mi_usuario->getCod_area();
$mi_rol = $mi_usuario->getCod_rol();

$alarmas = vm_grafico_alarmas::traer_alarmas_nacional();
foreach($alarmas as $rows):
    $data_alarmas[] = array($rows['region'],$rows['sitios'],$rows['alarmas'],$rows['id_region']);
endforeach;

?>

<script type="text/javascript">
    setTimeout(function(){
        location = ''
    },180000)
</script>

<!-- ######## BARRA TITULO ######## -->
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>SCALE - Sistema de Conocimiento de Alarmas Eléctricas.</h2>
        <ol class="breadcrumb">
            <li class="active">
                <a href="?mod=home">Dashboard TV</a>
            </li>
        </ol>
    </div>
</div>

<!-- ######## CONTENIDO ######## -->
<div class="wrapper wrapper-content">
    <div class="row">

        <div class="ibox col-md-12">

            <div class="col-lg-2 col-md-3 hidden-sm p-xxs animated fadeIn">
                <!-- Mapa -->
                <div id="chartdiv" style="width: 100%; height: 730px; font-size: 11px;"></div>
            </div>

            <div class="col-lg-4 col-md-9 col-sm-12 p-xs animated fadeIn">
                <?php
                vw_scale_tv::alarmas_regiones($alarmas);
                ?>
            </div>

            <div class="col-lg-6 col-sm-12 p-xs m-b-md animated fadeIn">
                <?php
                vw_scale_tv::lista_top_recurrentes(9);
                ?>
            </div>

        </div>

    </div>
</div>
</div>




<!-- Mainly scripts -->
<script src="js/jquery-2.1.1.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<!-- JS Mapa -->
<script src="js/plugins/ammap/ammap.js"></script>
<!-- Skins Mapa -->
<script src="js/plugins/ammap/themes/black.js"></script>
<script src="js/plugins/ammap/themes/chalk.js"></script>
<script src="js/plugins/ammap/themes/dark.js"></script>
<script src="js/plugins/ammap/themes/light.js"></script>
<script src="js/plugins/ammap/themes/patterns.js"></script>
<script src="js/plugins/ammap/themes/none.js"></script>
<script src="js/plugins/ammap/themes/scale.js"></script>
<!-- Adicional al mapa -->
<script src="https://code.jquery.com/jquery-1.12.2.min.js"></script>


<script>

    var map = AmCharts.makeChart( "chartdiv", {
        "type": "map",              //ok
        "theme": "light",           //ok
        "dataProvider": {
            "mapURL": "js/plugins/ammap/maps/svg/chileLow.svg",   //ok
            "getAreasFromMap": true,
            "zoomLevel": 1.0,         //ok
            "areas": [
                <?php foreach ($data_alarmas as $datos): ?>
                <?php if ($datos[2] >= 10):; ?>
                <?php $color = '#fe2b00'; ?>
                <?php elseif ($datos[2] == 0):; ?>
                <?php $color = '#1c84c6'; ?>
                <?php else :; ?>
                <?php $color = '#ffb70a'; ?>
                <?php endif; ?>

                <?php echo '{ "id": "'.$datos[3].'", "color": "'.$color.'", "value": "'.$datos[2].'" },'; ?>
                <?php endforeach; ?>

            ]
        },
        "areasSettings": {
            "autoZoom": true,
            "balloonText": "[[title]]: <strong>[[value]]</strong>" //muestra cantidad de habitantes
        },
        /*
         "valueLegend": {
         "right": 20,
         "minValue": "0",
         "maxValue": "10+"
         },*/

        "zoomControl": {
            "minZoomLevel": 0.9
        },
        "titles": "Chile",
        "listeners":[{"event":"init", "method":updateHeatmap}]
    });


    function updateHeatmap(event) {
        var map = event.chart;
        //if ( map.dataGenerated )
        //    return;
        //if ( map.dataProvider.areas.length === 0 ) {
        //    setTimeout( updateHeatmap, 100 );
        //    return;
        //}
        //for ( var i = 0; i < map.dataProvider.areas.length; i++ ) {
        //    map.dataProvider.areas[ i ].value = Math.round( Math.random() * 10000 );
        //}
        map.dataGenerated = true;
        map.validateNow();
    }
</script>