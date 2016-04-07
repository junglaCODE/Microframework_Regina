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

require_once __DIR__ . '/../../__config/config_app.php';
require_once __DIR__ . '/conectores.php';

class Conexion_Databases implements Conectores_Databases {

    const __VERSION__ = '1.0';

    private $__CONEXION = null; /* Establece un canal de comunicación con el BD atravez del DSN */
    protected $__PDO = null; /* Objeto de tipo PDO que es utilzado para hacer referencias a todas de dicha clase */

    /**
     * funcion de tipo void que carga el variable global __PARAMETROS apartir del driver de
     * del archivo config_app que es un variable de in => json out => array 
     * 
     * @param String $driver 
     */
    protected function __loadingParametros__($driver) {
        $DSN = Conectores_Databases::__ParametrosConexion;  /* construcion del Nombre de Origen de Datos (DSN) */
        switch (strtolower($driver)):
            case 'mysql':
                return self::__conectorMysql($DSN);
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
                if(self::__setConnectionToDB__($driver, __FUNCTION__)):
                    ':) felicidades su conexión ha sido satisfactoria ahora puede interactuar con su base de datos';
                endif;
                break;
            case 'version':
                print 'Microframework Reginas Clase [ ' . __CLASS__ . ' version ' . self::__VERSION__ . ' ]';
                break;
            default :
                print 'Opcion no permitida :(';
        endswitch;
    }

    /**
     *  La funcion pone por default variable global del config_app pero se puede usar cualquier otra en la instancia
     * eso si se esta usando varias bases de datos
     * 
     * @param string $driver  variable que identifica el drivers a usar en la aplicación
     */
    protected function __setConnectionToDB__($driver = __DRIVER__) {
        $__config__ = self::__loadingParametros__($driver);
        /* genera una lista de parametros apartir del json del archivo de configuracion */
        try {//establece la conexion
            $this->__CONEXION = new PDO($__config__['link'][0], $__config__['link'][1], $__config__['link'][2], $__config__['attributes']);
            return true;
        } catch (PDOException $error) { //en caso que no se conecte manda los parametros
            if (__DEBUG__):
                print_r($error);
            else:
                print_r('error -' . $error->getCode() . ' : ' . $error->getFile() . ' linea : ' . $error->getLine()
                        . PHP_EOL . $error->getMessage());
            endif;
        }//fin del trycatch
    }

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
        }// evitando salidas fallidas del conector de la base datosattributes
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

//Metodos abstractos de la clase Parametros Conexion

    protected function __desconectarConexion__() {
        unset($this->__CONEXION);
        unset($this->__PDO);
    }

    public function __conectorMysql($dsn) {
        /* http://php.net/manual/es/ref.pdo-mysql.connection.php */
        if (json_decode($dsn)) :
            $__set = json_decode($dsn);
            $DSN[0] = "mysql:host=" . $__set->{'server'} . ";port=" . $__set->{'port'} . ";dbname=" . $__set->{'bd'};
            $DSN[1] = $__set->{'user'};
            $DSN[2] = $__set->{'pass'};
            return array('link' => $DSN, 'attributes' => array(
                    PDO::ATTR_PERSISTENT => true,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ));
        else:
            print 'parametros json incorrectos';
            exit(); /* saliendo de la librerua cuando el dsn esta mal construido */
        endif;
    }

    public function __conectorPostgresql($dns) {
        
    }

    public function __conectorSqlite($dns) {
        
    }

//fin de la funcion desconectar
}

//Fin De La Clase Conexion Base de datos