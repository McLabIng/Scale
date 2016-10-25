<?php
session_start();
require_once 'clases/usuario.php';
require_once 'clases/vm_admin.php';
require_once 'vista/vw_admin.php';
require_once 'vista/vw_home.php';
require_once 'clases/procesador_texto.php';
require_once 'clases/conexion_ftp.php';
require_once 'clases/server_ftp.php';

$lista_nodos = vm_admin::conexion_nodos();

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
                <a href="?mod=home">Alarmas a nivel nacional</a>
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInDown">

    <div class="row">
        <div class="col-md-2">

            <div class="widget blue-bg col-md-12 m-t-n m-b-xxs">
                <!-- <div class="ibox-title "> -->
                    <h4 class="">ESTADO BUSQUEDA NODOS</h4>
                <!-- </div> -->
                <br/>
                <?php
                    vw_admin::estado_llamado_sitio($lista_nodos);
                ?>
            </div>

        </div>
    <!-- </div>
    <br/>
    <div class="row"> -->

        <div class="col-md-10">

            <div class="ibox float-e-margins m-t-n">
                <div class="ibox-title col-md-12 ui-widget-header blue-bg">
                    <h4 class="p-xxs">Ingreso de sitios</h4>
                </div>
                <?php
                    vw_admin::ingreso_sitio();
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
<!-- <script src="js/plugins/toastr/toastr.min.js"></script> -->

<!-- Data Tables -->
<!-- <script src="js/plugins/dataTables/datatables.min.js"></script> -->

<script src="js/plugins/masonary/masonry.pkgd.min.js"></script>
