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

    /**
     * Elaboracion de un select que se genera apartir de un json que contiene sus parametros
     * puede usar el siguiente enlace para verificar sus propieades,
     * http://www.w3schools.com/tags/tag_option.asp
     * se necesita sus la estructura de los opciones puede user la funcion createOptionsSelect() para crear
     * el cuerpo mas facilmente :)
     * 
     * @param objjson $json
     * @param type $options puede usar createOptionsSelect()
     * @return widget
     */
    static function rWSelect($json,$options) {
        return "<select " . self::loadProperties__($json) . ">$options</select>";
    }
    
    private function loadProperties__($json) {
        $properties__ = null;
        $param = json_decode($json);
        foreach ($param as $attribute => $value):
            $properties__ .= $attribute . "= '$value' ";
        endforeach;
        return $properties__;
    }
    
    /**
     * funcion que crea el contenido de un thead apartir de un arreglo
     * Array('iduser,name,phone) 
     * http://www.w3schools.com/tags/tag_thead.asp
     * @param array $columns .- nombres de las columnas 
     * @return contenidoThead
     */

    static function createHeadOfTables($columns/* array */) {
        $thead = '<tr>';
        foreach ($columns as $names):
            $thead.= "<th> $names </th>";
        endforeach;
        return $thead.='</tr>';
    }

     /**
     * funcion que crea el contenido de un thead apartir de un arreglo, pero con la diferencia que se le puede
      * poner  agregar el ancho  Array('iduser=>5,name=>20,phone=>18) 
     * http://www.w3schools.com/tags/tag_thead.asp
     * @param array $columns .- nombres de las columnas 
     * @return contenidoThead
     */
    static function createHeadOfTablesWhithSize($columns/* array */) {
        $thead = '<tr>';
        foreach ($columns as $names):
            list( $name, $size ) = explode('#', $names);
            $thead.= "<th width='$size'> $name </th>";
        endforeach;
        return $thead.='</tr>';
    }

    /**
     * crea las opciones de un select apartir de un arreglo con keys => values 
     * los keys se convierten en values de un select y los value en el display de las opciones
     * http://www.w3schools.com/tags/tag_option.asp
     * @param type $array : array(1=>'"mexico",2=>"chile)
     * @param String $selected dato que se usara para seleccionar por default una opcion
     * @return type
     */
    static function createOptionsSelect($array, $selected) {
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

}

/**/