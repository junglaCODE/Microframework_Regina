<?php

/*
 * Archivo que contiene parametros iniciales para configurar la aplicacion 
 * =======================================================================
 * @author JLGC @monolinux
 * @correo [reginas@junglacode.org]
 * @web [reginas.junglacode.org]
 * @fecha [02-10-2015]
 */

header("Content-Type: text/html;charset=utf-8"); //codificación del archivo

define('__APP__', ':)'); /*nombre de la aplicacion*/
define('__PATH__', ''); /*ruta inicial de la aplicacion*/
define('__DEBUG__', TRUE); /* modo en que quiere que se vea su aplicacion */
define('__DRIVER__','mysql',true);/*identificador del driver de base de datos trabajara la app*/
/*recuerde que el driver que elija debe ser igual el mismo nombre sin guiones bajos 
 * a los definidos a continuacion ejemplo MySQL o SQLite*/
 
/*los parametros de conexion se definen con un json la misma configuración de mysql 
sirve para mariaDB*/
define('__MySQL__','{
    "usuario":"monolinux",
    "password":":D",
    "basedatos":":(",
    "servidor":"localhost",
    "puerto":3306
    }'); 
/*parametros de conexion de mysql*/
/*
define('__SQLite__',''); /*parametros de conexion de sqllite*/
/*
* En esta seccion puede usted poner N parametros de conexion hacia base de datos
*/

