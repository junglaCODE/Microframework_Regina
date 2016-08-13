<?php

/*
 * Este test probara la funcionalidad de la plantilla aplicada en las vistas
 * esto para poner los elementos correctos de dicha app
 * ademas analizamos que onda con los jutsos
 */

require_once '../__librerias/main_page/estructura_page.inc.php';
include_once '../__librerias/main_page/plantilla.inc.php';
include_once '../__librerias/jutsus.inc.php';
/*simulador de una plantilla basica html*/
class view_example  implements Plantilla_Views {

    public static function loadLibreriasJs() {
        
    }

    public static function loadStyleSheets() {
        
    }

    public static function titlePage() {
        echo '<title>hola mundo desde regina</title>';
    }

}

//view_example::titlePage();
//var_dump(Jutsus_Ninjas::decodificaSerialize(
//        'gfe_rd=cr&ei=N-lrV4_VAoWz8weW4IGgCg&gws_rd=ssl&q=serialize+jquery',true));
//
//echo 'convetir => '.Jutsus_Ninjas::convertCodingJson('@',true);
//echo 'convertir => '. Jutsus_Ninjas::convertCodingJson('%2F');

echo 'url =>'.Jutsus_Ninjas::getThisURL();
var_dump(Jutsus_Ninjas::getDirURl());