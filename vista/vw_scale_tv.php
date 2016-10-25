<?php

class vw_scale_tv {

    public static function alarmas_regiones($lista_alarmas,$alarmas_sin_conexion) {
        $alarmado[] = array();
        foreach ($alarmas_sin_conexion as $key) {
           $alarmado[] = $key['alarmados'];
        }
        ?>
        <div class="ui-widget-header blue-bg p-xs m-b-n-sm">
            <h3 class="p-xs">SITIOS ALARMADOS POR REGION</h3>
        </div>
        <div class="m-t-sm">

            <?php
            $i=1;

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
                echo '  <div class="col-sm-4">
						<a href="?mod=alarmas_region&region='.$resultados['cod_region'].'"><div class="ui-widget-content ui-state-hover ui-state-focus '.$background.' p-sm m-l-n m-r-n text-center">
							<div class="row">
								<div class="col-xs-12 text-center boton-alarmas">
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

    public static function lista_top_recurrentes() {
        $lista_top_recurrentes = vm_grafico_alarmas::traer_top_alarmas_recurrentes();
        $lista_sin_conexion = vm_grafico_alarmas::traer_sin_conexion();
        ?>
        <div class="ui-widget-header blue-bg p-xs">
            <h3 class="p-xs">TOP SITIOS CON ALARMAS RECURRENTES</h3>
        </div>

        <div class="ui-widget-content white-bg p-lg">
            <div id="contain" class="table-responsive project-list m-t-n m-b-n-m">
                <table class="table table-hover" id="editable" border="0">
                    <thead>
                    <tr>
                        <th class="col-sm-1" style="text-align: center">Region</th>
                        <th class="col-sm-5">Nombre</th>
                        <th class="col-sm-5">Alarma</th>
                        <th class="col-sm-1" style="text-align: center">Cantidad</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php
                    // foreach($lista_sin_conexion as $lista):
                    //     if ($lista['alarmado'] = 1) {
                    //     echo '  <tr>
                    //                 <td class="col-sm-1" style="text-align: center"><h4>'.$lista["REGION"].'</h4></td>
                    //                 <td class="col-sm-5"><h4><a>'.$lista["NOMBRE"].'</a></h4><h5>'.$lista['cod_sitio'].'</h5></td>
                    //                 <td class="col-sm-5">SITIO CAIDO</td>
                    //                 <td class="col-sm-1 text-danger" style="text-align: center"><h3><i class="fa fa-unlink text-danger"></h3></td>
                    //             </tr>';
                    // }
                    // endforeach;
                    foreach($lista_top_recurrentes as $resultados):
                        echo '	<tr>
                                    <td class="col-sm-1" style="text-align: center"><h4>'.$resultados["REGION"].'</h4></td>
                                    <td class="col-sm-5"><h4><a>'.$resultados["NOMBRE"].'</a></h4><h5>'.$resultados['cod_sitio'].'</h5></td>
                                    <td class="col-sm-5">'.$resultados["TEXTO"].'</td>
                                    <td class="col-sm-1 text-danger" style="text-align: center"><h3>'.$resultados["cantidad"].'</h3></td>
                                </tr>';
                    endforeach;
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php

    }

    public static function estado_llamado_sitio($lista_nodos){
        ?>
        <!-- <div class="ibox-content col-md-12"> -->
            <div class="col-md-1">
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
                                    <div class="col-md-1">
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