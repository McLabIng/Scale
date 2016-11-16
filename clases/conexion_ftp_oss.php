<?php

class FTPClient_OSS {
    private $connectionId;
    private $loginOk = false;
    private $messageArray = array();

    const SERVER_FTP_OSS_13 = "10.170.15.39";
    const USER_FTP_13 = "excslei1";
	const USER_FTP_14 = "excsleiv";
    const PASS_FTP_OSS_13 = "2016chile";
    const SERVER_FTP_OSS_14 = "172.18.220.202";
    const PASS_FTP_OSS_14 = "solutis201610";

    public function __construct() {
    }

    public function logMessage($message){
        error_log(date("d-m-y H:i:s").": ".$message, 3, "ftp.log");
    }

    public function getMessages(){
        return $this->messageArray;
    }

    public function connect_OSS_13 ($server = self::SERVER_FTP_OSS_13, $ftpUser = self::USER_FTP_13, $ftpPassword = self::PASS_FTP_OSS_13, $isPassive = true){
        // *** Creamos una conexión básica
        $this->connectionId = ftp_connect($server);
        $this->logMessage("Funcion connect.- connectionId.: ".$this->connectionId. "\r\n");

        // *** Login con usuario y contraseña
        $loginResult = ftp_login($this->connectionId, $ftpUser, $ftpPassword);
        $this->logMessage("Funcion connect.- ftp_login.- ConectionId: ".$this->connectionId.", User: ".$ftpUser.", Passw: ".$ftpPassword. "\r\n");

        // *** Indicamos si el método de conexión es pasivo o no (default off)
        ftp_pasv($this->connectionId, $isPassive);
        $this->logMessage("Funcion connect.- ftp_pasv.: ".$isPassive. "\r\n");

        // *** Check conexión
        if ((!$this->connectionId) || (!$loginResult)) {
            $this->logMessage("FTP connection has failed!. \r\n");
            $this->logMessage("Attempted to connect to " . $server . " for user " . $ftpUser. "\r\n", true);
            return false;
        }
        else
        {
            $this->logMessage("Connected to " . $server . ", for user " . $ftpUser. "\r\n");
            $this->loginOk = true;
            return true;
        }
    }

    public function connect_OSS_14 ($server = self::SERVER_FTP_OSS_14, $ftpUser = self::USER_FTP_14, $ftpPassword = self::PASS_FTP_OSS_14, $isPassive = true){
        // *** Creamos una conexión básica
        $this->connectionId = ftp_connect($server);
        $this->logMessage("Funcion connect.- connectionId.: ".$this->connectionId. "\r\n");

        // *** Login con usuario y contraseña
        $loginResult = ftp_login($this->connectionId, $ftpUser, $ftpPassword);
        $this->logMessage("Funcion connect.- ftp_login.- ConectionId: ".$this->connectionId.", User: ".$ftpUser.", Passw: ".$ftpPassword. "\r\n");

        // *** Indicamos si el método de conexión es pasivo o no (default off)
        ftp_pasv($this->connectionId, $isPassive);
        $this->logMessage("Funcion connect.- ftp_pasv.: ".$isPassive. "\r\n");

        // *** Check conexión
        if ((!$this->connectionId) || (!$loginResult)) {
            $this->logMessage("FTP connection has failed!. \r\n");
            $this->logMessage("Attempted to connect to " . $server . " for user " . $ftpUser. "\r\n", true);
            return false;
        }
        else
        {
            $this->logMessage("Connected to " . $server . ", for user " . $ftpUser. "\r\n");
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
            $this->logMessage(" File " . $fileTo . " successfully downloaded . \r\n");
            return true;
        } else {
            $this->logMessage(" There was an error downloading file " . $fileFrom . " to " . $fileTo. "\r\n");
            return false;
        }
    }

    public function __deconstruct(){
        if ($this->connectionId) {
            ftp_close($this->connectionId);
        }
    }

    public function Traer_archivo_alarmas_OSS_13_3G(){
        if ($this->connect_OSS_13()){
            if (!$this->downloadFile("/home/excslei1/Documents/alarmas_3g_oss13.csv","archivos/alarmas_3g_oss13.csv")){
                $this->logMessage("Archivo alarmas_oss_13_3g sin traer!!. \r\n");
                return false;
            }
            else {
                $this->logMessage("Archivo alarmas_oss_13_3g traspasado!!.  \r\n");
                return true;
            }
        }
        else {
            $this->logMessage("FTP connection has failed!. Funcion traer archivo alarmas_oss_13_3g. \r\n");
        }

    }

    public function Traer_archivo_alarmas_OSS_13_4G(){
        if ($this->connect_OSS_13()){
            if (!$this->downloadFile("/home/excslei1/Documents/alarmas_4g_oss13.csv","archivos/alarmas_4g_oss13.csv")){
                $this->logMessage("Archivo alarmas_oss_13_4g sin traer!!. \r\n");
                return false;
            }
            else {
                $this->logMessage("Archivo alarmas_oss_13_4g traspasado!!. \r\n");
                return true;
            }
        }
        else {
            $this->logMessage("FTP connection has failed!. Funcion traer archivo alarmas_oss_13_4g. \r\n");
        }

    }

    public function Traer_archivo_alarmas_OSS_14_3G(){
        if ($this->connect_OSS_14()){
            if (!$this->downloadFile("/home/excsleiv/Documents/alarmas_3g_oss14.csv","archivos/alarmas_3g_oss14.csv")){
                $this->logMessage("Archivo alarmas_oss_14_3g sin traer!!. \r\n");
                return false;
            }
            else {
                $this->logMessage("Archivo alarmas_oss_14_3g traspasado!!. \r\n");
                return true;
            }
        }
        else {
            $this->logMessage("FTP connection has failed!. Funcion traer archivo alarmas_oss_14_3g. \r\n");
        }

    }

    public function Traer_archivo_alarmas_OSS_14_4G(){
        if ($this->connect_OSS_14()){
            if (!$this->downloadFile("/home/excsleiv/Documents/alarmas_4g_oss14.csv","archivos/alarmas_4g_oss14.csv")){
                $this->logMessage("Archivo alarmas_oss_14_4g sin traer!!. \r\n");
                return false;
            }
            else {
                $this->logMessage("Archivo alarmas_oss_14_4g traspasado!!. \r\n");
                return true;
            }
        }
        else {
            $this->logMessage("FTP connection has failed!. Funcion traer archivo alarmas_oss_14_4g. \r\n");
        }

    }

}
