<?php
require_once 'conexion.php';

class vm_grafico_alarmas {

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
    const FECHA_2 = 'DATE_ADD(NOW(), INTERVAL -15 MINUTE)';
    const FECHA_PRUEBA_INICIO = '2016-02-01 00:00:00';
    //const FECHA_PRUEBA_FIN = '2016-01-01 23:59:00';


    public static function traer_alarmas_nacional(){
        $conexion = new Conexion();

        $consulta = $conexion->prepare(' SELECT
                    R.cod_region, R.id_region, R.nombre, P.region, COUNT(DISTINCT(P.id)) AS sitios, COUNT(DISTINCT(A.RSITE)) AS alarmas, COUNT(IF(SP.alarmado = 1,1, NULL)) as alarmados
                    FROM ' . self::TABLA_1 .' R, ' . self::TABLA_5 .' P, ' . self::TABLA_6 .' SP, ' . self::TABLA_2 .' S
                    LEFT JOIN ' . self::TABLA_3 .' A ON S.RSITE = A.RSITE AND A.CLASE = "A1"
                    AND A.INICIO >= '. self::FECHA_2 .'
                    WHERE
                    R.region = P.region AND
                    S.ESTADO = "OPERATIVO" AND
                    S.SITIO = SP.cod_sitio AND
                    SP.id_pop = P.id
                    GROUP BY
                    P.region
                    ORDER BY
                    R.cod_region  ');
        $consulta->execute();
        $registros = $consulta->fetchAll();
        return $registros;
    }

    public static function traer_alarmas_region($cod_region){
        $conexion = new Conexion();

        $consulta = $conexion->prepare(' SELECT
                    R.cod_region, P.region, P.comuna, COUNT(DISTINCT(P.id)) AS sitios, COUNT(DISTINCT(A.TEXTO)) AS alarmas, COUNT(IF(SP.alarmado = 1,1, NULL)) as alarmados
                    FROM ' . self::TABLA_1 .' R, ' . self::TABLA_5 .' P, ' . self::TABLA_6 .' SP, ' . self::TABLA_2 .' S
                    LEFT JOIN ' . self::TABLA_3 .' A ON S.RSITE = A.RSITE AND A.CLASE = "A1"
                    AND A.INICIO >= '. self::FECHA_2 .'
                    WHERE
                    R.cod_region = :cod_region AND
                    R.region = P.region AND
                    S.ESTADO = "OPERATIVO" AND
                    S.SITIO = SP.cod_sitio AND
                    SP.id_pop = P.id
                    GROUP BY
                    P.region,
                    P.comuna
                    ORDER BY
                    alarmados DESC,
                    alarmas DESC,
                    P.comuna ');
        $consulta->bindParam(':cod_region', $cod_region, PDO::PARAM_INT);
        $consulta->execute();
        $registros = $consulta->fetchAll();
        return $registros;
    }

    public static function traer_alarmas_comuna($cod_region, $comuna){
        $conexion = new Conexion();

        $consulta = $conexion->prepare(' SELECT
                    P.id, P.cod_pop, P.tipo_nodo, P.region, P.comuna, P.nombre, P.lat_google, P.lon_google,
                    SUM(IF(A.TEXTO <> "",1,0)) AS CELDAS_ALARMADAS, COUNT(IF(SP.alarmado = 1,1, NULL)) as alarmados
                    FROM ' . self::TABLA_1 .' R, ' . self::TABLA_5 .' P, ' . self::TABLA_6 .' SP, ' . self::TABLA_2 .' S
                    LEFT JOIN ' . self::TABLA_3 .' A ON S.RSITE = A.RSITE AND A.CLASE = "A1"
                    AND A.INICIO >= '. self::FECHA_2 .'
                    WHERE
                    R.region = P.region AND
                    S.ESTADO = "OPERATIVO" AND
                    R.cod_region = :cod_region AND
                    P.comuna = :comuna AND
                    S.SITIO = SP.cod_sitio AND
                    SP.id_pop = P.id AND
                    P.lat_google <> 0 AND
                    P.lon_google <> 0
                    GROUP BY
                    P.id
                    ORDER BY
                    alarmados DESC,
                    CELDAS_ALARMADAS DESC,
                    P.nombre');
        $consulta->bindParam(':cod_region', $cod_region, PDO::PARAM_INT);
        $consulta->bindParam(':comuna', $comuna, PDO::PARAM_STR);
        $consulta->execute();
        $registros = $consulta->fetchAll();
        return $registros;
    }

    public static function traer_alarmas_region_mapa($cod_region){
        $conexion = new Conexion();

        $consulta = $conexion->prepare(' SELECT
                    P.id, P.cod_pop, P.tipo_nodo, P.region, P.comuna, P.nombre, P.lat_google, P.lon_google,
                    SUM(IF(A.TEXTO <> "",1,0)) AS CELDAS_ALARMADAS
                    FROM ' . self::TABLA_1 .' R, ' . self::TABLA_5 .' P, ' . self::TABLA_6 .' SP, ' . self::TABLA_2 .' S
                    LEFT JOIN ' . self::TABLA_3 .' A ON S.RSITE = A.RSITE AND A.CLASE = "A1"
                    AND A.INICIO >= '. self::FECHA_2 .'
                    WHERE
                    R.region = P.region AND
                    S.ESTADO = "OPERATIVO" AND
                    R.cod_region = :cod_region AND
                    S.SITIO = SP.cod_sitio AND
                    SP.id_pop = P.id AND
                    P.lat_google <> 0 AND
                    P.lon_google <> 0
                    GROUP BY
                    P.id ');
        $consulta->bindParam(':cod_region', $cod_region, PDO::PARAM_INT);
        $consulta->execute();
        $registros = $consulta->fetchAll();
        return $registros;
    }

    // public static function traer_centro_mapa_region($cod_region){
    //     $conexion = new Conexion();

    //     $consulta = $conexion->prepare(' SELECT
    //                 AVG(DISTINCT P.lat_google) AS lat, AVG(DISTINCT P.lon_google) AS lon
    //                 FROM ' . self::TABLA_1 .' R, ' . self::TABLA_5 .' P, ' . self::TABLA_6 .' SP, ' . self::TABLA_2 .' S
    //                 LEFT JOIN ' . self::TABLA_3 .' A ON S.RSITE = A.RSITE AND A.CLASE = "A1"
    //                 A.INICIO >= ' . self::FECHA .'
    //                 WHERE
    //                 R.region = P.region AND
    //                 S.ESTADO = "OPERATIVO" AND
    //                 R.cod_region = :cod_region AND
    //                 S.SITIO = SP.cod_sitio AND
    //                 SP.id_pop = P.id AND
    //                 P.lat_google <> 0 AND
    //                 P.lon_google <> 0
    //                  ');
    //     $consulta->bindParam(':cod_region', $cod_region, PDO::PARAM_INT);
    //     $consulta->execute();
    //     $registros = $consulta->fetchAll();
    //     return $registros;
    // }

    public static function traer_centro_mapa_region($cod_region){
        $conexion = new Conexion();

        $consulta = $conexion->prepare(' SELECT
                    R.latitud_centro, R.longitud_centro, R.zoom
                    FROM ' . self::TABLA_1 .' R
                    WHERE
                    R.cod_region = :cod_region
                     ');
        $consulta->bindParam(':cod_region', $cod_region, PDO::PARAM_INT);
        $consulta->execute();
        $registros = $consulta->fetchAll();
        return $registros;
    }

    public static function traer_centro_mapa($cod_region, $comuna){
        $conexion = new Conexion();

        $consulta = $conexion->prepare(' SELECT
                    AVG(DISTINCT P.lat_google) AS lat, AVG(DISTINCT P.lon_google) AS lon
                    FROM ' . self::TABLA_1 .' R, ' . self::TABLA_5 .' P, ' . self::TABLA_6 .' SP, ' . self::TABLA_2 .' S
                    LEFT JOIN ' . self::TABLA_3 .' A ON S.RSITE = A.RSITE AND A.CLASE = "A1"
                    AND A.INICIO >= '. self::FECHA_2 .'
                    WHERE
                    R.region = P.region AND
                    S.ESTADO = "OPERATIVO" AND
                    R.cod_region = :cod_region AND
                    P.comuna = :comuna AND
                    S.SITIO = SP.cod_sitio AND
                    SP.id_pop = P.id AND
                    P.lat_google <> 0 AND
                    P.lon_google <> 0
                     ');
        $consulta->bindParam(':cod_region', $cod_region, PDO::PARAM_INT);
        $consulta->bindParam(':comuna', $comuna, PDO::PARAM_STR);
        $consulta->execute();
        $registros = $consulta->fetchAll();
        return $registros;
    }

    public static function traer_alarmas_pop($cod_region, $comuna, $id_pop){
        $conexion = new Conexion();

        $consulta = $conexion->prepare(' SELECT
                    P.id, P.cod_pop, SP.cod_sitio, SP.tecnologia, IF (A.TEXTO<>"",1,0)  AS alarma, SP.alarmado
                    FROM ' . self::TABLA_1 .' R, ' . self::TABLA_5 .' P, ' . self::TABLA_6 .' SP, ' . self::TABLA_2 .' S
                    LEFT JOIN ' . self::TABLA_3 .' A ON S.RSITE = A.RSITE AND A.CLASE = "A1"
                    AND A.INICIO >= '. self::FECHA .'
                    WHERE
                    R.region = P.region AND
                    S.ESTADO NOT IN ("ELIMINADO") AND
                    R.cod_region = :cod_region AND
                    S.COMUNA = :comuna AND
                    S.SITIO = SP.cod_sitio AND
                    SP.id_pop = P.id AND
                    P.id = :id_pop AND
                    P.lat_google <> 0 AND
                    P.lon_google <> 0
                    GROUP BY
                    cod_sitio
                     ');
        $consulta->bindParam(':cod_region', $cod_region, PDO::PARAM_INT);
        $consulta->bindParam(':comuna', $comuna, PDO::PARAM_STR);
        $consulta->bindParam(':id_pop', $id_pop, PDO::PARAM_INT);
        $consulta->execute();
        $registros = $consulta->fetchAll();
        return $registros;
    }

    public static function traer_alarmas_sitio($cod_region, $comuna, $cod_sitio){
        $conexion = new Conexion();

        $consulta = $conexion->prepare(' SELECT
                    SP.cod_sitio, SP.tecnologia, A.INICIO as fecha, A.TEXTO AS alarma
                    FROM ' . self::TABLA_1 .' R, ' . self::TABLA_5 .' P, ' . self::TABLA_6 .' SP, ' . self::TABLA_2 .' S
                    LEFT JOIN ' . self::TABLA_3 .' A ON S.RSITE = A.RSITE AND A.CLASE = "A1"
                    AND A.INICIO >= '. self::FECHA_1 .'
                    WHERE
                    R.region = P.region AND
                    S.ESTADO NOT IN ("ELIMINADO") AND
                    R.cod_region = :cod_region AND
                    S.COMUNA = :comuna AND
                    S.SITIO = SP.cod_sitio AND
                    SP.id_pop = P.id AND
                    SP.cod_sitio = :cod_sitio AND
                    P.lat_google <> 0 AND
                    P.lon_google <> 0
                     ');
        $consulta->bindParam(':cod_region', $cod_region, PDO::PARAM_INT);
        $consulta->bindParam(':comuna', $comuna, PDO::PARAM_STR);
        $consulta->bindParam(':cod_sitio', $cod_sitio, PDO::PARAM_STR);
        $consulta->execute();
        $registros = $consulta->fetchAll();
        return $registros;
    }

    public static function traer_top_alarmas_recurrentes(){
        $conexion = new Conexion();

        $consulta = $conexion->prepare(' SELECT
                    S.REGION, S.NOMBRE, SP.cod_sitio, count(A.TEXTO) AS cantidad, A.TEXTO, SP.alarmado, SP.tecnologia
                    FROM ' . self::TABLA_6 .' SP, ' . self::TABLA_2 .' S, ' . self::TABLA_3 .' A
                    WHERE
                    S.RSITE = A.RSITE AND
                    A.CLASE = "A1" and
                    S.ESTADO NOT IN ("ELIMINADO") AND
                    S.SITIO = SP.cod_sitio AND
                    A.INICIO >= '. self::FECHA .'
                    group by
                    S.REGION,
                    S.COMUNA,
                    SP.cod_sitio,
                    A.TEXTO
                    order by
                    cantidad desc
                                            
                     ');
        $consulta->execute();
        $registros = $consulta->fetchAll();
        return $registros;
    }

    public static function traer_top_alarmas_recurrentes_region($cod_region){
        $conexion = new Conexion();

        $consulta = $conexion->prepare(' SELECT
                    S.COMUNA, S.NOMBRE, SP.cod_sitio, count(A.TEXTO) AS cantidad, A.TEXTO, A.INICIO, SP.alarmado, SP.tecnologia
                    FROM ' . self::TABLA_6 .' SP, ' . self::TABLA_2 .' S, ' . self::TABLA_3 .' A
                    LEFT JOIN ' . self::TABLA_1 .' R ON R.cod_region = :cod_region
                    WHERE
                    R.region = S.REGION AND
                    S.RSITE = A.RSITE AND
                    A.CLASE = "A1" and
                    S.ESTADO NOT IN ("ELIMINADO") AND
                    S.SITIO = SP.cod_sitio AND
                    A.INICIO >= '. self::FECHA .'
                    group by
                    S.REGION,
                    S.COMUNA,
                    SP.cod_sitio,
                    A.TEXTO
                    ORDER BY
                    cantidad DESC                     
                     ');
        $consulta->bindParam(':cod_region', $cod_region, PDO::PARAM_INT);
        $consulta->execute();
        $registros = $consulta->fetchAll();
        return $registros;
    }

    public static function traer_sin_conexion(){
        $conexion = new Conexion();

        $consulta = $conexion->prepare(' SELECT
                    S.REGION, S.NOMBRE, SP.cod_sitio, SP.alarmado
                    FROM ' . self::TABLA_6 .' SP, ' . self::TABLA_2 .' S 
                    WHERE
                    SP.alarmado = 1 AND
                    S.ESTADO NOT IN ("ELIMINADO") AND
                    S.SITIO = SP.cod_sitio
                    group by
                    S.REGION,
                    S.COMUNA,
                    SP.cod_sitio
                    order by
                    alarmado desc ');
        $consulta->execute();
        $registros = $consulta->fetchAll();
        return $registros;
    }

    public static function traer_sin_conexion_nacional(){
        $conexion = new Conexion();

        $consulta = $conexion->prepare(' SELECT
                    R.cod_region, R.id_region, R.nombre, COUNT(IF(SP.alarmado = 1,1, NULL)) as alarmados
                    FROM ' . self::TABLA_1 .' R, ' . self::TABLA_5 .' P, ' . self::TABLA_6 .' SP, ' . self::TABLA_2 .' S
                    LEFT JOIN log_alarm_2g A ON S.RSITE = A.RSITE AND A.CLASE = "A1"
                    AND A.INICIO >= NOW()
                    WHERE
                    R.region = P.region AND
                    S.ESTADO = "OPERATIVO" AND
                    S.SITIO = SP.cod_sitio AND
                    SP.id_pop = P.id
                    GROUP BY
                    P.region
                    ORDER BY
                    R.cod_region  ');
        $consulta->execute();
        $registros = $consulta->fetchAll();
        return $registros;
    }

    public static function traer_top_alarmas_minimas(){
        $conexion = new Conexion();

        $consulta = $conexion->prepare(' SELECT
                    S.REGION, S.NOMBRE, SP.cod_sitio, COUNT(A.TEXTO) AS cantidad, A.TEXTO
                    FROM '.self::TABLA_6.' SP, '.self::TABLA_2.' S, '.self::TABLA_3.' A , '.self::TABLA_5.' P
                    WHERE
                    S.RSITE = A.RSITE AND
                    A.CLASE = "A1" AND
                    S.ESTADO NOT IN ("ELIMINADO") AND
                    S.SITIO = SP.cod_sitio AND
                    SP.cod_pop = P.cod_pop AND
                    P.tipo_nodo = 1 AND
                    A.INICIO >= '.self::FECHA.'
                    GROUP BY
                    S.REGION,
                    S.COMUNA,
                    SP.cod_sitio,
                    A.TEXTO
                    ORDER BY
                    COUNT(A.TEXTO) DESC
                     ');
        $consulta->execute();
        $registros = $consulta->fetchAll();
        return $registros;
    }

    public static function traer_top_alarmas_recurrentes_tv($cantidad){
        $conexion = new Conexion();

        $consulta = $conexion->prepare(' SELECT
                    S.REGION, S.NOMBRE, SP.cod_sitio, count(A.TEXTO) AS cantidad, A.TEXTO
                    FROM ' . self::TABLA_6 .' SP, ' . self::TABLA_2 .' S, ' . self::TABLA_3 .' A
                    WHERE
                    S.RSITE = A.RSITE AND
                    A.CLASE = "A1" and
                    S.ESTADO NOT IN ("ELIMINADO") AND
                    S.SITIO = SP.cod_sitio AND
                    A.INICIO >= '. self::FECHA .'
                    group by
                    S.REGION,
                    S.COMUNA,
                    SP.cod_sitio,
                    A.TEXTO
                    order by
                    count(A.TEXTO) desc
                    limit :cantidad
                    ');
        $consulta->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
        $consulta->execute();
        $registros = $consulta->fetchAll();
        return $registros;
    }

    public static function traer_historial($sitio,$fecha_1,$fecha_2){
        $conexion = new Conexion();

        $consulta = $conexion->prepare(' SELECT 
                    S.SITIO, S.NOMBRE, S.COMUNA, S.REGION, A.INICIO, A.TEXTO, A.TIPO
                    FROM ' . self::TABLA_3 .' A, ' . self::TABLA_2 .' S
                    WHERE
                    A.RSITE = S.RSITE AND
                    S.SITIO = :sitio AND
                    A.INICIO >= :fecha_1 AND
                    A.INICIO <= :fecha_2
                    ORDER BY A.INICIO
                    ');
        $consulta->bindParam(':sitio', $sitio, PDO::PARAM_INT);
        $consulta->bindParam(':fecha_1', $fecha_1, PDO::PARAM_INT);
        $consulta->bindParam(':fecha_2', $fecha_2, PDO::PARAM_INT);
        $consulta->execute();
        $registros = $consulta->fetchAll();
        return $registros;
    }

    // public static function traer_alarmas_ac_sitio($sitio,$fecha_1,$fecha_2){
    //     $conexion = new Conexion();

    //     $consulta = $conexion->prepare(' SELECT 
    //                 S.SITIO, S.NOMBRE, S.COMUNA, S.REGION, A.INICIO, A.TEXTO, A.TIPO
    //                 FROM ' . self::TABLA_3 .' A, ' . self::TABLA_2 .' S
    //                 WHERE
    //                 A.RSITE = S.RSITE AND
    //                 S.SITIO = :sitio AND
    //                 A.INICIO >= :fecha_1 AND
    //                 A.INICIO <= :fecha_2
    //                 ORDER BY A.INICIO
    //                 ');
    //     $consulta->bindParam(':sitio', $sitio, PDO::PARAM_INT);
    //     $consulta->bindParam(':fecha_1', $fecha_1, PDO::PARAM_INT);
    //     $consulta->bindParam(':fecha_2', $fecha_2, PDO::PARAM_INT);
    //     $consulta->execute();
    //     $registros = $consulta->fetchAll();
    //     return $registros;
    // }

}