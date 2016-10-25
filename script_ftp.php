<?php
error_reporting(E_ALL);
error_reporting(~E_NOTICE);
session_start();
date_default_timezone_set('America/Santiago');

// Primero incluimos las clases de procesamiento
require_once '/Users/Blackbird/Sites/scale/clases/procesador_texto.php';
require_once '/Users/Blackbird/Sites/scale/clases/conexion_ftp.php';
require_once '/Users/Blackbird/Sites/scale/clases/server_ftp.php';

require_once '/Users/Blackbird/Sites/scale/clases/conexion_oss.php';
require_once '/Users/Blackbird/Sites/scale/clases/conexion_ftp_oss.php';

require_once '/Users/Blackbird/Sites/scale/clases/sitios_pop.php';
// Vista de conexion FTP
if (!sitios_pop::clarear_alarmas()){
   //echo "Error de clarear alarmas";
}

ini_set('max_execution_time', 300); //300 seconds = 5 minutes
$Cliente_ftp = new FTPClient();
$server_ftp = server_ftp::traer_server_ftp();
foreach ($server_ftp as $resultados){
	if (!$Cliente_ftp->Traer_archivo(trim($resultados['server']),trim($resultados['user']),trim($resultados['password']),trim($resultados['carpeta']),trim($resultados['nodo']))){
		error_log(date("d-m-y H:i:s").": DATOS: Servidor:".trim($resultados['server']).", User:".trim($resultados['user']).", Password:".trim($resultados['password']).",
		Carpeta:".trim($resultados['carpeta']).", Nodo:".trim($resultados['nodo']).", No se trae el archivo!!.\r\n", 3, "ftp.log");
	}
}

// Generacion de archivos 3G y 4G
if (!conexion_oss::conectar_ssh_alarmas_externas("OSS13","3G")){
	error_log(date("d-m-y H:i:s").": Error de generacion de archivo 3G_OSS13!!.\r\n", 3, "ftp.log");
}
if (!conexion_oss::conectar_ssh_alarmas_externas("OSS13","4G")){
	error_log(date("d-m-y H:i:s").": Error de generacion de archivo 4G_OSS13!!.\r\n", 3, "ftp.log");
}
if (!conexion_oss::conectar_ssh_alarmas_externas("OSS14","3G")){
	error_log(date("d-m-y H:i:s").": Error de generacion de archivo 3G_OSS14!!.\r\n", 3, "ftp.log");
}
if (!conexion_oss::conectar_ssh_alarmas_externas("OSS14","4G")){
	error_log(date("d-m-y H:i:s").": Error de generacion de archivo 4G_OSS14!!.\r\n", 3, "ftp.log");
}

// Traer archivos a Servidor
$Cliente_FTP_OSS = new FTPClient_OSS();
$Cliente_FTP_OSS->Traer_archivo_alarmas_OSS_13_3G();
$Cliente_FTP_OSS->Traer_archivo_alarmas_OSS_13_4G();
$Cliente_FTP_OSS->Traer_archivo_alarmas_OSS_14_3G();
$Cliente_FTP_OSS->Traer_archivo_alarmas_OSS_14_4G();

// Vista de lineas -- COLOCAR CUANDO SE QUIERA ALIMENTAR
if (!Procesador_texto::Procesa_archivos()){
	error_log(date("d-m-y H:i:s").": Error de lectura de archivo!!.\r\n", 3, "ftp.log");
}
if (!Procesador_texto::Procesa_archivos_3G()){
	error_log(date("d-m-y H:i:s").": Error de lectura de archivos 3G!!.\r\n", 3, "ftp.log");
}