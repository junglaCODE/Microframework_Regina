<?php

/**
 * Descripcion .- interface que incorporara los widgets principales para poder crear una plantilla html
 * apartir de framework como bootsrap , foundation  ó en su  caso cualquier theme 
 * 
 * @author JLGC @monolinux
 * @web reginas.junglacode.org
 * @correo monolinux@junglacode.org
 * @creacion 25-04/2016
 */
header("Content-Type: text/html;charset=utf-8"); //codificación del archivo

interface Structure_Page {
    
    public static function __loadJS__();
    public static function __loadCss__();
    public static function __setMenuLeft__();
    public static function __setMenuRight__();
    public static function __setMenuTop__();
    public static function __setHeader__();
    public static function __setFooter__();
    public static function __setMetas__();
    public static function __setContainer__($views);
    
}