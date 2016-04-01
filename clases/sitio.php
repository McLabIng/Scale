<?php
require_once 'conexion.php';

class sitio {
    private $site_id;
    private $nodo;
    private $sitio;
    private $rsite;
    private $insite;
    private $nombre;
    private $direccion;
    private $comuna;
    private $region;
    private $estado;
    private $fecha_integracion;
    private $lat_google;
    private $lon_google;
    private $cota;

    const TABLA = 'pop';

    public function getSite_id() {
        return $this->site_id;
    }
    public function getNodo() {
        return $this->nodo;
    }
    public function getSitio() {
        return $this->sitio;
    }
    public function getRSite() {
        return $this->rsite;
    }
    public function getInSite() {
        return $this->insite;
    }
    public function getNombre() {
        return $this->nombre;
    }
    public function getDireccion() {
        return $this->direccion;
    }
    public function getComuna() {
        return $this->comuna;
    }
    public function getRegion() {
        return $this->region;
    }
    public function getEstado() {
        return $this->estado;
    }
    public function getFecha_integracion() {
        return $this->fecha_integracion;
    }
    public function getLatGoogle() {
        return $this->lat_google;
    }
    public function getLonGoogle() {
        return $this->lon_google;
    }
    public function getCota() {
        return $this->cota;
    }

    public function __construct($cod_sitio, $nodo, $sitio, $rsite, $insite, $nombre, $direccion, $comuna, $region, $estado,
                                $fecha_integracion, $lat_google, $lon_google, $cota) {
        $this->site_id = $cod_sitio;
        $this->nodo = $nodo;
        $this->sitio = $sitio;
        $this->rsite = $rsite;
        $this->insite = $insite;
        $this->nombre = $nombre;
        $this->direccion = $direccion;
        $this->comuna = $comuna;
        $this->region = $region;
        $this->estado = $estado;
        $this->fecha_integracion = $fecha_integracion;
        $this->lat_google = $lat_google;
        $this->lon_google = $lon_google;
        $this->cota = $cota;
    }

    public static function traer_sitio($cod_sitio){
        $conexion = new Conexion();
        $consulta = $conexion->prepare('SELECT SITE_ID, BSC, SITIO, RSITE, INSITE, NOMBRE, DIRECCION, COMUNA, REGION, ESTADO,
                                FECHA_INTEGRACION, LAT_GOOGLE, LON_GOOGLE, COTA
								FROM
								' . self::TABLA .'
								WHERE
								SITE_ID = :cod_sitio AND SITE_ID >= 1 ');
        $consulta->bindParam(':cod_sitio', $cod_sitio, PDO::PARAM_INT);
        $consulta->execute();
        $registro = $consulta->fetch();
        if($registro){
            return new self($registro['SITE_ID'],$registro['BSC'], $registro['SITIO'], $registro['RSITE'], $registro['INSITE'],
                $registro['NOMBRE'],$registro['DIRECCION'],$registro['COMUNA'], $registro['REGION'],$registro['ESTADO'], $registro['FECHA_INTEGRACION'],
                $registro['LAT_GOOGLE'], $registro['LON_GOOGLE'], $registro['COTA']);
        }else{
            return false;
        }
    }

}

