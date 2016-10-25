<?php
require_once 'conexion.php';

class sitios {
    private $site_id;
    private $nodo;
    private $sitio;
    private $nombre;
    private $direccion;
    private $comuna;
    private $estado;
    private $lat_google;
    private $lon_google;

    const TABLA = 'sitios';

    public function getSite_id() {
        return $this->site_id;
    }
    public function getNodo() {
        return $this->nodo;
    }
    public function getSitio() {
        return $this->sitio;
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
    public function getEstado() {
        return $this->estado;
    }
    public function getLatGoogle() {
        return $this->lat_google;
    }
    public function getLonGoogle() {
        return $this->lon_google;
    }

    public function __construct($cod_sitio, $nodo, $sitio, $nombre, $direccion, $comuna, $estado,
                                $lat_google, $lon_google) {
        $this->site_id = $cod_sitio;
        $this->nodo = $nodo;
        $this->sitio = $sitio;
        $this->nombre = $nombre;
        $this->direccion = $direccion;
        $this->comuna = $comuna;
        $this->estado = $estado;
        $this->lat_google = $lat_google;
        $this->lon_google = $lon_google;
    }

    public static function traer_sitio($cod_sitio){
        $conexion = new Conexion();
        $consulta = $conexion->prepare('SELECT SITE_ID, BSC, SITIO, NOMBRE, DIRECCION, COMUNA, ESTADO, LAT_GOOGLE, LON_GOOGLE
								FROM
								' . self::TABLA .'
								WHERE
								SITE_ID = :cod_sitio AND SITE_ID >= 1 ');
        $consulta->bindParam(':cod_sitio', $cod_sitio, PDO::PARAM_INT);
        $consulta->execute();
        $registro = $consulta->fetch();
        if($registro){
            return new self($registro['SITE_ID'],$registro['BSC'], $registro['SITIO'],$registro['NOMBRE'],
                $registro['DIRECCION'],$registro['COMUNA'],$registro['ESTADO'],
                $registro['LAT_GOOGLE'], $registro['LON_GOOGLE']);
        }else{
            return false;
        }
    }

    public static function listado_sitios(){
        $conexion = new Conexion();
        $consulta = $conexion->prepare(' SELECT SITIO, CONCAT(SITIO,": ",NOMBRE) AS nombre_sitio
								FROM
								' . self::TABLA .'
                        ORDER BY
						SITIO ');
        $consulta->execute();
        $registros = $consulta->fetchAll();
        return $registros;
    }
}

