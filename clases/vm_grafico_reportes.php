<?php
require_once 'conexion.php';

class vm_grafico_reportes {

    const TABLA_1 = 'region';
    const TABLA_2 = 'sitios';
    const TABLA_3 = 'log_alarm_2g';
    //const TABLA_4 = 'o_m.cell_site';
    const TABLA_5 = 'pop';
    const TABLA_6 = 'sitios_pop';
    const TABLA_7 = 'tipos_nodo';

    // Fechas
    const FECHA = 'DATE_ADD(NOW(), INTERVAL -1 HOUR)';
    const FECHA_1 = 'DATE_ADD(NOW(), INTERVAL -3 HOUR)';
    const FECHA_PRUEBA_INICIO = '2016-02-01 00:00:00';
    //const FECHA_PRUEBA_FIN = '2016-01-01 23:59:00';


    public static function traer_fallas_semanales($fecha_inicio,$fecha_fin){
        $conexion = new Conexion();

        $consulta = $conexion->prepare(' SELECT 
                    S.SITIO, A.INICIO, A.TEXTO
                    FROM log_alarm_2g A, sitios S
                    WHERE (A.RSITE = S.RSITE AND
                    A.INICIO >= :fecha_inicio AND
                    A.INICIO <= :fecha_fin AND
                    A.TEXTO LIKE "%AC %")
                    OR
                    (A.RSITE = S.RSITE AND
                    A.INICIO >= :fecha_inicio AND
                    A.INICIO <= :fecha_fin AND
                    A.TEXTO LIKE "% AC%")
                    OR
                    (A.RSITE = S.RSITE AND
                    A.INICIO >= :fecha_inicio AND
                    A.INICIO <= :fecha_fin AND
                    A.TEXTO LIKE "%OML %")
                    ORDER BY S.SITIO,
                    A.INICIO ASC
                    ');
        $consulta->bindParam(':fecha_inicio', $fecha_inicio, PDO::PARAM_INT);
        $consulta->bindParam(':fecha_fin', $fecha_fin, PDO::PARAM_INT);
        $consulta->execute();
        $registros = $consulta->fetchAll();
        return $registros;
    }


    

    
}