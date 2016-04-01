<?php
require_once 'conexion.php';

class region {
    private $cod_region;
    private $region;

    const TABLA = 'region';

    public function getCod_region() {
        return $this->cod_region;
    }
    public function getRegion() {
        return $this->region;
    }
    public function __construct($cod_region, $region) {
        $this->cod_region = $cod_region;
        $this->region = $region;
    }

    public static function traer_region($cod_region){
        $conexion = new Conexion();
        $consulta = $conexion->prepare('SELECT * FROM ' . self::TABLA .' WHERE cod_region = :cod_region');
        $consulta->bindParam(':cod_region', $cod_region, PDO::PARAM_INT);
        $consulta->execute();
        $registro = $consulta->fetch();
        if($registro){
            return new self($registro['cod_region'], $registro['region']);
        }else{
            return false;
        }
    }

    public static function traer_regiones(){
        $conexion = new Conexion();
        $consulta = $conexion->prepare('SELECT * FROM ' . self::TABLA );
        $consulta->execute();
        $registros = $consulta->fetchAll();
        return $registros;
    }
}

