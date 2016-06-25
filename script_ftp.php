<?php
error_reporting(E_ALL);
error_reporting(~E_NOTICE);
session_start();

// Primero incluimos las clases de procesamiento
require_once 'cd /Users/Blackbird/Sites/scale/clases/procesador_texto.php';
require_once 'cd /Users/Blackbird/Sites/scale/clases/conexion_ftp.php';
require_once 'cd /Users/Blackbird/Sites/scale/clases/server_ftp.php';

// Vista de conexion FTP
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
$Cliente_ftp = new FTPClient();
$server_ftp = server_ftp::traer_server_ftp();
foreach ($server_ftp as $resultados){
	if (!$Cliente_ftp->Traer_archivo(trim($resultados['server']),trim($resultados['user']),trim($resultados['password']),trim($resultados['carpeta']),trim($resultados['nodo']))){
		error_log(date("d-m-y H:i:s").": DATOS: Servidor:".trim($resultados['server']).", User:".trim($resultados['user']).", Password:".trim($resultados['password']).",
		Carpeta:".trim($resultados['carpeta']).", Nodo:".trim($resultados['nodo']).", No se trae el archivo!!.
		 ", 3, "ftp.log");
	}
	else {
		error_log(date("d-m-y H:i:s").": Archivo traspasado!!. Nodo: ".$resultados['nodo']."\n", 3, "ftp.log");
	}
}

// Vista de lineas -- COLOCAR CUANDO SE QUIERA ALIMENTAR
if (!Procesador_texto::Procesa_archivos()){
	error_log(date("d-m-y H:i:s").": Error de lectura de archivo!!. \n", 3, "ftp.log");
}
else {
	error_log(date("d-m-y H:i:s").": Lectura de archivo exitosa!!. \n", 3, "ftp.log");
}
?>