<?php

/*
 * creada el 15-octubre-2014
 * @author ING. JLGC @monolinux
 * jlgarcia@smcmx.com.mx
 * Descripcion: libreria que tiene una serie de funciones que agiliza tareas
 * para el desarrollo de software 
 */

class Jutsus_Ninjas {

    public static function __decodificaSerialize($cadena /* String */) {
        $contenido__ = array();
        $arreglo = explode("&", $cadena);
        $dato = array();
        $i = 0;
        while ($i < (count($arreglo))):
            $dato = explode('=', $arreglo[$i]);
            $contenido__[$dato[0]] = trim($this->convertjsonUTF8__(str_replace('+', ' ', $dato[1])));
            $i++;
        endwhile;
        return $contenido__; //envio de todos lo valores de un formulario
    }

//este jutso te permite convetir un cadena serialize obtenida de javascript
    public function convertjsonUTF8__($cadena) {
        $simbologia = array('%40' => '@', '%3D' => '=', '%C3%B1' => 'ñ', '%C3%91' => 'Ñ', '+' => ' ', '%2C' => ',', '%3A' => ':',
            '%C3%AD' => 'í', '%C3%8D' => 'Í', '%3B' => ';', '%C3%B3' => 'ó', '%2F' => '/', '%23' => '#', '%C3%' => 'ú', '#' => 'ñ');
        return self::strReplaceAssoc__($simbologia, $cadena);
    }

    private function strReplaceAssoc__(array $replace, $subject) {
        return str_replace(array_keys($replace), array_values($replace), $subject);
    }


    public static function setTablaImages($ruta/* string de la carpeta */, $row/* integer */, $titulo = 'Sin titulo'/* String */) {
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
                                $name. "</center></strong></p></a></td>";
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

//fin de la funcion para generar tablas apartir de la imagen
    public function __convertTextToArray($text /* String */, $expresion /* string */, $mover = 0 /*     * integer */) {
        $__columnas = preg_split($expresion, $text);
        $i = 0;
        foreach ($__columnas as $value):
            if (!empty($value)):
                $__lista__[$i] = substr($value, $mover);
            endif;
            $i++;
        endforeach;
        return $__lista__;
    }


    public static function verificarEmail($email) {
        if (!ereg("^([a-zA-Z0-9._]+)@([a-zA-Z0-9.-]+).([a-zA-Z]{2,4})$", $email)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function __verificarPhone($phone) {
        if (strlen($phone) <= 11 && is_numeric($phone)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /* interando con las urls */

    protected function __setURLSystem__() {
        $url = "http://" . $_SERVER['HTTP_HOST'] . ":" . $_SERVER['SERVER_PORT'] . $_SERVER['REQUEST_URI'];
        return $url;
    }

    public function __setNameOfModule() {
        $___url___ = explode('/', $this->__setURLSystem__());
        return $___url___[__DIVURL__];
    }

    public function getNameModule__($tokens, $indice = 0) {
        $__url__ = explode($tokens, $this->__setNameOfModule());
        /* obteniendo el modulo de url */
        return $__url__[$indice];
    }

    /* fin interando con las urls */

    public static function createValuesTables($esquema, $datos/* array */) {
        $__scheme__ = array();
        foreach ($esquema as $campos):
            if (array_key_exists($campos['name'], $datos)):
                $__scheme__[$datos[$campos['name']]] = $campos['value'];
            endif;
        endforeach;
        return $__scheme__;
    }

    public static function formatHora12to24($hora) {
        $__tokens__ = explode(' ', $hora);
        $_anexo_ = ($__tokens__[1] === 'PM') ? 12 : 0;
        $format__ = explode(':', $__tokens__[0]);
        $horas24 = $format__[0] + $_anexo_;
        return $horas24 . ':' . $format__[1];
    }

    /* nueva funcion para formatear la hora a 24 horas algunos widgets manejan esto */

    public function createTheadsOfTables($columns/* array */) {
        $thead = '<tr>';
        foreach ($columns as $names):
            $thead.= "<th> $names </th>";
        endforeach;
        return $thead.='</tr>';
    }

    public function createTheadsOfTablesWhithSize($columns/* array */) {
        $thead = '<tr>';
        foreach ($columns as $names):
            list( $name, $size ) = explode('#', $names);
            $thead.= "<th width='$size'> $name </th>";
        endforeach;
        return $thead.='</tr>';
    }


    public function stringifyToArrayKeyValue($array) {
        $__array__ = null;
        foreach (json_decode($array) as $campos) {
            $__array__[trim($campos[0])] = trim($campos[1]);
        }
        return $__array__;
    }


    public function createOptionsSelect($array, $selected) {
        $options = "";
        foreach ($array as $value => $option):
            if (strcmp(trim($value), trim($selected)) == 0):
                $options .= '<option selected value="' . $value . '">' . $option . '</option>';
            else:
                $options .= "<option value='$value'>$option</option>";
            endif;
        endforeach;
        return $options;
    }


    public function diferenciaDeHoras($date, $time) {
        try {
            $fecha1 = new DateTime($this->convertStringDate($date) . ' ' . $this->convertStringTime($time));
            $fecha2 = new DateTime(date('Y-m-d H:i:s'));
            $fecha = $fecha2->diff($fecha1);
            return $fecha->y . '-' . $fecha->m . '-' . $fecha->d . '-' . $fecha->h . '-' . $fecha->i;
        } catch (Exception $exc) {
            return FALSE;
        }
    }

    public function formatoDiferenciaHoras($resta) {
        if ($resta):
            $horas = explode('-', $resta);
            if ($horas[0] > 0):
                return '<span class="label label-danger"> + ' . $horas[0] . ' Años ' . $horas[1] . ' Meses</span>';
            else:
                if ($horas[2] > 0):
                    return '<span class="label label-warning"> + ' . $horas[2] . ' Dias ' . $horas[3] . ' Hrs</span>';
                else:
                    return '<span class="label label-success"> + ' . $horas[3] . ' Hrs ' . $horas[4] . ' Mins</span>';
                endif;
            endif;
        else :
            return '<code>Inválido</code>';
        endif;
    }

    static function utf8_converter($array) {
        array_walk_recursive($array, function(&$item, $key) {
            if (!mb_detect_encoding($item, 'utf-8', true)) {
                $item = utf8_encode($item);
            }
        });

        return $array;
    }

}

/* fin de la clase */