<?php
/* 
 * testeando la funcion de loadingParametros la cual se encarga de generar
 * el arreglo de parametros apartir del json establecido en config_app
 * $conexion = new Conexion_Databases();
 * $conexion->__loadingParametros__(); /para esto se debe cambiar la privacidad de la funcion
 */

require __DIR__.'/../__librerias/okol_modelos/dataconexion.inc.php';
$conexion = new Conexion_Databases();
Conexion_Databases::consoleDebug('info');

