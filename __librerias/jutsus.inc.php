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
                $contenido__[$dato[0]] = trim(self::convertjsonUTF8(str_replace('+', ' ', $dato[1])));
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
    static function convertjsonUTF8($parametro, $reverse = false) {
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
}

/* fin de la clase */