<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Methods_Hacking {
   

    protected function __createInsertSQL__($datos/* array */, $table/* database */, $safe = false) {
        $VALUES__ = ""; /* datos para ser insertados */
        $SQL__ = "INSERT INTO $table (";
        foreach ($datos as $campos => $values):
            $SQL__.='`' . $campos . '`,';
            $VALUES__.="'$values',";
        endforeach;
        if ($safe):
            $keys = array_keys($datos);
            $placeholder = substr(str_repeat('?,', count($keys)), 0, -1);
        else:
            $placeholder = substr($VALUES__, 0, -1);
        endif;
        return substr($SQL__, 0, -1) . ') VALUES(' . $placeholder . ')';
    }

    protected function __createUpdateSQL__($datos/* array */, $table/* database */, $where) {
        $SQL__ = "UPDATE `$table` SET ";
        foreach ($datos as $campos => $values):
            $SQL__.= "`$campos`='$values',";
        endforeach;
        return substr($SQL__, 0, -1) . ' where ' . $where;
    }
    
}