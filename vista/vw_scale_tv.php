<?php

class vw_scale_tv {

    public static function alarmas_regiones($lista_alarmas) {
        ?>
        <div class="ui-widget-header blue-bg p-xs m-b-n-sm">
            <h3 class="p-xs">SITIOS ALARMADOS POR REGION</h3>
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
                echo '  <div class="col-sm-4 '.$neon.'">
						<a onclick="#"><div class="ui-widget-content ui-state-hover ui-state-focus '.$background.' p-sm m-l-n m-r-n text-center">
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

    public static function lista_top_recurrentes($cantidad) {
        $lista_top_recurrentes = vm_grafico_alarmas::traer_top_alarmas_recurrentes($cantidad);
        ?>
        <div class="ui-widget-header blue-bg p-xs">
            <h3 class="p-xs">TOP SITIOS CON ALARMAS RECURRENTES</h3>
        </div>

        <div class="ui-widget-content white-bg p-lg">
            <div class="table-responsive project-list m-t-n m-b-n-m">
                <table class="table table-hover" data-sort="false">
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
                    foreach($lista_top_recurrentes as $resultados):
                        echo '	<tr>';
                        echo '	<td class="col-sm-1" style="text-align: center"><h4>'.$resultados["REGION"].'</h4></td>';
                        echo '	<td class="col-sm-5"><h4><a>'.$resultados["NOMBRE"].'</a></h4><h5>'.$resultados['cod_sitio'].'</h5></td>';
                        echo '	<td class="col-sm-5">'.$resultados["TEXTO"].'</td>';
                        echo '	<td class="col-sm-1 text-danger" style="text-align: center"><h3>'.$resultados["cantidad"].'</h3></td>';
                        echo '	</tr>';
                    endforeach;
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php

    }

}