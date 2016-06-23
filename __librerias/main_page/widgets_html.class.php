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
     * http://www.w3schools.com/html/html_form_input_types.asp
     * @param string $type tipo de input que se desplegara text,password etc
     * @param objJson $json attributes del input id,class,readonly
     * return widget
     */
    static function rWInput($type, $json) {
        return "<input type='$type'  " . self::loadProperties__($json) . ">";
    }

    /**
     * Elaboración de una text area que se genera apartir de un json que contiene todos sus parametros
     * que pueda tener 
     * http://www.w3schools.com/tags/tag_textarea.asp
     * @param objJson $json attributes del input id,class,readonly
     * return widget
     */
    static function rWTextArea($json) {
        return "<textarea " . self::loadProperties__($json) . "></textarea>";
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
