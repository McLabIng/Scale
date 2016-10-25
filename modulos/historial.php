<?php
session_start();
require_once 'vista/vw_historial.php';
require_once 'clases/sitios.php';
require_once 'clases/vm_grafico_alarmas.php';
require_once 'vista/vw_home.php';
require_once 'clases/procesador_texto.php';
require_once 'clases/conexion_ftp.php';
require_once 'clases/server_ftp.php';

$listado_sitios = sitios::listado_sitios();

?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2 class="pull-right">Sub Gerencia O&M Infraestructura</h2>
        <h2>SCALE - Sistema de Conocimiento de Alarmas Eléctricas.
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

        <div class="col-sm-12 m-t-n">
            <div class="ibox float-e-margins">
                <div class="ibox-title col-md-12 ui-widget-header blue-bg">
                    <!-- <button class="pull-right btn btn-md btn-primary"><i class="fa fa-file-excel-o"></i></button> -->
                    <h4 class="p-xxs">Busqueda alarmas</h4>
                </div>
                <?php
                    vw_historial::busqueda_historial($listado_sitios);
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

<!-- Data picker -->
<script src="js/plugins/datapicker/bootstrap-datepicker.js"></script>
<!-- Chosen -->
<script src="js/plugins/chosen/chosen.jquery.js"></script>


<!-- Script para exportar a Excel -->
<!-- <script>
    $("button").click(function(){
        $("#historial_table").table2excel({
            // exclude CSS class
            exclude: ".noExl",
            name: "Sitios recurrentes",
            filename: "Sitios recurrentes"

        });
    });
</script> -->

<script>
    $(document).ready(function(){

        $('#loading-example-btn').click(function () {
            btn = $(this);
            simpleLoad(btn, true)

            // Ajax example
//                $.ajax().always(function () {
//                    simpleLoad($(this), false)
//                });

            simpleLoad(btn, false)
        });
    });

    $('#data_1 .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true,
        format: "yyyy-mm-dd"
    });

    (function ($) {
        $('.spinner .btn:first-of-type').on('click', function() {
            $('.spinner input').val( parseInt($('.spinner input').val(), 10) + 1);
        });
        $('.spinner .btn:last-of-type').on('click', function() {
            $('.spinner input').val( parseInt($('.spinner input').val(), 10) - 1);
        });
    })(jQuery);

    function validaCantidad(form)
    {
        if(form.cantidad.value <= 1)
        {
            alert("No puede indicar menos de 1 componente");
            form.cantidad.value = 1;
        }
    }

    function simpleLoad(btn, state) {
        if (state) {
            btn.children().addClass('fa-spin');
            btn.contents().last().replaceWith(" Loading");
        } else {
            setTimeout(function () {
                btn.children().removeClass('fa-spin');
                btn.contents().last().replaceWith(" Refresh");
            }, 2000);
        }
    }

    var config = {
        '.chosen-select'           : {},
        '.chosen-select-deselect'  : {allow_single_deselect:true},
        '.chosen-select-no-single' : {disable_search_threshold:10},
        '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
        '.chosen-select-width'     : {width:"95%"}
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }

</script>

<script>
    $(document).ready(function(){
        /* Init DataTables */
        var oTable = $('#historial_table').DataTable({
        "paging":   false,
        "ordering": false,
        "info": false,
        "filter": false,
        "scrollY": "550px",
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
