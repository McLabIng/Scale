<?php
require_once 'modal/modal_informativo.php';
require_once 'clases/vm_grafico_alarmas.php';

class vw_alarmas_comuna {

    public static function lista_comunal($lista_alarmas, $cod_region, $comuna){
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
                <h4 class="p-xxs">Listado por sitios</h4>
            </div>
            <div class="ibox-content">
                <div class="scroll_content">
                    <div class="table-responsive project-list">
                        <table class="table table-hover" id="comuna_table" data-sort="false">
                            <thead>
                                <tr>
                                    <th>Sigla</th>
                                    <th>Nombre</th>
                                    <th style="text-align: center">Estado</th>
                                    <th style="text-align: center">Red</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                foreach($lista_alarmas as $resultados):
                                    modal_informativo::ver_sitio($cod_region, $comuna, $resultados["id"]);

                                if ($resultados['CELDAS_ALARMADAS']<>0) {
                                    $bell = 'text-danger fa fa-bell';
                                }
                                else {
                                    $bell = 'text-info fa fa-check';
                                }

                                echo ' <tr>';
                                echo ' <td>'.$resultados["cod_pop"].'</td>';
                                echo ' <td><a data-toggle="modal" href="#sitio'.$resultados['id'].'">'.$resultados["nombre"].'</a></td>';
                                echo ' <td class="" style="text-align: center; color: rgba(0,0,0,0)"><a class="hide">'.$resultados["CELDAS_ALARMADAS"].'</a><i class="'.$bell.'"></i></td>';
                                if ($resultados['tipo_nodo']==1){
                                    echo ' <td style="text-align: center"><a data-toggle="modal" href="#sitio'.$resultados['id'].'"><label class="label label-success">Mínima</label></a></td>';
                                }
                                else {
                                    echo ' <td style="text-align: center"><a data-toggle="modal" href="#sitio'.$resultados['id'].'"><label class="label label-default">Normal</label></a></td>';
                                }

                                echo ' </tr>';
                                endforeach;
                            ?>
                            </tbody>


                        </table>
                        <!--ol class="text-center breadcrumb">
                            <li><i class="text-info fa fa-check"></i>&nbsp;&nbsp;En Linea</li>
                            <li><i class="text-danger fa fa-bell"></i>&nbsp;&nbsp;Sitio Alarmado</li>
                        </ol-->
                    </div>
                </div>
            </div>
        </div>
    <?php
    }

    public static function lista_comunas($lista_alarmas){

        $cod_region = $_GET['region'];
        $mi_region = region::traer_region($cod_region);
        $comuna = $_GET['comuna'];

        // Condicional mejora nombre de Región
        if ($mi_region->getRegion() == "RM") {
            $region = 'Región Metropolitana';
        }
        else {
            $region = $mi_region->getRegion()." Región";
        }

        ?>

        <li>
            <a href="javascript:history.go(-2)">Alarmas</a>
        </li>

        <li class="active">
            <a href="javascript:history.back()"><?php echo $region; ?></a>
        </li>

        <li class="btn-group active">
            <label data-toggle="dropdown"><strong><?php echo $comuna; ?> </strong><span class="caret"></span></label>
            <ul class="dropdown-menu">

                <?php
                foreach($lista_alarmas as $resultados):

                    echo '<li><a href="?mod=alarmas_comuna&region='.$resultados['cod_region'].'&comuna='.$resultados['comuna'].'">'.$resultados["comuna"].'</a></li>';

                endforeach;
                ?>

            </ul>
        </li>

        <?php
    }

}