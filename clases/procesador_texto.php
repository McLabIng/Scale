<?php
require_once 'alarma_2g.php';
// require_once 'alarma_2g_especial.php';
require_once 'sitios_pop.php';
//require_once 'vista/vw_home.php';

class Procesador_texto {

    //************** IMPORTANTE: DEFINIR SI ESTAMOS EN HORARIO INVIERNO o VERANO. INVIERNO -> RESTA 60 MINUTOS *********

    const HORARIO_INVIERNO = true;

    //*****************************************************************************************************************

    public function __construct() {
    }

    public static function LeeArchivo($archivo){

        if (!file($archivo)){
            error_log(date("d-m-y H:i:s").": Error en LeeArchivo. : ".$archivo." /s/n", 3, "modulos/ftp.log");
        }
        else {
            return file($archivo);
        }
    }

    public static function inserta_registros($archivo){
        //date_default_timezone_set('America/Santiago');
        $lineas = self::LeeArchivo($archivo);
        $linea = '';
        foreach ($lineas as $linea_num => $contenido)
        {
            if (trim($contenido) == 'EXTERNAL ALARM'){
                if (strpos($lineas[$linea_num+1], 'ABIERTA') == 0 && strpos($lineas[$linea_num+1], 'BALIZA') == 0 && strpos($lineas[$linea_num+1], 'PUERTA') == 0 && strpos($lineas[$linea_num+1], 'MOVIMIENTO') == 0 && strpos($lineas[$linea_num+1], 'CERCO') == 0 && strpos($lineas[$linea_num+1], 'PORTON') == 0){
                    if (strpos($lineas[$linea_num+1], 'DC') > 0 || strpos($lineas[$linea_num+1], 'AC') > 0 || strpos($lineas[$linea_num+1], 'CORTE') > 0 || strpos($lineas[$linea_num+1], 'GRUPO') > 0 || strpos($lineas[$linea_num+1], 'VACIO') > 0 ){
                        $datos = preg_split('/\s+/', $lineas[$linea_num-2]);
                        $rsite = trim($datos[1]);
                        $datos_fecha = preg_split('/\s+/',$lineas[$linea_num-7]);
                        $dummy = array_pop($datos_fecha);
                        $hora = array_pop($datos_fecha);
                        $fecha = array_pop($datos_fecha);
                        $fecha_alarma = '20'.substr($fecha,0,2).'-'.substr($fecha,2,2).'-'.substr($fecha,4,2);
                        $hora_alarma = substr($hora,0,2).':'.substr($hora,2,2).':00';
                        $fecha_completa = $fecha_alarma.' '.$hora_alarma;
                        $linea .= 'Linea Fecha: '.$fecha_completa.' rsite '.$rsite.': '.$lineas[$linea_num+1]."<br>";
                        if (!alarma_2g::agregar_alarma($rsite,$lineas[$linea_num+1],'ELECTRICIDAD',$fecha_completa)){
                            $linea .= 'Not_OK.<br>';
                        }
                        else {
                            $linea .= 'OK.<br>';
                        }
                    }
                }
            }
            if (trim($contenido) == 'MANAGED OBJECT FAULT'){
                if (strpos($lineas[$linea_num+3], 'OML FAULT') > 0){
                    $datos = preg_split('/\s+/', $lineas[$linea_num+3]);
                    $rsite = trim($datos[1]);
                    $datos_fecha = preg_split('/\s+/',$lineas[$linea_num-2]);
                    $dummy = array_pop($datos_fecha);
                    $hora = array_pop($datos_fecha);
                    $fecha = array_pop($datos_fecha);
                    $fecha_alarma = '20'.substr($fecha,0,2).'-'.substr($fecha,2,2).'-'.substr($fecha,4,2);
                    $hora_alarma = substr($hora,0,2).':'.substr($hora,2,2).':00';
                    $fecha_completa = $fecha_alarma.' '.$hora_alarma;
                    $linea .= 'Linea OML_FAULT Fecha: '.$fecha_completa.' rsite '.$rsite.': SITIO CAIDO "<br>"';
                    if (!alarma_2g::agregar_alarma($rsite,'OML FAULT','CRITICO',$fecha_completa)){
                        $linea .= 'Not_OK.<br>';
                    }
                    else {
                        //$segundos =  strtotime('now') - strtotime($fecha_completa);
                        //$diferencia_minutos = intval($segundos/60);
                        /*if (self::HORARIO_INVIERNO == true){
                            $diferencia_minutos = $diferencia_minutos - 60;
                        }*/
                        //if ($diferencia_minutos < 60){
                            $cod_sitio = sitios_pop::traer_cod_sitio($rsite);
                            if (!sitios_pop::sitio_alarmado($cod_sitio)){
                                $linea .= 'Not_OK para alarmar sitio: '.$cod_sitio.' <br>';
                            }
                            else {
                                $linea .= ' Sitio alarmado: '.$cod_sitio.' OK."<br>"';
                            }
                        //}
                    }
                }
            }
        }
        return $linea;
    }

    public static function inserta_registros_3G($archivo){
        //date_default_timezone_set('America/Santiago');
        $lineas = self::LeeArchivo($archivo);
        $linea = '';
        foreach ($lineas as $linea_num => $contenido)
        {
            if (strpos($lineas[$linea_num], 'MeContext=') > 0) {
                if (strpos($lineas[$linea_num+1], 'ABIERTA') == 0 && strpos($lineas[$linea_num+1], 'BALIZA') == 0 && strpos($lineas[$linea_num+1], 'PUERTA') == 0 && strpos($lineas[$linea_num+1], 'MOVIMIENTO') == 0 && strpos($lineas[$linea_num+1], 'CERCO') == 0 && strpos($lineas[$linea_num+1], 'PORTON') == 0){
                    if (strpos($lineas[$linea_num + 1], 'DC') > 0 || strpos($lineas[$linea_num + 1], 'AC') > 0 || strpos($lineas[$linea_num + 1], 'CORTE') > 0 || strpos($lineas[$linea_num + 1], 'GRUPO') > 0 || strpos($lineas[$linea_num + 1], 'VACIO') > 0 || strpos($lineas[$linea_num + 1], 'NERG') > 0 || strpos($lineas[$linea_num + 1], 'nerg') > 0 ||
                        strpos($lineas[$linea_num + 2], 'DC') > 0 || strpos($lineas[$linea_num + 2], 'AC') > 0 || strpos($lineas[$linea_num + 2], 'CORTE') > 0 || strpos($lineas[$linea_num + 2], 'GRUPO') > 0 || strpos($lineas[$linea_num + 2], 'VACIO') > 0 || strpos($lineas[$linea_num + 2], 'NERG') > 0 || strpos($lineas[$linea_num + 2], 'nerg') > 0
                    ) {
                        $datos = preg_split('/(;)+/', $lineas[$linea_num]);
                        $fecha = trim($datos[1]);
                        $posicion_rsite = strpos($datos[2], 'MeContext=');
                        $rsite = substr($datos[2],$posicion_rsite+10,6);
                        $newDate = date("Y-m-d H:i:s", strtotime($fecha));
                        $linea .= 'Fecha: ' . $newDate . ' RSite: ' . $rsite . "<br>";
                        $linea .= ' Alarma: ' .trim(substr($lineas[$linea_num + 1],1)). "<br>";
                        if (!alarma_2g::agregar_alarma($rsite,trim(substr($lineas[$linea_num + 1],1)),'ELECTRICIDAD',$newDate)){
                            $linea .= 'Not_OK.<br>';
                        }
                        else {
                            $linea .= 'OK.<br>';
                        }
                        //$linea .= $contenido.'<br>';
                    }
                }
            }
        }
        return $linea;
    }

    public static function inserta_registros_especiales($archivo){
        //date_default_timezone_set('America/Santiago');
        $lineas = self::LeeArchivo($archivo);
        $linea = '';
        foreach ($lineas as $linea_num => $contenido)
        {
            if (trim($contenido) == 'EXTERNAL ALARM'){
                if (strpos($lineas[$linea_num+1], 'BALIZA') > 0 ){
                        $datos = preg_split('/\s+/', $lineas[$linea_num-2]);
                        $rsite = trim($datos[1]);
                        $datos_fecha = preg_split('/\s+/',$lineas[$linea_num-7]);
                        $dummy = array_pop($datos_fecha);
                        $hora = array_pop($datos_fecha);
                        $fecha = array_pop($datos_fecha);
                        $fecha_alarma = '20'.substr($fecha,0,2).'-'.substr($fecha,2,2).'-'.substr($fecha,4,2);
                        $hora_alarma = substr($hora,0,2).':'.substr($hora,2,2).':00';
                        $fecha_completa = $fecha_alarma.' '.$hora_alarma;
                        $linea .= 'Linea Fecha: '.$fecha_completa.' rsite '.$rsite.': '.$lineas[$linea_num+1]."<br>";
                        if (!alarma_2g_especial::agregar_alarma($rsite,$lineas[$linea_num+1],'ESPECIAL',$fecha_completa)){
                            $linea .= 'Not_OK.<br>';
                        }
                        else {
                            $linea .= 'OK.<br>';
                        }
                }
            }
        }
        return $linea;
    }

    public static function Procesa_archivos(){
        $linea = '';
        foreach (glob("archivos/*.txt") as $nombre_archivo) {
            $linea = Procesador_texto::inserta_registros($nombre_archivo);
            //vw_home::ver_lineas($linea);
            //unlink($nombre_archivo);
        }
        return $linea;
        //vw_home::ver_lineas($linea);
        //print_r($linea) ;
    }

    public static function Procesa_archivos_3G(){
        $linea = '';
        foreach (glob("archivos/*.csv") as $nombre_archivo) {
            $linea = Procesador_texto::inserta_registros_3G($nombre_archivo);
            //vw_home::ver_lineas($linea);
            //unlink($nombre_archivo);
        }
        return $linea;

        //print_r($linea) ;
    }

    public static function Procesa_archivos_especiales(){
        $linea = '';
        foreach (glob("archivos/*.txt") as $nombre_archivo) {
            $linea = Procesador_texto::inserta_registros_especiales($nombre_archivo);
            //vw_home::ver_lineas($linea);
            //unlink($nombre_archivo);
        }
        return $linea;
        //vw_home::ver_lineas($linea);
        //print_r($linea) ;
    }

}
