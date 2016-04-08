<?php

/*
 * Fecha 8-04/2016
 * creado por JLGC @monolinux 
 * @email: reginas@junglacode.org
 * @web:   reginas.junglacode.org
 * 
 * Descripcion : esta clase prentende ayudar al programador a previnir ataques de sql_inyeccion o XSS ademas
 * de funciones que agilizara la generación de codigos
 */

class Methods_Hacking {

    /**
     * esta funcion genera codigo sql de tipo INSERT para poder ser usado con las diferentes funciones de dataconexion 
     * aunque recomiendo ser usada ___executeQuery___
     * _____________________________________________________________________________________________
     * ejemplo $cols =  array(col1,col2,....,col10)  => __createSqlInsert('usuarios',$cols,false);
     * salida : insert into usuarios (col1,col2..,col10) values (?,?.....,?);
     * 
     * @param String $table nombre de la tabla
     * @param Array $columns los campos de la tabla 
     * @param boolean $safe es la manera en como quieres que se vea el codigo SQL [true campo , false ? ]
     * @return StringSQL
     */
    protected function __createSqlInsert__($table, $columns, $safe = true) {
        $SQL__ = "INSERT INTO $table (" . implode(',', $columns) . ' ) VALUES (';
        if ($safe):
            foreach ($columns as $campos):
                $SQL__.= ":$campos,";
            endforeach;
        else:
            $keys = array_keys($columns);
            $placeholder = str_repeat('?,', count($keys));
            $SQL__.=$placeholder;
        endif;
        return substr($SQL__, 0, -1) . ')';
    }
    
    /**
     * esta funcion genera codigo de tipo UPDATE sql para poder ser usado con las diferentes funciones de dataconexion 
     * aunque recomiendo ser usada ___executeQuery___
     * ________________________________________________________________________________________
     * ejemplo $cols =  array(col1,col2)  => __createSqlInsert('usuarios',$cols,''id='2'',false);
     * salida : UPDATE  usuarios SET col1 = ':col1' where id = 2;
     * 
     * @param String $table
     * @param Array $columns
     * @param String $where
     * @param boolean $safe
     * @return StringSQL
     */

    protected function __createSqlUpdate__($table, $columns, $where, $safe = true) {
        $SQL__ = "UPDATE $table SET ";
        if ($safe):
            foreach ($columns as $campos):
                $SQL__.= "$campos=:$campos,";
            endforeach;
        else:
              foreach ($columns as $campos):
                $SQL__.= "$campos=?,";
            endforeach;
        endif;
        return substr($SQL__, 0, -1) . '  WHERE ' . $where;
    }

}
