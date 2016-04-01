<?php

class FTPClient {
    private $connectionId;
    private $loginOk = false;
    private $messageArray = array();

    public function __construct() {
    }

    public function logMessage($message){
        error_log(date("d-m-y H:i:s").": ".$message. " \n ", 3, "ftp.log");
    }

    public function getMessages(){
        return $this->messageArray;
    }

    public function connect ($server, $ftpUser, $ftpPassword, $isPassive = true){
        // *** Creamos una conexión básica
        $this->connectionId = ftp_connect($server);
        //$this->logMessage("Funcion connect.- connectionId.: ".$this->connectionId);

        // *** Login con usuario y contraseña
        $loginResult = ftp_login($this->connectionId, $ftpUser, $ftpPassword);
        //$this->logMessage("Funcion connect.- ftp_login.- ConectionId: ".$this->connectionId.", User: ".$ftpUser.", Passw: ".$ftpPassword);

        // *** Indicamos si el método de conexión es pasivo o no (default off)
        ftp_pasv($this->connectionId, $isPassive);
        //$this->logMessage("Funcion connect.- ftp_pasv.: ".$isPassive);

        // *** Check conexión
        if ((!$this->connectionId) || (!$loginResult)) {
            $this->logMessage("FTP connection has failed!. \n");
            $this->logMessage("Attempted to connect to " . $server . " for user " . $ftpUser."\n", true);
            return false;
        }
        else
        {
            $this->logMessage("Connected to " . $server . ", for user " . $ftpUser);
            $this->loginOk = true;
            return true;
        }
    }

    public function getDirListing($directory = ".", $parameters = "-la"){
        // obtiene el contenido del directorio
        $contentsArray = ftp_nlist($this->connectionId, $parameters . " " . $directory);
        //$this->logMessage(" getDirListing: Resultados de contentsArray ".print_r($contentsArray)." parametros: ".$parameters . " directory: " . $directory);
        return $contentsArray;
    }

    public function downloadFile ($fileFrom, $fileTo){
        // *** Indicamos el modo de transferencia
        $mode = FTP_ASCII;

        if (ftp_get($this->connectionId, $fileTo, $fileFrom, $mode, 0)) {
            $this->logMessage(" File " . $fileTo . " successfully downloaded ");
            return true;
        } else {
            $this->logMessage(" There was an error downloading file " . $fileFrom . " to " . $fileTo);
            return false;
        }
    }

    public function __deconstruct(){
        if ($this->connectionId) {
            ftp_close($this->connectionId);
        }
    }

    public function Nombre_archivo($servidor,$user,$password,$carpeta){
        if (!$this->connect($servidor,$user,$password)){
            //$this->logMessage("Falla en funcion Nombre_archivo!!. Servidor: ".$servidor." User: ".$user." Password: ".$password." Carpeta: ".$carpeta." \n ");
            return false;
        }
        else {
            //$this->logMessage("Entrando a ver los archivos de la carpeta ".$carpeta." \n ");
            $i = count($this->getDirListing($carpeta));
            $archivo = $this->getDirListing($carpeta);
            //$this->logMessage("Resultados del getDirListing ".$archivo[0]." \n ");
            return mb_substr ($archivo[$i-1],-23,23) ;
        }
    }

    public function Traer_archivo($servidor,$user,$password,$carpeta,$nodo){
        if (!$this->Nombre_archivo($servidor,$user,$password,$carpeta)){
            //$this->logMessage(" Falla en funcion Nombre_archivo (Desde funcion Traer_archivo())!!. Servidor: ".$servidor.", User: ".$user.", Password: ".$password.", Carpeta: ".$carpeta." \n ");
            return false;
        }
        else {
            $nombre = $this->Nombre_archivo($servidor,$user,$password,$carpeta);
            if (!$this->downloadFile($carpeta."/".$nombre,"archivos/".$nodo.".txt")){
                $this->logMessage("Archivo sin traer!!. Nodo: ".$nodo." \n");
                return false;
            }
            else {
                $this->logMessage("Archivo traspasado!!. Nodo: ".$nodo." \n");
                return true;
            }
        }
    }

}
