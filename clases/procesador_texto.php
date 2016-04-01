<?php
require_once 'alarma_2g.php';
//require_once 'vista/vw_home.php';

class Procesador_texto {

    public function __construct() {
    }

    public static function LeeArchivo($archivo){
        if (!file($archivo)){
            die("No se pudo abrir el archivo");
        }
        else {
            return file($archivo);
        }
    }

    public static function inserta_registros($archivo){
        $lineas = self::LeeArchivo($archivo);
        $linea = '';
        foreach ($lineas as $linea_num => $contenido)
        {
            if (trim($contenido) == 'EXTERNAL ALARM'){
                if (strpos($lineas[$linea_num+1], 'ABIERTA') == 0 && strpos($lineas[$linea_num+1], 'BALIZA') == 0 && strpos($lineas[$linea_num+1], 'PUERTA') == 0 && strpos($lineas[$linea_num+1], 'MOVIMIENTO') == 0 && strpos($lineas[$linea_num+1], 'CERCO') == 0 && strpos($lineas[$linea_num+1], 'PORTON') == 0){
                    if (strpos($lineas[$linea_num+1], 'DC') > 0 || strpos($lineas[$linea_num+1], 'AC') > 0 || strpos($lineas[$linea_num+1], 'CORTE') > 0 || strpos($lineas[$linea_num+1], 'GRUPO') > 0 || strpos($lineas[$linea_num+1], 'VACIO') > 0){
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
        }
        return $linea;
    }

    public static function Procesa_archivos(){
        foreach (glob("archivos/*.txt") as $nombre_archivo) {
            $linea = Procesador_texto::inserta_registros($nombre_archivo);
            //vw_home::ver_lineas($linea);
            //unlink($nombre_archivo);
        }
        return $linea;
    }

}
