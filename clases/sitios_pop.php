<?php
require_once 'conexion.php';

class sitios_pop {
    private $id_pop;
    private $cod_pop;
    private $cod_sitio;
    private $tecnologia;
    private $alarmado;

    const TABLA = 'sitios_pop';
    const TABLA_2 = 'sitios';


    public function getId_pop() {
        return $this->id_pop;
    }
    public function getCod_pop() {
        return $this->cod_pop;
    }
    public function getCod_sitio() {
        return $this->cod_sitio;
    }
    public function getTecnologia() {
        return $this->tecnologia;
    }
    public function getAlarmado() {
        return $this->alarmado;
    }

    public function __construct($id_pop, $cod_pop, $cod_sitio, $tecnologia, $alarmado) {
        $this->id_pop = $id_pop;
        $this->cod_pop = $cod_pop;
        $this->cod_sitio = $cod_sitio;
        $this->tecnologia = $tecnologia;
        $this->alarmado = $alarmado;
    }

    public static function traer_sitio_pop($id_pop){
        $conexion = new Conexion();
        $consulta = $conexion->prepare('SELECT *
								FROM
								' . self::TABLA .'
								WHERE
								id_pop = :id_pop ');
        $consulta->bindParam(':id_pop', $id_pop, PDO::PARAM_INT);
        $consulta->execute();
        $registro = $consulta->fetch();
        if($registro){
            return new self($registro['id_pop'], $registro['cod_pop'], $registro['cod_sitio'],$registro['tecnologia'],$registro['alarmado']);
        }else{
            return false;
        }
    }

    public static function clarear_alarmas(){
        $conexion = new Conexion();
        $consulta = $conexion->prepare('UPDATE ' . self::TABLA .' SET alarmado = 0 ');
        if ($consulta->execute()){
            $conexion = null;
            return true;
        }
        else {
            $conexion = null;
            return false;
        }
    }

    public static function sitio_alarmado($cod_sitio){
        $conexion = new Conexion();
        $consulta = $conexion->prepare('UPDATE ' . self::TABLA .' SET alarmado = 1
                                        WHERE cod_sitio = :cod_sitio ');
        $consulta->bindParam(':cod_sitio', $cod_sitio);
        if ($consulta->execute()){
            $conexion = null;
            return true;
        }
        else {
            $conexion = null;
            return false;
        }
    }

    public static function traer_cod_sitio($rsite){
        $conexion = new Conexion();
        $consulta = $conexion->prepare(' SELECT SITIO
								FROM
								' . self::TABLA_2 .'
								WHERE
                                RSITE = :rsite ');
        $consulta->bindParam(':rsite', $rsite);
        $consulta->execute();
        $registro = $consulta->fetchAll();
        if($registro){
            $codigo_sitio = '';
            foreach($registro as $resultados):
                $codigo_sitio = $resultados['SITIO'];
            endforeach;
            return $codigo_sitio;
        }
    }

}

