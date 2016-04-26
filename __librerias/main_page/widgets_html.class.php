<?php

/*
 * @Descripcion .- Widgets basicos del html que se podran utilizar sin necesidad utilizar
 * un framework html,css,js como boostrap ó foundation 
 * =======================================================================
 * @author JLGC @monolinux
 * @correo monolinux@junglacode.org
 * @web [reginas.junglacode.org]
 * @fecha 25-04/2016
 */

class Widgets_Html {

    /**
     * Elaboración de input de tipo text el cual se geneara apartir de un json que contiene todos sus parametros
     * que contiene una input tipo text. 
     * example :
     * $input {_id_:'none' ,_class_:'none' , _readonly_ :'none'....etc } 
     * @param objJson $json
     * return String 
     */
    static function rWinputText($json) {
        return  "<input type='text'  ".self::loadProperties__($json).">";        
    }

    private function loadProperties__($json) {
        $properties__ = null;
        $param = json_decode($json);
        foreach ($param as $attribute => $value):
            $properties__ .= $attribute . "= '$value' ";
        endforeach;
        return $properties__;
    }

}
