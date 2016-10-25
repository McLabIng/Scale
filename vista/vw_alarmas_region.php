<?php
require_once 'modal/modal_informativo.php';
require_once 'clases/vm_grafico_alarmas.php';
require_once 'clases/region.php';

class vw_alarmas_region {

    public static function lista_regional($lista_alarmas){
        
        // if (count($lista_alarmas)>15) {
        //     $id = 'id="editable"';
        // }
        // else {
        //     $id = "";
        // }

        ?>

        <div class="ibox float-e-margins">
            <div class="ibox-title col-md-12 ui-widget-header blue-bg">
                <button class="pull-right btn btn-md btn-primary"><i class="fa fa-file-excel-o"></i></button>
                <h4 class="p-xxs">Listado por comunas</h4>
            </div>
            <div class="ibox-content">
                <div class="scroll_content">
                    <div class="table-responsive project-list">
                        <table class="table table-hover" id="region_table" data-sort="false">
                            <thead>
                                <tr>
                                    <th>Comuna</th>
                                    <th style="text-align: center">Sitios</th>
                                    <th style="text-align: center">Alarmas</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach($lista_alarmas as $resultados):

                                    if ($resultados["alarmados"] == 0) {
                                        $button_color = 'btn-success';
                                        $fa = 'fa-search';
                                        if ($resultados["alarmas"]>0) {
                                            $text = 'class="text-danger"';
                                        } else {
                                            $text = '';
                                        }
                                    }
                                    else {
                                        $button_color = 'btn-danger';
                                        $fa = 'fa-unlink';
                                        if ($resultados["alarmas"]>0) {
                                            $text = 'class="text-danger"';
                                        } else {
                                            $text = '';
                                        }
                                    }

                                    echo ' <tr>';
                                    echo ' <td>'.$resultados["comuna"].'</td>';
                                    echo ' <td style="text-align: center">'.$resultados["sitios"].'</td>';
                                    echo ' <td style="text-align: center" '.$text.'>'.$resultados["alarmas"].'</td>';
                                    echo ' <td style="text-align: center"><a class="btn '.$button_color.' btn-outline btn-xs"  href="?mod=alarmas_comuna&region='.$resultados['cod_region'].'&comuna='.$resultados['comuna'].'"><i class="fa '.$fa.'"></i>&nbsp;Ver</a></td>';
                                    echo ' </tr>';
                                    endforeach;
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php
    }

    public static function lista_regiones($lista_alarmas){

        $cod_region = $_GET['region'];
        $mi_region = region::traer_region($cod_region);

        $lista_regiones = region::traer_regiones();

        // Condicional mejora nombre de Región    
        if ($mi_region->getRegion() == "RM") {
            $region = "Región Metropolitana ";
        }
        else {
            $region = $mi_region->getRegion()." Región ";
        }
        
        ?>

        <li>
            <a href="javascript:history.back()">Alarmas</a>
        </li>

        <li class="btn-group active">
            <label data-toggle="dropdown"><strong><?php echo $region; ?></strong><span class="caret"></span></label>
            <ul class="dropdown-menu">

                <?php
                
                foreach($lista_regiones as $resultados):

                    echo '<li><a href="?mod=alarmas_region&region='.$resultados['cod_region'].'">'.$resultados["region"].'</a></li>';

                endforeach;
                ?>

            </ul>
        </li>

        <?php
    }

    public static function lista_top_recurrentes($cod_region){
        $lista_top_recurrentes = vm_grafico_alarmas::traer_top_alarmas_recurrentes_region($cod_region);
        $lista_sin_conexion = vm_grafico_alarmas::traer_sin_conexion();
        $cantidad_alarmados = count($lista_top_recurrentes);
        $cantidad_sin_conexion = count($lista_sin_conexion);
        ?>
        <div class="ibox-content">
            <div class="scroll_content_2">
                <div class="table-responsive project-list">
                    <table class="table table-hover" id="region_table_hours" data-sort="false">
                        <thead>
                        <tr>
                            <th class="col-sm-1 text-center">Sitio</th>
                            <th class="col-sm-2">Nombre</th>
                            <th class="col-sm-1">Comuna</th>
                            <th class="col-sm-1 text-center">Cantidad</th>
                            <th class="col-sm-2">Fecha</th>
                            <th class="col-sm-4">Alarma</th>
                            <th class="col-sm-1 text-center">Estado</th>
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

                            if ($resultados["ESTADO"] == 0) {
                                $boton = 'text-navy';
                            } else {
                                $boton = 'text-danger';
                            }

                            echo ' <tr>';
                            echo ' <td class="col-sm-1 text-center">'.$resultados['cod_sitio'].'</td>';
                            echo ' <td class="col-sm-2"><a data-toggle="modal" href="" >'.$resultados["NOMBRE"].'</a></td>';
                            echo ' <td class="col-sm-1">'.$resultados["COMUNA"].'</td>';
                            echo ' <td class="col-sm-1 text-danger" style="text-align: center">'.$resultados["cantidad"].'</td>';
                            echo ' <td class="col-sm-2">'.$resultados["INICIO"].'</td>';
                            echo ' <td class="col-sm-4">'.$resultados["TEXTO"].'</td>';
                            echo ' <td class="col-sm-1 text-center"><i class="fa fa-circle '.$boton.'"></i></td>';
                            echo ' <td class="col-sm-1 text-center">'.$resultados["tecnologia"].'</td>';
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

}