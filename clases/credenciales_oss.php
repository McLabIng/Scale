<?php

/* Datos para conexion de OSS -----------  IMPORTANTE */
define ('SERVIDOR_OSS13', "10.170.15.39");
define ('SERVIDOR_OSS14', "172.18.220.202");
define ('USUARIO_OSS', "excsleiv");
define ('PASSWORD_OSS_13', "solutis2016");
define ('PASSWORD_OSS_14', "mclab2016");
define ('PORT', 22);
define ('PROMPT_OSS13', ".*@cntuas1>");
define ('PROMPT_OSS14', ".*@cdvbluas1");

// Fin de conexion de base de datos interna */

class credenciales_OSS13
{
    private $port = PORT;
    private $host = SERVIDOR_OSS13;
    private $usuario = USUARIO_OSS;
    private $contrasena = PASSWORD_OSS_13;
    private $prompt = PROMPT_OSS13;

    public function getPort()
    {
        return $this->port;
    }

    public function getHost()
    {
        return $this->host;
    }

    public function getUsuario()
    {
        return $this->usuario;
    }

    public function getPassword()
    {
        return $this->contrasena;
    }

    public function getPrompt()
    {
        return $this->prompt;
    }

    public function __construct()
    {
        $this->port = PORT;
        $this->host = SERVIDOR_OSS13;
        $this->usuario = USUARIO_OSS;
        $this->contrasena = PASSWORD_OSS_13;
        $this->prompt = PROMPT_OSS13;
    }
}

class credenciales_OSS14 {
    private $port = PORT;
    private $host = SERVIDOR_OSS14;
    private $usuario = USUARIO_OSS;
    private $contrasena = PASSWORD_OSS_14;
    private $prompt = PROMPT_OSS14;

    public function getPort() {
        return $this->port;
    }
    public function getHost() {
        return $this->host;
    }
    public function getUsuario() {
        return $this->usuario;
    }
    public function getPassword() {
        return $this->contrasena;
    }
    public function getPrompt() {
        return $this->prompt;
    }
    public function __construct() {
        $this->port = PORT;
        $this->host = SERVIDOR_OSS14;
        $this->usuario = USUARIO_OSS;
        $this->contrasena = PASSWORD_OSS_14;
        $this->prompt = PROMPT_OSS14;
    }

}