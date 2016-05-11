<?php
/*
 * @Descripcion: este archivo contiene toda la estructura principal que debe tener una vista para ser
 * implementada en el contenedor html ; este archivo puede ser editable para ajustarlo
 * aun patron mas estico para sus aplicaciones
 * 
 * =======================================================================
 * @author JLGC @monolinux
 * @correo monolinux@junglacode.org
 * @web [reginas.junglacode.org]
 * @fecha  5-mayo/2016
 */

interface Plantilla_Views {
    
public static function loadLibreriasJs();
public static function loadStyleSheets();
public static function titlePage();

}
