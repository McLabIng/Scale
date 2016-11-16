<?php

class vw_home {

    public static function lista_nacional($lista_alarmas){
        ?>
        <div class="ibox float-e-margins">
            <div class="ibox-title ui-widget-header blue-bg">
                <h4>Listado por regiones</h4>
            </div>
            <div class="ibox-content">
                <div class="table-responsive project-list">
                    <table class="table table-hover table-striped">
                        <thead>
                        <tr>
                            <th class="col-sm-3" style="text-align: center">Región</th>
                            <th class="col-sm-3" style="text-align: right">Sitios</th>
                            <th class="col-sm-3" style="text-align: right">Alarmas</th>
                            <th class="col-sm-3"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $i = 1;
                        foreach($lista_alarmas as $resultados):

                            if ($resultados["alarmas"]>0) {
                                $text = 'text-danger';
                            }
                            else {
                                $text = "";
                            }
                            
                            echo ' <tr>';
                            echo ' <td class="col-sm-3" style="text-align: center">'.$resultados["region"].'</td>';
                            echo ' <td class="col-sm-3" style="text-align: right">'.$resultados["sitios"].'</td>';
                            echo ' <td style="text-align: right" class="'.$text.' col-sm-3">'.$resultados["alarmas"].'</td>';
                            echo ' <td class="col-sm-3" style="text-align: center"><a class="btn btn-success btn-outline btn-xs" href="?mod=alarmas_region&region='.$resultados['cod_region'].'"><i class="fa fa-search"></i>&nbsp;Ver</a></td>';
                            echo ' </tr>';
                        endforeach;
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php
    }

    public static function lista_top_recurrentes(){
        $lista_top_recurrentes = vm_grafico_alarmas::traer_top_alarmas_recurrentes();
        $lista_sin_conexion = vm_grafico_alarmas::traer_sin_conexion();
        $cantidad_alarmados = count($lista_top_recurrentes);
        $cantidad_sin_conexion = count($lista_sin_conexion);
        ?>
        <div class="ibox-content">
            <div class="scroll_content">
                <div class="table-responsive project-list">
                    <table class="table table-hover" id="top_table" data-sort="false">
                        <thead>
                        <tr>
                            <th class="col-sm-1" style="text-align: center">Region</th>
                            <th class="col-sm-1">Sitio</th>
                            <th class="col-sm-2">Nombre</th>
                            <th class="col-sm-1" style="text-align: center">Cantidad</th>
                            <th class="col-sm-6">Alarma</th>
                            <th class="col-sm-1 text-center">Tecnología</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php
                        // foreach($lista_sin_conexion as $lista):
                        //     if ($lista['alarmado'] = 1) {
                        //     echo ' <tr>';
                        //     echo ' <td class="col-sm-1" style="text-align: center">'.$lista["REGION"].'</td>';
                        //     echo ' <td class="col-sm-1">'.$lista['cod_sitio'].'</td>';
                        //     echo ' <td class="col-sm-2"><a data-toggle="modal" href="" >'.$lista["NOMBRE"].'</a></td>';
                        //     echo ' <td class="col-sm-1 text-danger" style="text-align: center"><i class="fa fa-unlink text-danger"></td>';
                        //     echo ' <td class="col-sm-7">SITIO CAIDO</td>';
                        //     echo ' </tr>';
                        // }
                        // endforeach;
                        foreach($lista_top_recurrentes as $resultados):
                            echo ' <tr>';
                            echo ' <td class="col-sm-1" style="text-align: center">'.$resultados["REGION"].'</td>';
                            echo ' <td class="col-sm-1">'.$resultados['cod_sitio'].'</td>';
                            echo ' <td class="col-sm-2"><a data-toggle="modal" href="" >'.$resultados["NOMBRE"].'</a></td>';
                            echo ' <td class="col-sm-1 text-danger" style="text-align: center">'.$resultados["cantidad"].'</td>';
                            echo ' <td class="col-sm-7">'.$resultados["TEXTO"].'</td>';
                            echo ' <td class="col-sm-7 text-center">'.$resultados["tecnologia"].'</td>';
                        endforeach;
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="ibox-content">
            <p style="margin-bottom: -15px; margin-top: -8px"><?php if ($lista_sin_conexion['alarmado'] =! 0) { echo 'Total sitios caidos: '.$cantidad_sin_conexion.' - ';}?>Total sitios alarmados: <?php echo $cantidad_alarmados; ?></p>
        </div>
    <?php
    }

    public static function lista_top_minimas(){
        $lista_top_minimas = vm_grafico_alarmas::traer_top_alarmas_minimas();
        ?>
        <div class="ibox-content">
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                    <tr>
                        <th class="col-sm-1" style="text-align: center">Region</th>
                        <th class="col-sm-1">Sitio</th>
                        <th class="col-sm-2">Nombre</th>
                        <th class="col-sm-1" style="text-align: center">Cantidad</th>
                        <th class="col-sm-7">Alarma</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php
                    foreach($lista_top_minimas as $resultados):
                        echo ' <tr>';
                        echo ' <td class="col-sm-1" style="text-align: center">'.$resultados["REGION"].'</td>';
                        echo ' <td class="col-sm-1">'.$resultados['cod_sitio'].'</td>';
                        echo ' <td class="col-sm-2"><a data-toggle="modal" href="#sitio'.$resultados['ID'].'" >'.$resultados["NOMBRE"].'</a></td>';
                        echo ' <td class="col-sm-1 text-danger" style="text-align: center">'.$resultados["cantidad"].'</td>';
                        echo ' <td class="col-sm-7">'.$resultados["TEXTO"].'</td>';
                        echo ' </tr>';
                    endforeach;
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php
    }

    public static function conectar_oss(){
        ?>
        <div class="m-b-md">
            <a href="modulos/connect_oss.php" target="v" onclick="window.open(this.href, this.target, 'width=1200,height=1000'); return false" class="btn btn-warning pull-right">Conectar a OSS</a>
        </div>
    <?php
    }

    public static function ver_lineas($linea){
        ?>
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Listado de lineas archivo</h5>
            </div>
            <div class="ibox-content">
                <p><?php echo $linea; ?></p>
            </div>
        </div>
    <?php
    }

    public static function botonera_tv(){
        ?>

        <div class="ibox float-e-margins">
            <a class="btn btn-md btn-warning btn-bitbucket" href="?mod=tv">Vista TV &nbsp;
                <i class="fa fa-desktop"></i>
            </a>
        </div>
    <?php
    }

    public static function alarmas_regiones($lista_alarmas,$alarmas_sin_conexion) {
        $alarmado[] = array();
        foreach ($alarmas_sin_conexion as $key) {
           $alarmado[] = $key['alarmados'];
        }
        ?>
        <div class="ibox-title ui-widget-header blue-bg p-xs m-b-n-sm">
            <h4 class="p-xxs">SITIOS ALARMADOS POR REGION</h4>
        </div>
        <div class="m-t-sm">

            <?php
            $i = 1;

            foreach ($lista_alarmas as $resultados):

                if ($resultados['alarmados'] == 0) {
                    $cantidad_sitios_caidos = '';
                    ### Condicional Colores Alarmas con sitios arriba ###
                    if ($resultados["alarmas"] >= 10) {
                        $background= 'coloralarm';
                        $font_color = '#fff';
                        $font_color_alarma = '#fff';
                    }
                    elseif ($resultados["alarmas"] > 0) {
                        $background = 'yellow-bg';
                        $font_color = '#fff';
                        $font_color_alarma = '#fff';
                    }
                    else {
                        $background = 'blue-bg';
                        $font_color = '#2664cc';
                        $font_color_alarma ='#676a6c';
                    }
                } else {
                    $cantidad_sitios_caidos = '<h4 class="pull-right" style="margin: -10px -5px -10px 0"><i class="fa fa-unlink"></i> '.$alarmado[$i].'</h4>';
                    ### Condicional Colores Alarmas con sitios abajo ###
                    if ($resultados["alarmas"] >= 10) {
                        $background= 'coloralarm-white';
                        $font_color = '#fff';
                        $font_color_alarma = '#fff';
                    }
                    elseif ($resultados["alarmas"] > 0) {
                        $background = 'yellow-white-bg';
                        $font_color = '#ffb70a';
                        $font_color_alarma = '#ffb70a';
                    }
                    else {
                        $background = 'blue-white-bg';
                        $font_color = '#1c84c6';
                        $font_color_alarma ='#1c84c6';
                    }
                }

                ### Condicional mejora nombre de Región ###
                if ($resultados["region"] == "RM") {
                    $region = "R.M.";
                }
                else {
                    $region = $resultados["region"]." Región";
                }

                ### CONTENIDO ###
                echo '  <div class="col-xs-4">
                        <a href="?mod=alarmas_region&region='.$resultados['cod_region'].'"><div class="ui-widget-content ui-state-hover ui-state-focus '.$background.' p-sm m-l-n m-r-n text-center">
                            <div class="row">
                                <div class="col-xs-12 text-center">
                                    <h3>'.$region.'</h3>
                                    <h1>'.$resultados["alarmas"].'</h1>
                                    '.$cantidad_sitios_caidos.'
                                </div>
                            </div>
                        </div></a>
                    </div>';
                    $i++;
            endforeach;
            ?>
        </div>
    <?php
    }

    public static function cantidad_alarmas_nacional(){
        $lista_top_recurrentes = vm_grafico_alarmas::traer_top_alarmas_recurrentes();
        $cantidad = count($lista_top_recurrentes);
        return $cantidad;
    }

    public static function estado_llamado_sitio($lista_nodos){
        ?>
        <!-- <div class="ibox-content col-md-12"> -->
            <div class="col-md-1 col-sm-2">
                <table class="table table-stripped small m-t-n m-b-xs m-l-n">
                    <tbody>
                        <?php
                        $i = 0;
                        foreach ($lista_nodos as $nodo) {

                            if ($nodo['online'] == 1) {
                                $boton_alerta = 'text-navy';
                            } else {
                                $boton_alerta = 'text-danger';
                            }

                            if ($i > 0 && $i % 1 == 0) {
                                echo '  </body>
                                    </table>
                                    </div>
                                    <div class="col-md-1 col-sm-2">
                                        <table class="table table-stripped small m-t-n m-b-xs m-l-n">
                                            <tbody>';
                            }

                            echo '  <tr>
                                        <td class="no-borders">
                                            <i class="fa fa-circle '.$boton_alerta.'"></i>
                                        </td>
                                        <td class="no-borders">
                                            '.$nodo['nodo'].'
                                        </td>
                                    </tr>
                                    ';
                            $i++;
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        <!-- </div> -->
        <?php
    }


}