<?php
require_once 'conexion.php';

class vm_admin {

    const TABLA_1 = 'conexion_ftp';

    public static function conexion_nodos(){
        $conexion = new Conexion();

        $consulta = $conexion->prepare(' SELECT
                    CF.nodo, CF.online
                    FROM '. self::TABLA_1 .' CF
                    ');
        $consulta->execute();
        $registros = $consulta->fetchAll();
        return $registros;
    }

}