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

interface estructura_page {
    public function __loadJS();
    public function __loadCss();
    public function __setMenuLeft();
    public function __setMenuRight();
    public function __setMenuTop();
    public function __setHeader();
    public function __setFooter();
    public function __setMetas();
    public function __setContainer($views);
}