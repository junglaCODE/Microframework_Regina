<?php

/*
 * creada el 23-06/2016
 * @author ING. JLGC @monolinux
 * @email monolinux@junglacode.org
 * @web junglacode.org
 * Descripcion: libreria que tiene una serie de funciones que agiliza tareas monotonas  que todos sabemos
 * bien que los verdaderos programadores lo odiamos
 */

class Jutsus_Ninjas {
    /* <expresiones regulares para usarla con las fuciones ereg o preg_match  y validacion de datos> */

    const expEMAIL = " \'/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/\'";
    const expUSER = "\'/^[a-z\\d_]{4,15}$/i\'"; /* validar usuarios de 15 caracteres */
    const expTEL = "\'/^(\\(?[0-9]{3,3}\\)?|[0-9]{3,3}[-. ]?)[ ][0-9]{3,3}[-. ]?[0-9]{4,4}$/\'";
    const expCP = "\'/^[0-9]{5,5}([- ]?[0-9]{4,4})?$/\'";
    const expIP = "\'^(?:25[0-5]|2[0-4]\\d|1\\d\\d|[1-9]\\d|\\d)(?:[.](?:25[0-5]|2[0-4]\\d|1\\d\\d|[1-9]\\d|\\d)){3}$\'";
    const expHEX = "\'/^#(?:(?:[a-f\\d]{3}){1,2})$/i\'"; /* para numeros hexadecimales */
    const expDATE = "\'/^\\d{1,2}\\/\\d{1,2}\\/\\d{4}$/\'";

    /* </fin de las expreciones regulares> */

    /* < funciones que agilizan peticiones url de tipo get  del vista hcia el controlador > */

    /**
     * Funcion que apartir de una url GET de tipo [single=Single&multiple=Multiple&multiple=Multiple3], enviada
     * desde la vista la convierte en un arreglo donde el index se convierte en el campo y el value en el valor enviado
     * 
     * @param String $geturl
     * @param Boolean $codificacion true o false
     * @return Array
     */
    static function decodificaSerialize($geturl, $codificacion = false) {
        $contenido__ = array();
        $arreglo = explode("&", $geturl);
        $dato = array();
        $i = 0;
        while ($i < (count($arreglo))):
            $dato = explode('=', $arreglo[$i]);
            if ($codificacion):
                $contenido__[$dato[0]] = trim($dato[1]);
            else:
                $contenido__[$dato[0]] = trim(self::convertCodingJson(str_replace('+', ' ', $dato[1])));
            endif;
            $i++;
        endwhile;
        return $contenido__;
    }

    /**
     * Diccionario de que convierte peticiones de json a codificación utf8. Esto es necesario debido aque cuando
     * los datos viajan atravez de ajax estos no puden contener caracteres raros y se deben enviar decoificados
     * asi que cuando llega al controlador estos se de codifican para ser interpretados en su mismo formato
     * de igual manera pudes usuar esta funcion para decodificar un utf8 y enviarlo a la vista sin tener problemas
     * Nota ::: el diccionario no esta competleto
     * @param string $parametro
     * @parem boolean $reverse true ó false
     * @return String $value
     */
    static function convertCodingJson($parametro, $reverse = false) {
        $simbologia = array('%40' => '@', '%3D' => '=', '%C3%B1' => 'ñ', '%C3%91' => 'Ñ', '+' => ' ', '%2C' => ',', '%3A' => ':',
            '%C3%AD' => 'í', '%C3%8D' => 'Í', '%3B' => ';', '%C3%B3' => 'ó', '%2F' => '/', '%23' => '#', '%C3%' => 'ú', '#' => 'ñ');
        if ($reverse):
            $simbologia = array_flip($simbologia);
        endif;
        return self::strReplaceAssoc__($simbologia, $parametro);
    }

    private function strReplaceAssoc__(array $replace, $subject) {
        return str_replace(array_keys($replace), array_values($replace), $subject);
    }

    /* </ funciones que agilizan peticiones url de tipo get  del vista hcia el controlador > */

    /* <tratamiento de urls> */

    /**
     * esta funcion trae la url  de la pagina donde esta situado 
     * @return String url
     */
    static function getThisURL() {
        $url = "http://" . $_SERVER['HTTP_HOST'] . ":" . $_SERVER['SERVER_PORT'] . $_SERVER['REQUEST_URI'];
        return $url;
    }

    /**
     * obtiene todos los directorios apartir de una url definida en caso que no ponga una url 
     * toma como definida la que esta situada
     * Nota : esta url solo es valida si el formato contiene diagonales [ / ]  
     * @return Array Directorio
     */
    static function getDirURl($url = null) {
        $__path__ = (empty($url)) ? self::getThisURL() : $url;
        $___url___ = explode('/', $__path__);
        return $___url___;
    }

    /* </fin de tratamientos de url> */

    /* <tratamiento de  horas > */

    /**
     * 
     * Esta función ayuda al usuario a convertir un formato de tipo
     * 01:12 PM a 13:12 de igual manera puede usar un formato de tipo datetime
     * con lo siguiente date('d-m-Y'). '"01:11:11"  = 23-06-2016 13:11:11 
     * 
     * @param String $datetime 11:11:2011 11:11:11
     * @return String en formato de 24 horas
     */
    static function formatHora12to24($datetime) {
        $__tokens__ = explode(' ', $datetime);
        $_anexo_ = ($__tokens__[1] === 'PM') ? 12 : 0;
        $format__ = explode(':', $__tokens__[0]);
        $horas24 = $format__[0] + $_anexo_;
        return $horas24 . ':' . $format__[1];
    }

    /**
     * Función que proporciona la diferencia entre dos fechas , tomando como referencia la que se pone
     * versus la que esta actualmente. de esta manera usted pude saber que tiempo tiene x parametro 
     * la salida es un y-m-d-h-i puede usarse un explode('-'), para que se trasforme en un arreglo
     * 
     * @param string $date en formato de dd-mm-YY
     * @param string $time  en formato HH:mm:ss
     * @return String con separador -
     */
    static function diferenciaDeHoras($date, $time) {
        try {
            $fecha1 = new DateTime($date . ' ' . $time);
            $fecha2 = new DateTime(date('Y-m-d H:i:s'));
            $fecha = $fecha2->diff($fecha1);
            return $fecha->y . '-' . $fecha->m . '-' . $fecha->d . '-' . $fecha->h . '-' . $fecha->i;
        } catch (Exception $exc) {
            return FALSE;
        }
    }

    /* </fin de tratamiento de horas> */

    /* < jugando con arreglos> */

    /**
     * funcion que trata un envio ajax ya codificado en utf8  en arreglo de basado en el  formulario enviado
     * JSON.stringify desde jquery puede usarse eso 
     * @param  array  $sendAjax JSON.stringify
     * @return Array 
     */
    static function stringifyToArrayKeyValue($sendAjax) {
        $__array__ = null;
        foreach (json_decode($sendAjax) as $campos) {
            $__array__[trim($campos[0])] = trim($campos[1]);
        }
        return $__array__;
    }

    /**
     * Convierte un arreglo a codificacion UTF-8
     * 
     * @param Array $array
     * @return type Array
     */
    static function arrayUtf8Converter($array) {
        if (!empty($array)):
            array_walk_recursive($array, function(&$item, $key) {
                if (!mb_detect_encoding($item, 'utf-8', true)) {
                    $item = trim(utf8_encode($item));
                } else {
                    $item = trim(utf8_decode($item));
                }
            });
            return $array;
        endif;
    }

    /* </fin jugando con arreglos> */

    /* golosina increible */
    
/**
 *  funcion que permite  crear un album apartir de un carpeta. esta funcion solo pone foto en funcion
 * al nombre que usted le proporcione
 * 
 * @param type $ruta directorio donde se encuetra el repositorio de imagenes
 * @param type $row cuantas columnas quiere que se vea  el album
 * @param type $titulo el titulo del album
 * @return album
 */
    static function createAlbumImages($ruta, $row, $titulo = 'Sin titulo') {
        $count = 0;
        $__path__ = __DIR__ . '/..' . $ruta;
        if (is_dir($__path__)):
            $directorio = opendir($__path__); //ruta actual
            $tabla = '<table><tr><thead class=\'head-album\'><tr><th colspan=\'' . ($row + 1) . '\'>'
                    . $titulo . '</th></tr></thead><tbody><tr>';
            while ($archivo = readdir($directorio)) { //obtenemos un archivo y luego otro sucesivamente
                list($name, $ext) = explode('.', $archivo);
                if (!is_dir($archivo)) {//verificamos si es o no un directorio
                    if ($count <= $row):
                        $tabla.="<td><img src='" . $ruta . '/' . $archivo . "'><p class='tags ml25'><center><strong>" .
                                $name . "</center></strong></p></a></td>";
                        $count++;
                    else:
                        $tabla.='</tr>';
                        $count = 0; /* reseteo de contador */
                    endif;
                }/* fin de la decision que solo lee directorios */
            }//fin del ciclo
        else:
            $tabla = 'Directorio inexistente';
        endif;
        return $tabla . '</tbody><tfoot class=\'head-album\'><tr><th colspan=\'' . ($row + 1) . '\'></th></tr></tfoot></table>';
    }

}

/* fin de la clase */