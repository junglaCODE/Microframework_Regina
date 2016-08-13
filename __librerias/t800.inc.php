<?php

/* Creación :
 *         11-octubre-2014
 * @autor:
 *         Juan Luis Garcia Corrales [@monolinux]
 * Descripcion:
 *         Clase de seguridad basado en el modelo de tablas del framework Regina 
 * este archivo hace referencia a la pelicula Terminator con los modelos T800
 * esta clase tiene como objetivo generar funciones para poder asegurar 
 * la integridad del sistema que se creara
 */

abstract class Centinela_T800 {

    const __VERSION__ = '1.0';

    /**
     * Esta funcion verifica si existe una session activa para no puedan entrar 
     * sin permiso
     * 
     * @param array  es la variable global $_SESSION
     * @return boolean
     */
    abstract protected function isActiveSession($session);

    //fin de la funcion seguridad de datos
    abstract protected function creatingAHash($clave);

// fin de la verificacion de sessiones hash_algos()
    public static function encryptacionOfDatas($metodo, $parametros) {
        if (is_array($parametros)):
            switch ($metodo) {
                case 1:/* sha1 http://php.net/manual/es/function.sha1.php */
                    $cypher = sha1($parametros['cadena']);
                    break;
                case 2: /* hash http://php.net/manual/es/function.hash.php */
                    $cypher = hash($parametros['metodo'], $parametros['cadena']);
                    break;
                case 3:/* cryp http://php.net/manual/es/function.crypt.php */
                    $encryp = crypt($parametros['cadena'], $parametros['hash']);
                    break;
                default:
                    /* md5 http://php.net/manual/es/function.md5.php */
                    $cypher = md5($parametros['cadena']);
            }
            return $encryp;
        else:
            return 'Error [t850::encriptación] parametros incorrectos';
        endif;
    }

    public static function permiteAcceso($listaccesos, $privilegio) {
        if (strcmp($listaccesos, '*') != 0):
            $flag = false;
            $index = 0;
            $accesos = explode('-', $listaccesos); /* verificando los accesos */
            while ($index < count($accesos) && !$flag):
                $flag = ($accesos[$index] == $privilegio) ? $flag = TRUE : $flag = FALSE;
                $index++;
            endwhile; //verificamos si existe privilegio
            return $flag;
        else:
            return true;
        endif;
    }

//fin del perimteejecucion

    public function cerrarSesion() {
        session_destroy();
    }

//fin de la funcion jce
}
