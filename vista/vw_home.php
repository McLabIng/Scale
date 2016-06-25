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
        $cantidad = count($lista_top_recurrentes);
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
                            <th class="col-sm-7">Alarma</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php
                        foreach($lista_top_recurrentes as $resultados):
                            echo ' <tr>';
                            echo ' <td class="col-sm-1" style="text-align: center">'.$resultados["REGION"].'</td>';
                            echo ' <td class="col-sm-1">'.$resultados['cod_sitio'].'</td>';
                            echo ' <td class="col-sm-2"><a data-toggle="modal" href="" >'.$resultados["NOMBRE"].'</a></td>';
                            echo ' <td class="col-sm-1 text-danger" style="text-align: center">'.$resultados["cantidad"].'</td>';
                            echo ' <td class="col-sm-7">'.$resultados["TEXTO"].'</td>';
                        endforeach;
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="ibox-content">
            <p style="margin-bottom: -15px; margin-top: -8px">Total sitios alarmados: (<?php echo $cantidad; ?>)</p>
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

    public static function alarmas_regiones($lista_alarmas) {
        ?>
        <div class="ibox-title ui-widget-header blue-bg p-xs m-b-n-sm">
            <h4 class="p-xxs">SITIOS ALARMADOS POR REGION</h4>
        </div>
        <div class="m-t-sm">

            <?php

            foreach ($lista_alarmas as $resultados):

                ### Condicional Colores Alarmas ###
                if ($resultados["alarmas"] >= 10) {
                    $background= 'coloralarm';
                    $font_color = '#fff';
                    $font_color_alarma = '#fff';
                    $icon = 'fa-bell';
                }
                elseif ($resultados["alarmas"] > 0) {
                    $background = 'yellow-bg';
                    $font_color = '#fff';
                    $font_color_alarma = '#fff';
                    $icon = 'fa-bell';
                }
                else {
                    $background = 'blue-bg';
                    $font_color = '#2664cc';
                    $font_color_alarma ='#676a6c';
                    $icon = 'fa-thumbs-o-up';
                }

                ### Condicional mejora nombre de Región ###
                if ($resultados["region"] == "RM") {
                    $region = "R.M.";
                }
                else {
                    $region = $resultados["region"]." Región";
                }

                ### CONTENIDO ###
                echo '  <div class="col-sm-4">
                        <a href="?mod=alarmas_region&region='.$resultados['cod_region'].'"><div class="ui-widget-content ui-state-hover ui-state-focus '.$background.' p-sm m-l-n m-r-n text-center">
                            <div class="row">
                                <div class="col-xs-12 text-center">
                                    <h3>'.$region.'</h3>
                                    <h1>'.$resultados["alarmas"].'</h1>
                                </div>
                            </div>
                        </div></a>
                    </div>';
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


}