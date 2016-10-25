<?php
session_start();
date_default_timezone_set('America/Santiago');
// require_once 'vista/vw_historial.php';
// require_once 'clases/sitios.php';
require_once 'clases/vm_grafico_reportes.php';
require_once 'vista/vw_home.php';
require_once 'vista/vw_reportes.php';
// require_once 'clases/procesador_texto.php';
// require_once 'clases/conexion_ftp.php';
// require_once 'clases/server_ftp.php';


function getStartAndEndDate($week, $year) {
    $dto = new DateTime();
    $dto->setISODate($year, $week);
    $ret['week_start'] = $dto->format('Y-m-d');
    $dto->modify('+6 days');
    $ret['week_end'] = $dto->format('Y-m-d');
    return $ret;
}

function getWeekNumber() {
    $ddate = date("Y-m-d");
    $duedt = explode("-", $ddate);
    $date  = mktime(0, 0, 0, $duedt[1], $duedt[2], $duedt[0]);
    $week  = (int)date('W', $date);
    return $week;
}
// $week = getWeekNumber();
$week = 32;
$year = 2016;
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">

        <h2>SCALE - Sistema de Conocimiento de Alarmas Eléctricas.
        <div class="pull-right hidden-sm hidden-xs">
        <?php
        // Vista de tabla por regiones
        vw_home::botonera_tv();
        ?>
        </div></h2>
        <ol class="breadcrumb">
            <li class="active">
                <a href="?mod=home">Reportes</a>
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInDown">

    <div class="row">

        <div class="col-md-10">
            
            <div class="col-lg-6 col-md-5 hidden-sm hidden-xs">
                <div class="widget dark-blue-bg p-lg text-center">
                    <div class="m-b-md">
                        <h3 class="p-xxs">Alarmas Semanales</h3>
                        <div id="chartdiv_semanal" style="width: 100%; height: 300px;"></div>
                        <!-- <div id="chartdiv_pie" style="width: 100%; height: 300px;"></div> -->
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-5 hidden-sm hidden-xs">
                <div class="widget white-bg p-lg text-center">
                    <div class="m-b-n-md">
                        <h3 class="p-xxs">Autonomías Registradas</h3>
                        <?php
                        vw_reportes::alarmas_diferentes($week,$year);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">

        <div class="col-md-12">

            <div class="col-lg-4 col-md-5 hidden-sm hidden-xs">
                <div class="widget blue-bg p-lg text-center">
                    <div class="m-b-md">
                        <h3 class="p-xxs">Alarmas Diarias</h3>
                        <!-- <div id="chartdiv_pie" style="width: 100%; height: 300px;"></div> -->
                        <!-- <div id="chartdiv_semanal" style="width: 100%; height: 300px;"></div> -->
                    </div>
                </div>
            </div>

            <div class="col-lg-8 col-md-5 hidden-sm hidden-xs">
                <div class="widget blue-bg p-lg text-center">
                    <div class="m-b-md">
                        <h3 class="p-xxs">Alarmas Mensuales</h3>
                        <div id="chartdiv_bar" style="width: 100%; height: 200px;"></div>
                    </div>
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

<!-- Peity -->
<script src="js/plugins/peity/jquery.peity.min.js"></script>
<script src="js/demo/peity-demo.js"></script>

<!-- Custom and plugin javascript -->
<script src="js/inspinia.js"></script>
<script src="js/plugins/pace/pace.min.js"></script>

<!-- Tinycon -->
<script src="js/plugins/tinycon/tinycon.min.js"></script>

<!-- jQuery UI -->
<script src="js/plugins/jquery-ui/jquery-ui.min.js"></script>

<!-- Sparkline -->
<script src="js/plugins/sparkline/jquery.sparkline.min.js"></script>

<!-- Sparkline demo data  -->
<script src="js/demo/sparkline-demo.js"></script>

<!-- ChartJS-->
<script src="js/plugins/chartJs/Chart.min.js"></script>

<!-- Toastr script -->
<script src="js/plugins/toastr/toastr.min.js"></script>

<!-- Data Tables -->
<script src="js/plugins/dataTables/datatables.min.js"></script>

<script src="js/plugins/masonary/masonry.pkgd.min.js"></script>

<!-- Exportar Excel -->
<script src="js/plugins/excel/jquery.table2excel.js"></script>

<!-- Data picker -->
<script src="js/plugins/datapicker/bootstrap-datepicker.js"></script>
<!-- Chosen -->
<script src="js/plugins/chosen/chosen.jquery.js"></script>

<!-- AM CHART -->
<script src="js/plugins/amcharts/amcharts.js"></script>
<script src="js/plugins/amcharts/plugins/export/export.min.js"></script>
<link rel="stylesheet" href="js/plugins/amcharts/plugins/export/export.css" type="text/css" media="all" />
<script src="js/plugins/amcharts/themes/dark.js"></script>
<script src="js/plugins/amcharts/themes/light.js"></script>
<script src="js/plugins/amcharts/themes/chalk.js"></script>
<script src="js/plugins/amcharts/themes/patterns.js"></script>
<script src="js/plugins/amcharts/themes/black.js"></script>
<!-- <script src="js/plugins/amcharts/funnel.js"></script> -->
<!-- <script src="js/plugins/amcharts/gantt.js"></script> -->
<!-- <script src="js/plugins/amcharts/gauge.js"></script> -->
<script src="js/plugins/amcharts/pie.js"></script>
<!-- <script src="js/plugins/amcharts/radar.js"></script> -->
<script src="js/plugins/amcharts/serial.js"></script>
<!-- <script src="js/plugins/amcharts/xy.js"></script> -->

<?php
    vw_reportes::grafico_semanal();

    vw_reportes::grafico_pie();

    vw_reportes::grafico_bar();
?>

<script>
    $(document).ready(function(){
        /* Init DataTables */
        var oTable = $('#table_reportes').DataTable({
        "paging":   false,
        "ordering": false,
        // "info": false,
        "filter": false,
        "scrollY": "240px",
        // "scrollCollapse": true,
        // "order": [[ 1, "desc" ]],
        // "aoColumns": [
        //     null,
        //     { "orderSequence": [ "desc", "asc" ] },
        // ],
        // "dom": "<'row'<'col-sm-6'l><'col-sm-6'f>>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
        // "lengthMenu": [ [6, 25, 50, -1], [6, 25, 50, "All"] ],
        // "iDisplayLength": 20,
        dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
            buttons: [
                // {extend: 'copy',className: 'btn-sm'},
                // {extend: 'csv',title: 'ExampleFile', className: 'btn-sm'},
                {extend: 'excel',title: 'Historial', className: 'btn-sm'},
                // {extend: 'pdf', title: 'ExampleFile', className: 'btn-sm'},
                {extend: 'print',className: 'btn-sm'}
            ]
        });
    });
</script>
