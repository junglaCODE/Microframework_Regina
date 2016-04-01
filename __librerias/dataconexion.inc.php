<?php

/* creación :
 *         06-octubre-2014
 * @autor: JLGC @monolinux
 * @email: reginas@junglacode.org
 * @web:   reginas.junglacode.org
 * Descripcion:
 *         Clase que establece la conexion hacia la base de datos mediante un
 * DSN que es proporcionado con los parametros de la clase abstracta del mismo nombre
 * Esta conexión esta hecho con la interface PDO de php
 * https://es.wikipedia.org/wiki/Data_Source_Name
 * http://php.net/manual/es/book.pdo.php
 */
header("Content-Type: text/html;charset=utf-8"); //encabezado para el tipo de codificación

require_once __DIR__ . '/../__config/config_app.php';

class Conexion_Databases {

    const __VERSION__ = '1.0';

    private $__CONEXION = null; /* Establece un canal de comunicación con el BD atravez del DSN */
    protected $__PDO = null; /* Objeto de tipo PDO que se crea si la conexion es exitosa */
    protected $__PARAMETROS = null; /* Arreglo de configuraciones basadas en el json de config_app */

    /**
     * funcion de tipo void que carga el variable global __PARAMETROS apartir del driver de
     * del archivo config_app que es un variable de in => json out => array 
     * 
     * @param String $driver 
     */
    protected function __loadingParametros__($driver) {
        switch (strtolower($driver)):
            case 'mysql':
                return (json_decode(__MySQL__)) ? json_decode(__MySQL__) : 'parametros json incorrectos';
            default:
                print 'driver no encontrado :(';
        endswitch;
    }
    
    /**
     * funcion tipo que puede ayudar al desarrollador a ver el funcionamiento de dicha
     * clase como tambien el testar los parametros de conexion; todas las salidas
     * son informativas.
     * 
     * @param string $comando para reabar informacion
     * @param type $driver el driver a tester
     */

    static function consoleDebug($comando, $driver = __DRIVER__) {        
        switch ($comando):
            case 'info':
                print_r(self::__loadingParametros__($driver));
                break;
            case 'version':
                print 'Microframework Reginas Clase [ '.__CLASS__.' version '.self::__VERSION__ . ' ]';
                break;
            default :
                print 'Opcion no permitida :(';
        endswitch;
    }

//visualiza el mensaje de parametros de conexion

    protected function __establecerConexion__() {
        list($recurso__, $usuario__, $password__) = parent::__estructuraDSN__();
        /* genera una lista de parametros apartir del dsn de la clase de parametros */
        try {//establece la conexion
            $this->__CONEXION = new PDO($recurso__, $usuario__, $password__, array(PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
            return 'Su conexión has sido satisfactoria' . PHP_EOL . $this->showDataconnection__(__DEBUG__);
        } catch (PDOException $error) { //en caso que no se conecte manda los parametros
            return $this->tipoErrores__('Existe un problema al intertar conectarse', $error);
        }//fin del trycatch
    }

//esta función establece la conexion hacia la base de datos

    protected function __comprobarConexion__() {
        $log = $this->__establecerConexion__();
        if (is_object($this->__CONEXION)):
            print $log; //salidas de errores
            $this->__desconectarConexion__();
        else:
            print $log; // salida de errores
            exit(); // termino del script
        endif;
    }

//fin de la fincion de comprobacion de conexiones

    private function tipoErrores__($mensaje/* string */, $excepcion /* objeto */) {
        if (__DEBUG__)://si el debug esta en false entonces no se mostrar errores de forma tester
            return
                    'Error en el script ' . $excepcion->getFile() . ' en la linea ' . $excepcion->getLine() . PHP_EOL .
                    'Mensaje ' . $excepcion->getMessage() . PHP_EOL .
                    $excepcion->getTraceAsString() . PHP_EOL;
        else:
            return
                    $mensaje . PHP_EOL . $this->showDataconnection__(__DEBUG__);
        endif;
    }

//fin de la funcion tipo de errores

    protected function ___executeSqlPdo___($consulta /* consulta SQL tipo String */) {
        if (!is_object($this->__CONEXION)) {
            print 'No existe un objeto de tipo conexion, compruebe los parametros de conexión'
                    . PHP_EOL . $this->showDataconnection__(__DEBUG__);
            exit();
        }// evitando salidas fallidas del conector de la base datos
        $this->__PDO = $this->__CONEXION->prepare($consulta);
        //crea un conector de tipo PDO atravez de la conexion del dns
        try {
            return $this->__PDO->execute(); //ejecuta todas los los querys y crea el objeto de dicha consulta
            /* envia el apuntador PDO con toda la información de la consulta */
        }//atrapando errores
        catch (PDOException $error) {
            return $this->tipoErrores__('No existe un objeto de tipo conexion, compruebe los parametros de conexión', $error);
        }//fin de trycatch
    }

//fin de la funcion que ejecuta Consultas realizadas con SQL y alterar sus respuestas atravez del objeto PDO

    protected function ___extraccionQuery___($consulta/* consulta SQL tipo String */) {
        if (!is_object($this->__CONEXION)) {
            print 'No existe un conector PDO, quizá debería comprobar los parametros de conexión'
                    . PHP_EOL . $this->showDataconnection__(__DEBUG__);
            exit();
        }// evitando salidas fallidas del conector de la base datos
        try {
            return $this->__CONEXION->query($consulta/* consulta SQL tipo String */);
        } catch (PDOException $error) {
            return $this->tipoErrores__('Existe un problema con la ejecución de la consulta , verifique el codigo SQL enviado', $error);
        }//fin de trycatch
    }

    /* este metodo devuelve un array con lo que se tiene */

// funcion para extraer información de las tablas en arreglo

    protected function ___execQuery___($statement/* consulta SQL tipo String */) {
        if (!is_object($this->__CONEXION)) {
            print 'No existe un conector PDO, quizá debería comprobar los parametros de conexión'
                    . PHP_EOL . $this->showDataconnection__(__DEBUG__);
            exit();
        }// evitando salidas fallidas del conector de la base datos
        try {
            return $this->__CONEXION->exec($statement/* consulta SQL tipo String */);
        } catch (PDOException $error) {
            return $this->tipoErrores__('Existe un problema con la ejecución de la consulta , verifique el codigo SQL enviado', $error);
        }//fin de trycatch
    }

//ejecuta CRUD de manera rapida sin alterarlas con el PDO devuelve lo que modifico en las tablas

    /* Metodos sin implementar */

    protected function ___ejecutaTransacciones__($sql, $insert) {
        if (!is_object($this->__CONEXION)) {
            print 'No existe un conector PDO, quizá debería comprobar los parametros de conexión'
                    . PHP_EOL . $this->showDataconnection__(__DEBUG__);
            exit();
        }// evitando salidas fallidas del conector de la base datos
        try {
            $__SQL__ = $this->__CONEXION->prepare($sql);
            return $__SQL__->execute($insert);
        } catch (PDOException $error) {
            return $this->tipoErrores__('Existe un problema con la ejecución de la consulta , verifique el codigo SQL enviado', $error);
        }//fin de trycatch
    }

    /* metodos sin implementar */

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

    /* Estas metodos sirve para modificar los parametros de conexion en caso que se quiera hacer
      peticiones ha otra base de datos */

    protected function __setBaseDatos__($basedatos /* string */) {
        $this->__BD = $basedatos;
    }

//fin de clase setbasedatos

    protected function __setPassword__($password /* string */) {
        $this->__PASSW = $password;
    }

//fin de clase setpassword

    protected function __setPuerto__($puerto /* string */) {
        $this->__PORT = $puerto;
    }

//fin de clase setpuerto

    protected function __setServidor__($servidor /* string */) {
        $this->__SERVER = $servidor;
    }

//fin de clase setservidor

    protected function __setUsuario__($usuario /* string */) {
        $this->__USER = $usuario;
    }

//fin de clase setusuario
    //Metodos abstractos de la clase Parametros Conexion

    protected function __desconectarConexion__() {
        unset($this->__CONEXION);
        unset($this->__PDO);
    }

//fin de la funcion desconectar
}

//Fin De La Clase Conexion Base de datos