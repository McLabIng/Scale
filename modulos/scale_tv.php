<?php
session_start();
require_once 'clases/vm_grafico_alarmas.php';
require_once 'vista/vw_scale_tv.php';
require_once 'clases/vm_admin.php';

$Fecha=getdate();
$Anio=$Fecha["year"];

$mi_usuario = cl_usuario::traer_usuario($_SESSION["username"]);
$mi_area = $mi_usuario->getCod_area();
$mi_rol = $mi_usuario->getCod_rol();

$alarmas = vm_grafico_alarmas::traer_alarmas_nacional();
$alarmas_sin_conexion = vm_grafico_alarmas::traer_sin_conexion_nacional();
foreach($alarmas as $rows):
    $data_alarmas[] = array($rows['region'],$rows['sitios'],$rows['alarmas'],$rows['id_region']);
endforeach;
$lista_nodos = vm_admin::conexion_nodos();
?>

<script type="text/javascript">
    setTimeout(function(){
        location = '';
    },25000);
</script>

<!-- ######## BARRA TITULO ######## -->
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2 class="pull-right">Sub Gerencia O&M Infraestructura</h2>
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

        <div class="ibox col-md-12 m-t-n">

            <div class="col-lg-2 col-md-3 hidden-sm p-xxs ">
                <!-- Mapa -->
                <div id="chartdiv" style="width: 100%; height: 730px; font-size: 11px;"></div>
            </div>

            <div class="col-lg-4 col-md-9 col-sm-12 p-xs ">
                <?php
                vw_scale_tv::alarmas_regiones($alarmas,$alarmas_sin_conexion);
                ?>
            </div>

            <div class="col-lg-6 col-sm-12 p-xs m-b-md ">
                <?php
                vw_scale_tv::lista_top_recurrentes(9);
                ?>
            </div>

        </div>

    </div>
    <div class="row">
        <div class="col-md-12 m-t-n">

            <div class="widget blue-bg col-md-12 m-t-n m-b-xxs">
                <!-- <div class="ibox-title "> -->
                    <h4 class="">ESTADO CONEXION DE NODOS</h4>
                <!-- </div> -->
                <br/>
                <?php
                    vw_scale_tv::estado_llamado_sitio($lista_nodos);
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

<!-- Data Tables -->
<script src="js/plugins/dataTables/datatables.min.js"></script>

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
<!-- <script src="https://code.jquery.com/jquery-1.12.2.min.js"></script>
 -->

<script>

    var map = AmCharts.makeChart( "chartdiv", {
        "type": "map",              //ok
        "theme": "light",           //ok
        "dataProvider": {
            "mapURL": "js/plugins/ammap/maps/svg/chileLow.svg",   //ok
            "getAreasFromMap": true,
            "zoomLevel": 1.0,         //ok
            "areas": [
                <?php 
                foreach ($data_alarmas as $datos): 
                    if ($datos[2] >= 10){
                        $color = '#fe2b00';}
                    elseif ($datos[2] == 0){;
                        $color = '#1c84c6';}
                    else {
                        $color = '#ffb70a';}

                echo '{ "id": "'.$datos[3].'", "color": "'.$color.'", "value": "'.$datos[2].'" },';
                endforeach; ?>
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
<!-- <script>
    $(document).ready(function(){
        /* Init DataTables */
        var oTable = $('#editable').DataTable({
        "paging":   false,
        "ordering": false,
        "info": false,
        "filter": false,

        // "scrollY": "544px",
        // "scrollX": false,
        // "scrollCollapse": true,
        // "autoWidth": false,

        // "order": [[ 1, "desc" ]],
        // "aoColumns": [
        //     null,
        //     { "orderSequence": [ "desc", "asc" ] },
        // ],
        // "dom": "<'row'<'col-sm-6'l><'col-sm-6'f>>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
        // "lengthMenu": [ [6, 25, 50, -1], [6, 25, 50, "All"] ],
        // "iDisplayLength": 2,
        });
    });
</script> -->

<script>
    var my_time;
    var delay = 1000 * 3;
    
    $(document).ready(function() {
        setTimeout(function(){
            pageScroll();
        }, delay); 
        $("#contain").mouseover(function() {
            clearTimeout(my_time);
        }).mouseout(function() {
            pageScroll();
        });
    });
    
    function pageScroll() {
        var objDiv = document.getElementById("contain");
        objDiv.scrollTop = objDiv.scrollTop + 1;  
        if ((objDiv.scrollTop + 631) == objDiv.scrollHeight) {
            setTimeout(function(){
                objDiv.scrollTop = 0;
            }, delay);
        }
        my_time = setTimeout('pageScroll()', 35);
    }
</script>