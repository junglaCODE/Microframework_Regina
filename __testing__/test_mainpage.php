<?php

/* 
* somos parte de la realidad que contiene mas mentiras que verdades @monolinux
* Pruebas unitarias para la creacion de una plantilla
 */
require __DIR__.'/../__librerias/main_page/widgets_html.class.php';
echo Widgets_Html::rWInput('text','{"id":"demo","name":"red" , "onclick":"alert(1)"}');
echo Widgets_Html::rWInput('password','{"id":"demo","name":"blue"}');
echo Widgets_Html::rWInput('checkbox','{"id":"demo","name":"blue","value":"validar"}');
echo Widgets_Html::rWTextArea('{"name":"comment","cols":"50"}');