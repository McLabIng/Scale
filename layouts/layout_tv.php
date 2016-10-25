<?php
session_start();
date_default_timezone_set('America/Santiago');
require_once 'clases/usuario.php';
require_once 'clases/area.php';
require_once 'clases/datos_empresa.php';
?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta http-equiv="refresh" content="180"> 

    <title>SCALE TV - Sistema de Conocimiento de Alarmas Eléctricas.</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Favicon -->
    <link rel="shortcut icon" href="img/favicon.ico">

    <!-- Mapa -->
    <link rel="stylesheet" href="js/plugins/ammap/ammap.css" type="text/css" media="all">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body class="skin-1 mini-navbar">

    <div id="wrapper"><!-- DIV PRINCIPAL -->


        <!-- ######## BARRA LATERAL ######## -->
        <?php

        if  (isset($_SESSION["username"])){
            $username = $_SESSION["username"];
            $usuario = cl_usuario::traer_usuario($username);
            $cod_area = $usuario->getCod_area();
            $area = area::traer_area($cod_area);
            $datos_empresa = datos_empresa::traer_mi_empresa();
            
            if ($usuario) {
                echo '  <nav class="navbar-default navbar-static-side" role="navigation">
                            <div class="sidebar-collapse">
                                <ul class="nav" id="side-menu">
                                    <li class="nav-header">
                                        <div class="logo-element">
                                            <img alt="image" class="img-container" src="'.$datos_empresa->getURL_logo().'" />
                                        </div>
                                    </li>
                                    <li>
                                        <a href="?mod=home"><i class="fa fa-home"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </nav>';
            }
        }
        ?>


        <div id="page-wrapper" class="black-bg">

            <!-- ######## BARRA SUPERIOR ######## -->
            <!--div class="row border-bottom">
                <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary" href="#"><i class="fa fa-bars"></i> </a>
                    </div>
                    <ul class="nav navbar-top-links navbar-right">
                        <li>
                            <span class="m-r-sm text-muted welcome-message">Bienvenido a SCALE</span>
                        </li>
                        <li>
                            <a href="?mod=logout">
                                <p><i class="fa fa-sign-out"></i> Log out</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div-->



            <!-- ######## BARRA TITULO + CONTENIDO ######## -->
            <?php
            if (file_exists( $path_modulo )) include( $path_modulo );
            else die('Error al cargar el módulo <b>'.$modulo.'</b>. No existe el archivo <b>'.$conf[$modulo]['archivo'].'</b>');
            ?>



            <!-- ######## BARRA INFERIOR ######## -->
            <div class="footer fixed">
                <div class="col-md-6">
                    <strong>Copyright</strong> McLab Ingenieria SpA&copy; 2015-2016
                    <a href="http://www.mclab.cl" target="blank"><img alt="image" class="img-container pull-right" src="img/logo-mclabSPA.png" style="width: 100px"/></a>
                </div>
            </div>

        </div>
    </div><!-- DIV PRINCIPAL -->


</body>
</html>