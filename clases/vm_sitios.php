<?php
require_once 'conexion.php';

class vm_sitios {

    const TABLA = 'region';
    const TABLA_1 = 'o_m.sitios';

    public static function traer_todos_sitios_region(){
        $conexion = new Conexion();
        $consulta = $conexion->prepare(' SELECT
                                        R.cod_region, S.REGION, S.COMUNA, COUNT(DISTINCT(SUBSTR(S.SITIO,-3,3)))
                                        FROM ' . self::TABLA_1 .' S, ' . self::TABLA .' R
                                        WHERE
                                        R.region = S.REGION AND
                                        S.ESTADO = "OPERATIVO" AND
                                        S.REGION <> ""
                                        GROUP BY
                                        S.REGION,
                                        S.COMUNA
                                        ORDER BY
                                        R.cod_region ');
        $consulta->execute();
        $registros = $consulta->fetchAll();
        return $registros;
    }

    public static function traer_sitios_region($cod_region){
        $conexion = new Conexion();
        $consulta = $conexion->prepare(' SELECT
                                        R.cod_region, S.REGION, S.COMUNA, COUNT(DISTINCT(SUBSTR(S.SITIO,-3,3))) AS sitios
                                        FROM ' . self::TABLA_1 .' S, ' . self::TABLA .' R
                                        WHERE
                                        R.cod_region = :cod_region AND
                                        R.region = S.REGION AND
                                        S.ESTADO = "OPERATIVO" AND
                                        S.REGION <> ""
                                        GROUP BY
                                        S.REGION,
                                        S.COMUNA
                                        ORDER BY
                                        R.cod_region ');
        $consulta->bindParam(':cod_region', $cod_region, PDO::PARAM_INT);
        $consulta->execute();
        $registros = $consulta->fetchAll();
        return $registros;
    }
}

