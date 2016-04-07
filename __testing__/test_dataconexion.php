<?php
/* 
 * testeando la funcion de loadingParametros la cual se encarga de generar
 * el arreglo de parametros apartir del json establecido en config_app
 * $conexion = new Conexion_Databases();
 * $conexion->__loadingParametros__(); /para esto se debe cambiar la privacidad de la funcion
 */

require __DIR__.'/../__librerias/okol_modelos/dataconexion.inc.php';

class testing_dataconexion extends Conexion_Databases {

    function __construct() {
        parent::__setConnectionToDB__();
    }
    
    public function  __setDatosTable(){
        parent::___executePdo___('select * from new_table');
        $table = $this->__PDO->fetchAll(PDO::FETCH_NUM);
        var_dump($table);
        foreach ($table as $rows):
           echo  $rows[0].'----'.$rows[1].'----'.$rows[2].'\n';
        endforeach;
    }
    
    public function __insertDatosTable(){
        $_SQL_ = "INSERT INTO `new_table` (`edad`, `nombre`) VALUES (34', 'sharely')";
        return parent::___execQuery___($SQL);
    }
    
}

$obj = new testing_dataconexion();
echo 'registros insertados ' . $obj->__insertDatosTable();
$obj->__setDatosTable();

