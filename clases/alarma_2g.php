<?php
require_once 'conexion.php';

class alarma_2g {
    private $cod_alarma;
    private $rsite;
    private $clase;
    private $fecha;
    private $texto;
    private $tipo_alarma;

    const TABLA = 'log_alarm_2g';

    public function getCod_alarma() {
        return $this->cod_alarma;
    }
    public function getRsite() {
        return $this->rsite;
    }
    public function getClase() {
        return $this->clase;
    }
    public function getFecha() {
        return $this->fecha;
    }
    public function getTexto() {
        return $this->texto;
    }
    public function getTipo_alarma() {
        return $this->tipo_alarma;
    }

    public function __construct($cod_alarma, $rsite, $clase, $fecha, $texto, $tipo_alarma) {
        $this->cod_alarma = $cod_alarma;
        $this->rsite = $rsite;
        $this->clase = $clase;
        $this->fecha = $fecha;
        $this->texto = $texto;
        $this->tipo_alarma = $tipo_alarma;
    }

    public static function traer_alarma($cod_alarma){
        $conexion = new Conexion();
        $consulta = $conexion->prepare('SELECT * FROM ' . self::TABLA .' WHERE ID = :cod_alarma');
        $consulta->bindParam(':cod_alarma', $cod_alarma, PDO::PARAM_INT);
        $consulta->execute();
        $registro = $consulta->fetch();
        if($registro){
            return new self($registro['ID'], $registro['RSITE'], $registro['CLASE'],$registro['INICIO'],$registro['TEXTO'],$registro['TIPO']);
        }else{
            return false;
        }
    }

    public static function agregar_alarma($rsite,$texto,$tipo,$fecha){
        $conexion = new Conexion();
        $clase = 'A1';
        $consulta = $conexion->prepare('insert into ' . self::TABLA .' (RSITE, CLASE, INICIO, TEXTO, TIPO)
								values (:rsite, :clase, :fecha, :texto, :tipo)');
        $consulta->bindParam(':rsite', $rsite);
        $consulta->bindParam(':clase', $clase);
        $consulta->bindParam(':fecha', $fecha);
        $consulta->bindParam(':texto', $texto);
        $consulta->bindParam(':tipo', $tipo);
        if ($consulta->execute()){
            $conexion = null;
            return true;
        }
        else {
            $conexion = null;
            return false;
        }
    }

}