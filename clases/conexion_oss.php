<?php
include_once 'credenciales_oss.php';
require_once 'conexion_ftp.php';

class conexion_oss {

    public static function conectar_ssh_alarmas_externas($OSS, $tecnologia)
    {
        $MiFTP = new FTPClient();
        if ($OSS == "OSS13") {
            $credenciales_oss = new credenciales_OSS13();
            if ($tecnologia == "3G"){
                $formula = ' rm  /home/excsleiv/Documents/alarmas_3g_oss13.csv; /home/cecmigz/bin/list_alarms_3g.sh >  /home/excsleiv/Documents/alarmas_3g_oss13.csv ';
            }
            else {
                $formula = ' rm  /home/excsleiv/Documents/alarmas_4g_oss13.csv; /home/cecmigz/bin/list_alarms_4g.sh >  /home/excsleiv/Documents/alarmas_4g_oss13.csv ';
            }

        } else {
            $credenciales_oss = new credenciales_OSS14();
            if ($tecnologia == "3G"){
                $formula = ' rm  /home/excsleiv/Documents/alarmas_3g_oss14.csv; /home/migonzal/bin/list_alarms_3g.sh >  /home/excsleiv/Documents/alarmas_3g_oss14.csv ';
            }
            else {
                $formula = ' rm  /home/excsleiv/Documents/alarmas_4g_oss14.csv; /home/migonzal/bin/list_alarms_4g.sh >  /home/excsleiv/Documents/alarmas_4g_oss14.csv ';
            }
        }
        $server = $credenciales_oss->getHost();
        $prompt = $credenciales_oss->getPrompt();
        $port =$credenciales_oss->getPort();
        $user = $credenciales_oss->getUsuario();
        $pass = $credenciales_oss->getPassword();

        // *******************   REVISAR FORMULA PARA OSS
        //echo $formula;
        //***********************************************

        $data = "";
        if (!function_exists("ssh2_connect")) die("function ssh2_connect doesn't exist");

        if(!($con = ssh2_connect($server, $port))){
            $MiFTP->logMessage("fail_alarmas_3G: unable to establish connection \r\n");
        }else{
            if(!ssh2_auth_password($con,$user,$pass)) {
                $MiFTP->logMessage("fail_alarmas_3G: unable to authenticate \r\n");
            }
            else {
                if(!($stream = ssh2_exec($con, $formula )) ){
                    $MiFTP->logMessage("fail_alarmas_3G: unable to execute command: ".$formula." \r\n");
                }
                else {
                    stream_set_blocking( $stream, true );
                    $data = "";
                    while( $buf = fread($stream,4096) ){
                        $data .= $buf;
                    }
                    fclose($stream);

                }
            }
        }
        return $data;
    }

}
