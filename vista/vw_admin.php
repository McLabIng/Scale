<?php

class vw_admin {

    public static function estado_llamado_sitio($lista_nodos){
        ?>
        <!-- <div class="ibox-content col-md-12"> -->
            <div class="col-md-4">
                <table class="table table-stripped small m-t-n m-b-xs m-l-n">
                    <tbody>
                        <?php
                        $i = 0;
                        foreach ($lista_nodos as $nodo) {

                            if ($nodo['estado'] == 0) {
                                $boton_alerta = 'text-navy';
                            } else {
                                $boton_alerta = 'text-danger';
                            }

                            if ($i > 0 && $i % 10 == 0) {
                                echo '  </body>
                                    </table>
                                    </div>
                                    <div class="col-md-4">
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

    public static function ingreso_sitio(){
        ?>
        <div class="ibox-content">
            
        </div>
        <?php
    }

}