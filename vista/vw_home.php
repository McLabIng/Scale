<?php

class vw_home {

    public static function lista_nacional($lista_alarmas){
        ?>
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Listado por regiones</h5>
            </div>
            <div class="ibox-content">
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                        <tr>
                            <th style="text-align: center">Región</th>
                            <th style="text-align: right">Sitios</th>
                            <th style="text-align: right">Alarmas</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $i = 1;
                        foreach($lista_alarmas as $resultados):

                            if ($resultados["alarmas"]>0) {
                                $text = 'class="text-danger"';
                            }
                            else {
                                $text = "";
                            }
                            
                            echo ' <tr>';
                            echo ' <td style="text-align: center">'.$resultados["region"].'</td>';
                            echo ' <td style="text-align: right">'.$resultados["sitios"].'</td>';
                            echo ' <td style="text-align: right" '.$text.'>'.$resultados["alarmas"].'</td>';
                            echo ' <td style="text-align: center"><a class="btn btn-success btn-outline btn-xs" href="?mod=alarmas_region&region='.$resultados['cod_region'].'"><i class="fa fa-search"></i>&nbsp;Ver</a></td>';
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

    public static function lista_top_recurrentes($cantidad){
        $lista_top_recurrentes = vm_grafico_alarmas::traer_top_alarmas_recurrentes($cantidad);
        ?>
        <div class="ibox-content">
            <div class="table-responsive">
                <table class="table table-hover table-striped" id="editable" data-sort="false">
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
                        echo ' <td class="col-sm-2"><a data-toggle="modal" href="#sitio'.$resultados['ID'].'" >'.$resultados["NOMBRE"].'</a></td>';
                        echo ' <td class="col-sm-1 text-danger" style="text-align: center">'.$resultados["cantidad"].'</td>';
                        echo ' <td class="col-sm-7">'.$resultados["TEXTO"].'</td>';
                    endforeach;
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php
    }

    public static function lista_top_minimas($cantidad){
        $lista_top_minimas = vm_grafico_alarmas::traer_top_alarmas_minimas($cantidad);
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
            <a class="btn btn-warning btn-bitbucket btn-outline" href="?mod=tv">Vista TV &nbsp;
                <i class="fa fa-desktop"></i>
            </a>
        </div>
    <?php
    }

}