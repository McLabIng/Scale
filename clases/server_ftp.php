<?php
require_once 'conexion.php';

class server_ftp {
    private $nodo;
    private $server;
    private $user;
    private $password;
    private $carpeta;
    private $online;

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
    public function getOnline() {
        return $this->online;
    }

    public function __construct($nodo, $server, $user, $password, $carpeta, $online) {
        $this->nodo = $nodo;
        $this->server = $server;
        $this->user = $user;
        $this->password = $password;
        $this->carpeta = $carpeta;
        $this->online = $online;
    }

    public static function traer_server_ftp(){
        $conexion = new Conexion();
        $consulta = $conexion->prepare('SELECT * FROM ' . self::TABLA );
        $consulta->execute();
        $registros = $consulta->fetchAll();
        return $registros;
    }

    public static function conexion_error($nodo,$conectado){
        $conexion = new Conexion();
        $consulta = $conexion->prepare('UPDATE ' . self::TABLA .' SET online = :conectado WHERE nodo = :nodo');
        $consulta->bindParam(':nodo', $nodo, PDO::PARAM_INT);
        $consulta->bindParam(':conectado', $conectado, PDO::PARAM_INT);
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

