<?php
require_once 'conexion.php';

class pop {
    private $pop_id;
    private $pop;
    private $nombre;
    private $direccion;
    private $comuna;
    private $region;
    private $lat_google;
    private $lon_google;
    private $tipo_nodo;

    const TABLA = 'pop';

    public function getPop_id() {
        return $this->pop_id;
    }
    public function getPop() {
        return $this->pop;
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
    public function getLatGoogle() {
        return $this->lat_google;
    }
    public function getLonGoogle() {
        return $this->lon_google;
    }
    public function getTipoNodo() {
        return $this->tipo_nodo;
    }

    public function __construct($cod_pop, $pop, $nombre, $direccion, $comuna, $region, $lat_google, $lon_google, $tipo_nodo) {
        $this->pop_id = $cod_pop;
        $this->pop = $pop;
        $this->nombre = $nombre;
        $this->direccion = $direccion;
        $this->comuna = $comuna;
        $this->region = $region;
        $this->lat_google = $lat_google;
        $this->lon_google = $lon_google;
        $this->tipo_nodo = $tipo_nodo;
    }

    public static function traer_pop($id){
        $conexion = new Conexion();
        $consulta = $conexion->prepare('SELECT cod_pop, nombre, direccion, comuna, region, lat_google, lon_google, tipo_nodo
								FROM
								' . self::TABLA .'
								WHERE
								id = :id ');
        $consulta->bindParam(':id', $id, PDO::PARAM_INT);
        $consulta->execute();
        $registro = $consulta->fetch();
        if($registro){
            return new self($registro['id'], $registro['cod_pop'],
                $registro['nombre'],$registro['direccion'],$registro['comuna'], $registro['region'],
                $registro['lat_google'], $registro['lon_google'], $registro['tipo_nodo']);
        }else{
            return false;
        }
    }

}

