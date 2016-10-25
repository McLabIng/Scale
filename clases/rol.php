<?php
require_once 'conexion.php';

class rol {
    private $cod_rol;
    private $rol;

    const TABLA = 'rol';

    public function getCod_rol() {
        return $this->cod_rol;
    }
    public function getRol() {
        return $this->rol;
    }
    public function setCod_rol($cod_rol) {
        $this->cod_rol = $cod_rol;
    }
    public function setRol($rol) {
        $this->rol = $rol;
    }
    public function __construct($cod_rol, $rol) {
        $this->cod_rol = $cod_rol;
        $this->rol = $rol;
    }

    public static function traer_rol($cod_rol){
        $conexion = new Conexion();
        $consulta = $conexion->prepare('SELECT * FROM ' . self::TABLA .' WHERE COD_ROL = :cod_rol');
        $consulta->bindParam(':cod_rol', $cod_rol, PDO::PARAM_INT);
        $consulta->execute();
        $registro = $consulta->fetch();
        if($registro){
            return new self($registro['COD_ROL'], $registro['ROL']);
        }else{
            return false;
        }
    }

    public static function traer_roles_usuario(){
        $conexion = new Conexion();
        $consulta = $conexion->prepare('SELECT * FROM ' . self::TABLA .' WHERE COD_ROL <> 4 ');
        $consulta->execute();
        $registros = $consulta->fetchAll();
        return $registros;
    }

    public static function traer_rol_cb(){
        $conexion = new Conexion();
        $consulta = $conexion->prepare('SELECT * FROM ' . self::TABLA );
        $consulta->execute();
        $registros = $consulta->fetchAll();
        return $registros;
    }
}

