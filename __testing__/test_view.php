<?php

/*
 * Este test probara la funcionalidad de la plantilla aplicada en las vistas
 * esto para poner los elementos correctos de dicha app
 */

require_once '../__librerias/main_page/estructura_page.inc.php';
include_once '../__librerias/main_page/plantilla.inc.php';

/*simulador de una plantilla basica html*/
class Controlador_Plantila  {

}

class view_example  implements Plantilla_Views {

    public static function loadLibreriasJs() {
        
    }

    public static function loadStyleSheets() {
        
    }

    public static function titlePage() {
        echo '<title>hola mundo desde regina</title>';
    }

}


view_example::titlePage();
