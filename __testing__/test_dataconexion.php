<?php

/*
 * testeando la funcion de loadingParametros la cual se encarga de generar
 * el arreglo de parametros apartir del json establecido en config_app
 * $conexion = new Conexion_Databases();
 * $conexion->__loadingParametros__(); /para esto se debe cambiar la privacidad de la funcion
 */

require __DIR__ . '/../__librerias/okol_modelos/dataconexion.inc.php';

class testing_dataconexion extends Conexion_Databases {

    protected $__TABLE = array('name'=>'new_table', 'cols'=>array('id_yeah','edad','nombre'));
    /*estructura de la tabla*/
    
    function __construct() {
        parent::__setConnectionToDB__();
    }

    public function __setDatosTable() {
        parent::___executePdo___('select * from new_table');
        $table = $this->__PDO->fetchAll(PDO::FETCH_NUM);
        var_dump($table);
        foreach ($table as $rows):
            echo $rows[0] . '----' . $rows[1] . '----' . $rows[2] . '\n';
        endforeach;
    }

    public function __insertDatosTable() {
        $_SQL_ = "INSERT INTO `new_table` (`edad`, `nombre`) VALUES (2 ,'regina')";
        return parent::___execQuery___($_SQL_);
    }

    public function __getDatosTable() {
        $__console__ = parent::___extractionQuery___('select * from new_table', PDO::FETCH_OBJ);
        foreach ($__console__ as $row):
            var_dump($row->nombre);
        endforeach;
    }

    public function __insertDatosSecure($edad, $nombre) {
        try {
            $sql = "INSERT INTO new_table(edad,nombre) VALUES (:edad,:nombre)";
            parent::___createObjPDO___($sql);
            $this->__PDO->bindValue(':edad', $edad);
            $this->__PDO->bindValue(':nombre', htmlentities($nombre));
            $this->__PDO->execute();
            echo $this->__PDO->rowCount() .' registro actualizado en la base de datos';
        } catch (Exception $error) {
            echo $error->getMessage();
        }
    }
    
    public function __createSQLINSERT(){
        echo parent::__createSqlInsert__($this->__TABLE['name'],$this->__TABLE['cols']);
        /*esto es con variables*/
        echo parent::__createSqlInsert__($this->__TABLE['name'],$this->__TABLE['cols'], false);
        /*esto es con simbolos*/
    }

    public function __createSQLUpdate(){
        $sql =  parent::__createSqlUpdate__($this->__TABLE['name'],  array_slice($this->__TABLE['cols'],1,2)
                , $this->__TABLE['cols'][0].'=:id',false); 
        echo parent::___executeQuery___($sql, array(10001,'@monolinux',':id'=>2));
    }
}

$obj = new testing_dataconexion();
//$obj->__setDatosTable();
//echo 'registros insertados ' . $obj->__insertDatosTable();
//$obj->__insertDatosSecure('78', '<strong>Regina Garcia Vasquez</strong>');
//$obj->__getDatosTable();
//$obj->__createSQLINSERT();
$obj->__createSQLUpdate();

