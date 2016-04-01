<?php
session_start();
require_once 'clases/usuario.php';
require_once 'clases/vm_grafico_alarmas.php';
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
foreach($alarmas as $rows):
    $data_alarmas[] = array($rows['region'],$rows['sitios'],$rows['alarmas']);
endforeach;

?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">

        <h2>SCALE - Sistema de Conocimiento de Alarmas Eléctricas.
        <div class="pull-right">
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
        <div class="spiner-example col-lg-3" id="cargando_tabla">
            <div class="sk-spinner sk-spinner-wave">
                <div class="sk-rect1"></div>
                <div class="sk-rect2"></div>
                <div class="sk-rect3"></div>
                <div class="sk-rect4"></div>
                <div class="sk-rect5"></div>
            </div>
            <br><br>
            <div style="text-align: center"><label class="label label-success"><i class="fa fa-list"></i>&nbsp; Cargando...</label></div>
        </div>

        <div class="col-lg-3" id="destino_tabla"></div>

        <div class="col-lg-9">

            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Alarmas electricas por regiones</h5><br>
                    <h6>De ultimos 60 minutos</h6>
                </div>
                <div class="ibox-content">
                    <div style="text-align: center">
                        <p class="label">Sitios</p>
                        <p class="label label-danger">Alarmas</p>
                    </div>
                    <div id="destino_grafico">
                        <canvas class="center-block" id="barChart" height="50"></canvas>
                    </div>
                </div>
            </div>

            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Top Sitios con alarmas recurrentes</h5>
                </div>
                <?php
                    vw_home::lista_top_recurrentes(50);
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

<!-- Flot -->
<script src="js/plugins/flot/jquery.flot.js"></script>
<script src="js/plugins/flot/jquery.flot.tooltip.min.js"></script>
<script src="js/plugins/flot/jquery.flot.spline.js"></script>
<script src="js/plugins/flot/jquery.flot.resize.js"></script>
<script src="js/plugins/flot/jquery.flot.pie.js"></script>
<script src="js/plugins/flot/jquery.flot.symbol.js"></script>
<script src="js/plugins/flot/curvedLines.js"></script>

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

<!-- Jvectormap -->
<script src="js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>

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
    var barData = {
        labels: [
            <?php $i=0;
                foreach($data_alarmas as $datos){ $i++;
            ?>
            <?php echo "'$datos[0]'"; ?> ,
            <?php
                if(count($data_alarmas) == $i-1){
            ?>
            <?php echo "'$datos[0]'"; ?>
            <?php
                }
            } ?>
        ],
        datasets: [
            {
                label: "Sitios",
                fillColor: "rgba(220,220,220,0.5)",
                strokeColor: "rgba(220,220,220,0.8)",
                highlightFill: "rgba(220,220,220,0.75)",
                highlightStroke: "rgba(220,220,220,1)",
                data: [
                    <?php
                    $i=0;
                    foreach($data_alarmas as $datos)
                    {
                        $i++;
                        echo $datos[1]; ?> ,
                    <?php
                        if(count($data_alarmas) == $i-1){
                            echo $datos[1];
                        }
                    }
                ?>
                ]
            },
            {
                label: "Alarmas",
                fillColor: "rgba(236, 71, 88,0.5)",
                strokeColor: "rgba(236, 71, 88,0.8)",
                highlightFill: "rgba(236, 71, 88,0.75)",
                highlightStroke: "rgba(236, 71, 88,1)",
                data: [
                    <?php
                    $i=0;
                    foreach($data_alarmas as $datos)
                    {
                        $i++;
                        echo $datos[2]; ?> ,
                    <?php
                        if(count($data_alarmas) == $i-1){
                            echo $datos[2];
                        }
                    }
                ?>
                ]
            }
        ]
    };

    var barOptions = {
        scaleBeginAtZero: true,
        scaleShowGridLines: true,
        scaleGridLineColor: "rgba(0,0,0,.05)",
        scaleGridLineWidth: 1,
        barShowStroke: true,
        barStrokeWidth: 1,
        barValueSpacing: 5,
        barDatasetSpacing: 1,
        responsive: true,
    }


    var ctx = document.getElementById("barChart").getContext("2d");
    var myNewChart = new Chart(ctx).Bar(barData, barOptions);
</script>

<script>
    $(document).ready(function(){
        $("#cargando_tabla").css("display", "inline");
        $("#destino_tabla").load("modulos/transicion_tabla_home.php", function(){
            $("#cargando_tabla").css("display", "none");
        });
    })
</script>

<!-- Page-Level Scripts -->
<script>
    $(document).ready(function() {
        $('.dataTables-example').dataTable({
            responsive: true,
            "dom": 'T<"clear">lfrtip',
            "tableTools": {
                "sSwfPath": "js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"
            }
        });

        /* Init DataTables */
        var oTable = $('#editable').dataTable();
        oTable.order([1, 'desc']).draw();

        /* Apply the jEditable handlers to the table */
        oTable.$('td').editable( '../example_ajax.php', {
            "callback": function( sValue, y ) {
                var aPos = oTable.fnGetPosition( this );
                oTable.fnUpdate( sValue, aPos[0], aPos[1] );
            },
            "submitdata": function ( value, settings ) {
                return {
                    "row_id": this.parentNode.getAttribute('id'),
                    "column": oTable.fnGetPosition( this )[2]
                };
            },

            "width": "90%",
            "height": "100%"
        } );


    });

    function fnClickAddRow() {
        $('#editable').dataTable().fnAddData( [
            "Custom row",
            "New row",
            "New row",
            "New row",
            "New row" ] );

    }
</script>
<style>
    body.DTTT_Print {
        background: #fff;

    }
    .DTTT_Print #page-wrapper {
        margin: 0;
        background:#fff;
    }

    button.DTTT_button, div.DTTT_button, a.DTTT_button {
        border: 1px solid #e7eaec;
        background: #fff;
        color: #676a6c;
        box-shadow: none;
        padding: 6px 8px;
    }
    button.DTTT_button:hover, div.DTTT_button:hover, a.DTTT_button:hover {
        border: 1px solid #d2d2d2;
        background: #fff;
        color: #676a6c;
        box-shadow: none;
        padding: 6px 8px;
    }

    .dataTables_filter label {
        margin-right: 5px;

    }
</style>