<?php
require_once 'conexion.php';

class server_ftp {
    private $nodo;
    private $server;
    private $user;
    private $password;
    private $carpeta;

    const TABLA = 'conexion_ftp';

    public function getNodo() {
        return $this->nodo;
    }
    public function getServer() {
        return $this->server;
    }
    public function getUser() {
        return $this->user;
    }
    public function getPassword() {
        return $this->password;
    }
    public function getCarpeta() {
        return $this->carpeta;
    }

    public function __construct($nodo, $server, $user, $password, $carpeta) {
        $this->nodo = $nodo;
        $this->server = $server;
        $this->user = $user;
        $this->password = $password;
        $this->carpeta = $carpeta;
    }

    public static function traer_server_ftp(){
        $conexion = new Conexion();
        $consulta = $conexion->prepare('SELECT * FROM ' . self::TABLA );
        $consulta->execute();
        $registros = $consulta->fetchAll();
        return $registros;
    }
}

