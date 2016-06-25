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

    // Fechas de prueba
    const FECHA_PRUEBA_INICIO = '2016-02-01 00:00:00';
    //const FECHA_PRUEBA_FIN = '2016-01-01 23:59:00';


    public static function traer_alarmas_nacional(){
        $conexion = new Conexion();

        $consulta = $conexion->prepare(' SELECT
                    R.cod_region, R.id_region, R.nombre, P.region, COUNT(DISTINCT(P.id)) AS sitios, COUNT(DISTINCT(A.TEXTO)) AS alarmas
                    FROM ' . self::TABLA_1 .' R, ' . self::TABLA_5 .' P, ' . self::TABLA_6 .' SP, ' . self::TABLA_2 .' S
                    LEFT JOIN ' . self::TABLA_3 .' A ON S.RSITE = A.RSITE AND A.CLASE = "A1"
                    AND A.INICIO >= "2016-02-14"
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
                    R.cod_region, P.region, P.comuna, COUNT(DISTINCT(P.id)) AS sitios, COUNT(DISTINCT(A.TEXTO)) AS alarmas
                    FROM ' . self::TABLA_1 .' R, ' . self::TABLA_5 .' P, ' . self::TABLA_6 .' SP, ' . self::TABLA_2 .' S
                    LEFT JOIN ' . self::TABLA_3 .' A ON S.RSITE = A.RSITE AND A.CLASE = "A1"
                    AND A.INICIO >= "2016-02-14"
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
                    SUM(IF(A.TEXTO <> "",1,0)) AS CELDAS_ALARMADAS
                    FROM ' . self::TABLA_1 .' R, ' . self::TABLA_5 .' P, ' . self::TABLA_6 .' SP, ' . self::TABLA_2 .' S
                    LEFT JOIN ' . self::TABLA_3 .' A ON S.RSITE = A.RSITE AND A.CLASE = "A1"
                    AND A.INICIO >= "2016-02-14"
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
                    AND A.INICIO >= "2016-02-14"
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

    public static function traer_centro_mapa_region($cod_region){
        $conexion = new Conexion();

        $consulta = $conexion->prepare(' SELECT
                    AVG(DISTINCT P.lat_google) AS lat, AVG(DISTINCT P.lon_google) AS lon
                    FROM ' . self::TABLA_1 .' R, ' . self::TABLA_5 .' P, ' . self::TABLA_6 .' SP, ' . self::TABLA_2 .' S
                    LEFT JOIN ' . self::TABLA_3 .' A ON S.RSITE = A.RSITE AND A.CLASE = "A1"
                    AND A.INICIO >= "2016-02-14"
                    WHERE
                    R.region = P.region AND
                    S.ESTADO = "OPERATIVO" AND
                    R.cod_region = :cod_region AND
                    S.SITIO = SP.cod_sitio AND
                    SP.id_pop = P.id AND
                    P.lat_google <> 0 AND
                    P.lon_google <> 0
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
                    AND A.INICIO >= "2016-02-14"
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
                    P.id, P.cod_pop, SP.cod_sitio, SP.tecnologia, IF (A.TEXTO<>"",1,0)  AS alarma
                    FROM ' . self::TABLA_1 .' R, ' . self::TABLA_5 .' P, ' . self::TABLA_6 .' SP, ' . self::TABLA_2 .' S
                    LEFT JOIN ' . self::TABLA_3 .' A ON S.RSITE = A.RSITE AND A.CLASE = "A1"
                    AND A.INICIO >= "2016-02-14"
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
                    AND A.INICIO >= "2016-02-14"
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
                    S.REGION, S.NOMBRE, SP.cod_sitio, count(A.TEXTO) AS cantidad, A.TEXTO
                    FROM ' . self::TABLA_6 .' SP, ' . self::TABLA_2 .' S, ' . self::TABLA_3 .' A
                    WHERE
                    S.RSITE = A.RSITE AND
                    A.CLASE = "A1" and
                    S.ESTADO NOT IN ("ELIMINADO") AND
                    S.SITIO = SP.cod_sitio AND
                    A.INICIO >= "2016-02-14"
                    group by
                    S.REGION,
                    S.COMUNA,
                    SP.cod_sitio,
                    A.TEXTO
                    order by
                    count(A.TEXTO) desc
                                            
                     ');
        $consulta->execute();
        $registros = $consulta->fetchAll();
        return $registros;
    }

    public static function traer_top_alarmas_minimas(){
        $conexion = new Conexion();

        $consulta = $conexion->prepare(' SELECT
                    S.REGION, S.NOMBRE, SP.cod_sitio, COUNT(A.TEXTO) AS cantidad, A.TEXTO
                    FROM ' . self::TABLA_6 .' SP, ' . self::TABLA_2 .' S, ' . self::TABLA_3 .' A , ' . self::TABLA_5 .' P
                    WHERE
                    S.RSITE = A.RSITE AND
                    A.CLASE = "A1" AND
                    S.ESTADO NOT IN ("ELIMINADO") AND
                    S.SITIO = SP.cod_sitio AND
                    SP.cod_pop = P.cod_pop AND
                    P.tipo_nodo = 1 AND
                    A.INICIO >= "2016-02-14"
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
                    A.INICIO >= "2016-02-14"
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

}