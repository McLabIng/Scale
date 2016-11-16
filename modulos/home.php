<?php
session_start();
require_once 'clases/usuario.php';
require_once 'clases/vm_grafico_alarmas.php';
require_once 'clases/vm_admin.php';
require_once 'vista/vw_home.php';
require_once 'clases/procesador_texto.php';
require_once 'clases/conexion_ftp.php';
require_once 'clases/server_ftp.php';

$Fecha=getdate();
$Anio=$Fecha["year"];

$mi_usuario = cl_usuario::traer_usuario($_SESSION["username"]);
$mi_area = $mi_usuario->getCod_area();
$mi_rol = $mi_usuario->getCod_rol();

$alarmas = vm_grafico_alarmas::traer_alarmas_nacional();
$alarmas_sin_conexion = vm_grafico_alarmas::traer_sin_conexion_nacional();
foreach($alarmas as $rows):
    $data_alarmas[] = array($rows['region'],$rows['sitios'],$rows['alarmas']);
endforeach;

$cantidad = vw_home::cantidad_alarmas_nacional();

$lista_nodos = vm_admin::conexion_nodos();

?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2 class="pull-right">Sub Gerencia O&M Infraestructura</h2>
        <h2>SCALE - Sistema de Conocimiento de Alarmas Eléctricas
        <div class="pull-right hidden-sm hidden-xs">
        <?php
        // Vista de tabla por regiones
        // vw_home::botonera_tv();
        ?>
        </div></h2>
        <ol class="breadcrumb">
            <li class="active">
                <a href="?mod=home">Alarmas a nivel nacional</a>
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInDown">

    <div class="row">

        <div class="col-lg-3 col-md-5 col-sm-12 animated fadeIn m-t-n m-b-xl">
            <?php
            vw_home::alarmas_regiones($alarmas,$alarmas_sin_conexion);
            ?>
        </div>

        <div class="col-lg-9 col-md-7 hidden-sm hidden-xs m-t-n">
            <div class="ibox float-e-margins">
                <div class="ibox-title col-md-12 ui-widget-header blue-bg">
                    <button class="pull-right btn btn-md btn-primary"><i class="fa fa-file-excel-o"></i></button>
                    <h4 class="p-xxs">Sitios Alarmados</h4>
                </div>
                <?php
                    vw_home::lista_top_recurrentes();
                ?>
            </div>
        </div>

        <!-- <div class="col-lg-9 hidden-md hidden-sm">
            <div class="ibox float-e-margins">
                <div class="ibox-title col-md-12 ui-widget-header blue-bg">
                    <h4>Alarmas electricas por regiones</h4>
                    <h6>De ultimos 60 minutos</h6>
                </div>
                <div class="ibox-content">
                    <div style="text-align: center">
                        <p class="label">Sitios</p>
                        <p class="label label-danger">Alarmas</p>
                    </div>
                    <div id="destino_grafico">
                        <canvas class="center-block" id="barChart" height="30"></canvas>
                    </div>
                </div>
            </div>
        </div> -->

    </div>
    <div class="row">
        <div class="col-md-12">

            <div class="widget blue-bg col-sm-12 hidden-xs m-t-n m-b-xl">
                <h4 class="">ESTADO CONEXION DE NODOS</h4>
                <br/>
                <?php
                    vw_home::estado_llamado_sitio($lista_nodos);
                ?>
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

<!-- Script para exportar a Excel -->
<script>
    $("button").click(function(){
        $("#top_table").table2excel({
            // exclude CSS class
            exclude: ".noExl",
            name: "Sitios recurrentes",
            filename: "Sitios recurrentes"

        });
    });
</script>

<script>
    $(document).ready(function () {
        $('.scroll_content').slimscroll({
            height: '581px',
            opacity: 0.1,
            wheelStep : 10,
        })
    });
</script>

<style>

    .grid .ibox {
        margin-bottom: 0;
    }

    .grid-item {
        margin-bottom: 25px;
        width: 300px;
    }
</style>

<script>
    $(window).load(function() {

        $('.grid').masonry({
            // options
            itemSelector: '.grid-item',
            columnWidth: 300,
            gutter: 25
        });

    });
</script>
 

<script>
     var time = new Date().getTime();
     $(document.body).bind("mousemove keypress", function(e) {
         time = new Date().getTime();
     });

     function refresh() {
         if(new Date().getTime() - time >= 180000) 
             // window.location.reload(true);
         window.location = "index.php?mod=tv";
         else 
             setTimeout(refresh, 10000);
     }

     setTimeout(refresh, 10000);
</script>

