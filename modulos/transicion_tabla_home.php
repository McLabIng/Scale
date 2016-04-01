<?php
require_once '../clases/vm_grafico_alarmas.php';
require_once '../vista/vw_home.php';

$alarmas = vm_grafico_alarmas::traer_alarmas_nacional();

// Vista de tabla por regiones
vw_home::lista_nacional($alarmas);