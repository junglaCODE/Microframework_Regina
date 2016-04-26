<?php

/*
 * Archivo que contiene parametros iniciales para configurar la aplicacion 
 * =======================================================================
 * @author JLGC @monolinux
 * @correo monolinux@junglacode.org
 * @web [reginas.junglacode.org]
 * @fecha 02-10/2015
 */

header("Content-Type: text/html;charset=utf-8"); //codificación del archivo

define('__APP__', ':)'); /*nombre de la aplicacion*/
define('__PATH__', ''); /*ruta inicial de la aplicacion*/
define('__DEBUG__', TRUE); /* modo en que quiere que se vea su aplicacion */
define('__DRIVER__','mysql',true);/*identificador del driver de base de datos trabajara la app*/
/*recuerde que el driver va ligado a la clase conexion_databases  funcion __loadingParametros__

