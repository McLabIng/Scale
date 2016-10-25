<?php

class vw_historial {

    public static function busqueda_historial(array $listado_sitios){
        ?>
        <div class="ibox-content">
            <div class="row">
                <form role="form" method="post" action="" class="form-horizontal" name="form_busqueda_historial">
                    
                    <div class="form-group col-sm-5" style="margin-left: 20px" >
                        <label class="control-label" for="sitio">Sitio: </label>
                        <div class="input-group col-xs-9">
                            <select data-placeholder="Elegir sitio..." class="chosen-select" tabindex="4" name="sitio" required="">
                                <option value="">Seleccionar</option>
                                <?php
                                foreach($listado_sitios as $resultados):
                                    echo '<option value="'.$resultados['SITIO'].'">'.$resultados['nombre_sitio'].'</option>';
                                endforeach;
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group col-sm-3" id="data_1">
                        <label class="control-label" for="fecha_desde">Desde: </label>
                        <div class="col-xs-9 input-group date"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            <input type="text" class="form-control" id="fecha_desde" name="fecha_desde" required="">
                        </div>
                    </div>
                    <div class="form-group col-sm-3" id="data_1">
                        <label class="control-label" for="fecha_hasta">Hasta: </label>
                        <div class="col-xs-9 input-group date"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            <input type="text" class="form-control" id="fecha_hasta" name="fecha_hasta" required="">
                        </div>
                    </div>
                    <br>
                    <div class="form-group col-sm-1 pull-right">
                        <input type="hidden" name="accion" value="buscar_historial">
                        <input type="submit" class="btn btn-primary" value="Buscar">
                    </div>
                    <?php
                    $accion = $_POST['accion'];
                    if($accion == "buscar_historial") {
                        $fecha_desde = $_POST['fecha_desde'];
                        $fecha_hasta = $_POST['fecha_hasta'];
                        $sitios = $_POST['sitio'];
                        $listado_historial = vm_grafico_alarmas::traer_historial($sitios, $fecha_desde, $fecha_hasta);
                        $count_historial = count($listado_historial);
                    }
                    ?>
                </form>
            </div>
            
            <div class="row">
                <div class="scroll_content">
                    <div class="table-responsive project-list">
                        <table class="table table-hover" id="historial_table">
                            <thead>
                            <tr>
                                <th class="col-sm-1" style="text-align: center">Region</th>
                                <th class="col-sm-1">Comuna</th>
                                <th class="col-sm-1" style="text-align: center">Sitio</th>
                                <th class="col-sm-2">Nombre</th>
                                <th class="col-sm-1">Fecha Inicio</th>
                                <th class="col-sm-5">Texto</th>
                                <th class="col-sm-1" style="text-align: center">Tipo</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php
                            $lista_historial = vm_grafico_alarmas::traer_historial($sitios, $fecha_desde, $fecha_hasta);
                            foreach($lista_historial as $resultados):
                                $date = strtotime($resultados['INICIO']);
                                $fecha = date("Y-m-d H:i", $date);

                                ### Condicional mejora nombre de Región ###
                                if ($resultados['REGION'] == "RM") {
                                    $region = "R.M.";
                                }
                                else {
                                    $region = $resultados['REGION']." Región";
                                }
                                echo ' <tr>';
                                echo ' <td class="col-sm-1" style="text-align: center">'.$resultados['REGION'].'</td>';
                                echo ' <td class="col-sm-1">'.$resultados['COMUNA'].'</td>';
                                echo ' <td class="col-sm-1" style="text-align: center">'.$resultados['SITIO'].'</td>';
                                echo ' <td class="col-sm-2"><a target="" href="">'.$resultados['NOMBRE'].'</a></td>';
                                echo ' <td class="col-sm-1">'.$fecha.'</td>';
                                echo ' <td class="col-sm-5"><a data-toggle="modal" href="">'.$resultados['TEXTO'].'</a></td>';
                                echo ' <td class="col-sm-1 text-danger" style="text-align: center">'.$resultados['TIPO'].'</td>';
                            endforeach;
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="ibox-content">
            <p style="margin-bottom: -15px; margin-top: -8px">Total resultados: <?php echo $count_historial; ?></p>
        </div>
    <?php
    }

}