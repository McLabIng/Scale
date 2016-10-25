<?php
session_start();
require_once 'clases/usuario.php';
require_once 'clases/region.php';
require_once 'vista/vw_home.php';
require_once 'clases/vm_grafico_alarmas.php';
require_once 'vista/vw_alarmas_region.php';
require_once 'vista/modal/modal_informativo.php';

$Fecha=getdate();
$Anio=$Fecha["year"];

$cod_region = $_GET['region'];
$mi_region = region::traer_region($cod_region);

$mi_usuario = cl_usuario::traer_usuario($_SESSION["username"]);
$mi_area = $mi_usuario->getCod_area();
$mi_rol = $mi_usuario->getCod_rol();

$alarmas = vm_grafico_alarmas::traer_alarmas_region($cod_region);
foreach($alarmas as $rows):
    $data_alarmas[] = array($rows['comuna'],$rows['sitios'],$rows['alarmas']);
endforeach;

$alarmas_mapa = vm_grafico_alarmas::traer_alarmas_region_mapa($cod_region);
foreach($alarmas_mapa as $rows):
    $string = str_replace(' ', '-', $rows['nombre']); // Replaces all spaces with hyphens.
    $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    $nombre = preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.

    $data_alarmas_mapa[] = array($nombre ,$rows['CELDAS_ALARMADAS'], $rows['lat_google'], $rows['lon_google'], $rows['id'], $rows['tipo_nodo']);
endforeach;

$centro_mapa = vm_grafico_alarmas::traer_centro_mapa_region($cod_region);
foreach ($centro_mapa as $rows_centro):
    $lat = $rows_centro['latitud_centro'];
    $lon = $rows_centro['longitud_centro'];
    $zoom = $rows_centro['zoom'];
endforeach;

// Condicional mejora nombre de Región
if ($mi_region->getRegion() == "RM") {
    $region = 'Región Metropolitana';
}
else {
$region = $mi_region->getRegion()." Región";
}

?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2 class="pull-right">Sub Gerencia O&M Infraestructura</h2>
        <h2>Alarma eléctrica a nivel regional - <?php echo $region; ?>
        <div class="pull-right">
        <?php
        // Vista de tabla por regiones
        // vw_home::botonera_tv();
        ?>
        </div></h2>
        <ol class="breadcrumb">

            <?php
            // Vista de todas las regiones
            vw_alarmas_region::lista_regiones($lista);
            ?> 

        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInDown">
    <div class="row">

        <div class="col-md-4 m-t-n">
            <?php
            // Vista de tabla por regiones
            vw_alarmas_region::lista_regional($alarmas);
            ?>
        </div>

        <!-- Mapa -->
        <div class="col-md-8 hidden-sm m-t-n">
            <div class="ibox float-e-margins animated fadeInDown">
                <div class="ibox-title ui-widget-header blue-bg">
                    <h4 class="p-xxs">Alarmas electricas de la <?php echo $region; ?></h4>
                </div>
                <div class="ibox-content" style="height: 654px">
                    <div class="google-map" id="mapa"></div>
                </div>
            </div>
        </div>

        <div class="col-md-12 hidden-xs m-t-n m-b-sm">
            <div class="ibox float-e-margins">
                <div class="ibox-title col-md-12 ui-widget-header blue-bg">
                    <button class="pull-right btn btn-md btn-primary"><i class="fa fa-file-excel-o"></i></button>
                    <h4 class="p-xxs">Sitios Alarmados Ultima hora</h4>
                </div>
                <?php
                    vw_alarmas_region::lista_top_recurrentes($cod_region);
                ?>
            </div>
        </div>

        <!-- <div class="col-md-12 hidden-sm">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h4>Alarmas eléctricas por comuna</h4>
                </div>
                <div class="ibox-content">
                    <div style="text-align: center">
                        <p class="label label-plain">Sitios</p>
                        <p class="label label-danger">Alarmas</p>
                    </div>
                    <div>
                        <canvas class="center-block" id="barChart" height="50"></canvas>
                    </div>
                </div>
            </div>
        </div> --> 

    </div>

</div>

<!-- Mainly scripts -->
<script src="js/jquery-2.1.1.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<script src="https://maps.google.com/maps/api/js?sensor=false"></script>

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


<!-- Exportar Excel -->
<script src="js/plugins/excel/jquery.table2excel.js"></script>

<!-- Script para exportar a Excel -->
<script>
    $("button").click(function(){
        $("#region_table").table2excel({
            // exclude CSS class
            exclude: ".noExl",
            name: "Alarmas Región",
            filename: "Alarmas_Region"

        });
    });

    $("button").click(function(){
        $("#region_table_hours").table2excel({
            // exclude CSS class
            exclude: ".noExl",
            name: "Alarmas Región",
            filename: "Alarmas_Region"

        });
    });
</script>

<script>
    $(document).ready(function () {
        $('.scroll_content').slimscroll({
            height: '617px',
            opacity: 0.1,
            wheelStep : 10,
        })
    });

    $(document).ready(function () {
        $('.scroll_content_2').slimscroll({
            height: '617px',
            opacity: 0.1,
            wheelStep : 10,
        })
    });
</script>

<!-- <script>
    var barData = {
        labels: [
            <?php
            // $i=0;
            //     foreach($data_alarmas as $datos){ $i++;
            
            // echo "'$datos[0]'";
            
                // if(count($data_alarmas) == $i-1){
            
            // echo "'$datos[0]'";
            
                // }}
            ?>
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
                    // $i=0;
                    // foreach($data_alarmas as $datos)
                    // {
                    //     $i++;
                    //     echo $datos[1];

                    //     if(count($data_alarmas) == $i-1){
                    //         echo $datos[1];
                    //     }
                    // }
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
                    // $i=0;
                    // foreach($data_alarmas as $datos)
                    // {
                    //     $i++;
                    //     echo $datos[2]; 
                    //     if(count($data_alarmas) == $i-1){
                    //         echo $datos[2];
                    //     }
                    // }
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
        barDatasetSpacing: -10,
        responsive: true,
    }


    var ctx = document.getElementById("barChart").getContext("2d");
    var myNewChart = new Chart(ctx).Bar(barData, barOptions);
</script> -->



<script type="text/javascript">
    // When the window has finished loading google map
    google.maps.event.addDomListener(window, 'load', init);

    function init() {

        var sitios = [
            <?php $i=0;
                foreach($data_alarmas_mapa as $datos){ $i++;
            ?> {title: <?php echo "'$datos[0]'"; ?> , pin: <?php if ($datos[5] == 1 && $datos[1] >= 1){
                $pin = 'pink-dot';
            }
            else if ($datos[5] == 1 && $datos[1] < 1) {
                $pin = 'blue-dot';
             }
             else if ($datos[5] <> 1 && $datos[1] >= 1) {
                $pin = 'red-dot';
             }
             else {
                $pin = 'green-dot';
             }
             echo "'$pin'"; ?> , lat:<?php echo $datos[2]; ?> , lng:<?php echo $datos[3]; ?> , sigla:<?php echo "'$datos[4]'"; ?>},
            <?php
                if(count($data_alarmas_mapa) == $i-1){
                ?> {title:<?php echo " '$datos[0]'";?> , pin:
                <?php if ($datos[1] > 0){
                    $pin = 'red-dot';
                }
                 else {
                    $pin = 'green-dot';
                 }
                 echo "'$pin'"; ?> , lat:<?php echo $datos[2]; ?> , lng:<?php echo $datos[3]; ?>, sigla:<?php echo "'$datos[4]'"; ?>
            <?php
            }
            }
            ?>
        ];

        // Options for Google map
        // More info see: https://developers.google.com/maps/documentation/javascript/reference#MapOptions
        var mapOptions0 = {
            zoom: <?php echo $zoom; ?>,
            center: new google.maps.LatLng(<?php echo $lat; ?>, <?php echo $lon; ?>),
            // Style for Google Maps
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        var mapOptions1 = {
            zoom: <?php echo $zoom; ?>,
            center: new google.maps.LatLng(<?php echo $lat; ?>, <?php echo $lon; ?>),
            // Style for Google Maps
            styles: [{"featureType":"water","stylers":[{"saturation":43},{"lightness":-11},{"hue":"#0088ff"}]},{"featureType":"road","elementType":"geometry.fill","stylers":[{"hue":"#ff0000"},{"saturation":-100},{"lightness":99}]},{"featureType":"road","elementType":"geometry.stroke","stylers":[{"color":"#808080"},{"lightness":54}]},{"featureType":"landscape.man_made","elementType":"geometry.fill","stylers":[{"color":"#ece2d9"}]},{"featureType":"poi.park","elementType":"geometry.fill","stylers":[{"color":"#ccdca1"}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"color":"#767676"}]},{"featureType":"road","elementType":"labels.text.stroke","stylers":[{"color":"#ffffff"}]},{"featureType":"poi","stylers":[{"visibility":"off"}]},{"featureType":"landscape.natural","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"color":"#b8cb93"}]},{"featureType":"poi.park","stylers":[{"visibility":"on"}]},{"featureType":"poi.sports_complex","stylers":[{"visibility":"on"}]},{"featureType":"poi.medical","stylers":[{"visibility":"on"}]},{"featureType":"poi.business","stylers":[{"visibility":"simplified"}]}]
        };

        var mapOptions2 = {
            zoom: <?php echo $zoom; ?>,
            center: new google.maps.LatLng(<?php echo $lat; ?>, <?php echo $lon; ?>),
            // Style for Google Maps
            styles: [{"featureType":"all","elementType":"all","stylers":[{"invert_lightness":true},{"saturation":10},{"lightness":30},{"gamma":0.5},{"hue":"#435158"}]}]
        };

        var mapOptions3 = {
            center: new google.maps.LatLng(<?php echo $lat; ?>, <?php echo $lon; ?>),
            zoom: <?php echo $zoom; ?>,
            mapTypeId: google.maps.MapTypeId.SATELLITE,
            // Style for Google Maps
            styles: [{"featureType":"road","elementType":"geometry","stylers":[{"visibility":"off"}]},{"featureType":"poi","elementType":"geometry","stylers":[{"visibility":"off"}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#fffffa"}]},{"featureType":"water","stylers":[{"lightness":50}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"transit","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"geometry","stylers":[{"lightness":40}]}]
        };

        var mapOptions4 = {
            zoom: <?php echo $zoom; ?>,
            center: new google.maps.LatLng(<?php echo $lat; ?>, <?php echo $lon; ?>),
            // Style for Google Maps
            styles: [{"stylers":[{"hue":"#18a689"},{"visibility":"on"},{"invert_lightness":true},{"saturation":40},{"lightness":10}]}]
        };

        var fenway = new google.maps.LatLng(<?php echo $lat; ?>, <?php echo $lon; ?>);
        var mapOptions5 = {
            zoom: <?php echo $zoom; ?>,
            center: fenway,
            // Style for Google Maps
            styles: [{featureType:"landscape",stylers:[{saturation:-100},{lightness:65},{visibility:"on"}]},{featureType:"poi",stylers:[{saturation:-100},{lightness:51},{visibility:"simplified"}]},{featureType:"road.highway",stylers:[{saturation:-100},{visibility:"simplified"}]},{featureType:"road.arterial",stylers:[{saturation:-100},{lightness:30},{visibility:"on"}]},{featureType:"road.local",stylers:[{saturation:-100},{lightness:40},{visibility:"on"}]},{featureType:"transit",stylers:[{saturation:-100},{visibility:"simplified"}]},{featureType:"administrative.province",stylers:[{visibility:"off"}]/**/},{featureType:"administrative.locality",stylers:[{visibility:"off"}]},{featureType:"administrative.neighborhood",stylers:[{visibility:"on"}]/**/},{featureType:"water",elementType:"labels",stylers:[{visibility:"on"},{lightness:-25},{saturation:-100}]},{featureType:"water",elementType:"geometry",stylers:[{hue:"#ffff00"},{lightness:-25},{saturation:-97}]}]
        };

        var panoramaOptions = {
            position: fenway,
            pov: {
                heading: 10,
                pitch: 10
            }
        };
        var panorama = new google.maps.StreetViewPanorama(document.getElementById('pano'), panoramaOptions);

        // Get all html elements for map
        var mapElement1 = document.getElementById('mapa');

        // Create the Google Map using elements
        var mapa = new google.maps.Map(mapElement1, mapOptions0);

        // instancia unos nuevos marcadores ( chinchetas )
        var marcador, pin;

        var url = "http:\/\/maps.google.com/mapfiles/ms/micons/";
        for( var i = 0; i < sitios.length; i++){
            pin = url + sitios[i].pin + ".png";
            marcador = new google.maps.Marker({
                position: new google.maps.LatLng(sitios[i].lat, sitios[i].lng),
                map: mapa,
                title: sitios[i].title,
                icon: pin
            });
            (function(marker,i){
                google.maps.event.addListener(marker, 'click', function(){
                    $('#sitio'+sitios[i].sigla).modal('show');
                });
            }(marcador,i));
        }
    }
</script>

<!-- Page-Level Scripts -->
<script>
    $(document).ready(function(){
        $('.region_table_hours').DataTable({
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [
            {extend: 'print',

                customize: function (win){
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');
                    $(win.document.body).find('table')
                    .addClass('compact')
                    .css('font-size', 'inherit');
                }
            }
            ]
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



<!-- Page-Level Scripts -->
    <!--script>
        $(document).ready(function() {

            $('.footable').footable();
            $('.footable2').footable();

        });

    </script-->


<!-- <style>
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
</style> -->