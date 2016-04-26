<?php

/* 
* somos parte de la realidad que contiene mas mentiras que verdades @monolinux
* Pruebas unitarias para la creacion de una plantilla
 */
require __DIR__.'/../__librerias/main_page/widgets_html.class.php';
echo Widgets_Html::rWinputText('{"id":"demo","class":"red" , "onclick":"alert(1)"}');