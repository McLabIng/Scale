<?php
require_once 'modal/modal_informativo.php';
require_once 'clases/vm_grafico_alarmas.php';
require_once 'clases/region.php';

class vw_alarmas_region {

    public static function lista_regional($lista_alarmas){
        
        if (count($lista_alarmas)>15) {
            $id = 'id="editable"';
        }
        else {
            $id = "";
        }

        ?>

        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Listado por comunas</h5>
            </div>
            <div class="ibox-content">
                <div class="table-responsive">
                    <table class="table table-hover table-striped" <?php echo $id; ?> >
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

                                if ($resultados["alarmas"]>0) {
                                    $text = 'class="text-danger"';
                                }
                                else {
                                    $text = '';
                                }

                                echo ' <tr>';
                                echo ' <td>'.$resultados["comuna"].'</td>';
                                echo ' <td style="text-align: center">'.$resultados["sitios"].'</td>';
                                echo ' <td style="text-align: center" '.$text.'>'.$resultados["alarmas"].'</td>';
                                echo ' <td style="text-align: center"><a class="btn btn-success btn-outline btn-xs"  href="?mod=alarmas_comuna&region='.$resultados['cod_region'].'&comuna='.$resultados['comuna'].'"><i class="fa fa-search"></i>&nbsp;Ver</a></td>';
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

}