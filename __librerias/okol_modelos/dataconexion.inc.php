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
    public function __consoleDebug($comando, $driver = __DRIVER__) {
        switch ($comando):
            case 'info':
                if ($this->__setConnectionToDB__($driver, __FUNCTION__)):
                    print ':) conexión satisfactoria :: show tables  { ' . PHP_EOL;
                    $this->___executePdo___('show tables');
                    var_dump($this->__PDO->fetchALL(PDO::FETCH_COLUMN)) . ' } ';
                    $this->__offConnectionToDB__();
                endif;
                break;
            case 'version':
                print 'Microframework Reginas Clase [ ' . __CLASS__ . ' version ' . self::__VERSION__ . ' ]'.PHP_EOL.
                    '@web = https://github.com/junglaCODE/Microframework_Regina';
                break;
            default :
                print 'error -0 : Opción no permitida :(';
        endswitch;
    }

    /**
     * esta funcion nos permite tracear los errores de nuestras librerias
     * 
     * @param obj $error exepcion genereda con el try catch
     */
    private function consoleErrors__($error) {
        if (__DEBUG__):
            print_r($error);
        else:
            print_r('error -' . $error->getCode() . ' : ' . $error->getFile() . ' linea : ' . $error->getLine()
                    . PHP_EOL . $error->getMessage());
        endif;
    }

    /**
     * esta función sirve para quitar la conexión de preferencia usarla con el __destruct de los controladores
     */
    protected function __offConnectionToDB__() {
        unset($this->__CONEXION);
        unset($this->__PDO);
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
            /* estableciendo el obj de la clase pdo */
        } catch (PDOException $error) { //en caso que no se conecte manda los parametros
            $this->consoleErrors__($error);
        }
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
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"
            ));
        else:
            print 'error -1 : Parametros json incorrectos';
            exit(); /* saliendo de la librerua cuando el dsn esta mal construido */
        endif;
    }

    /* ================Funciones para la interación con la bases de datos=============================== */

    protected function ___executePdo___($consulta /* consulta SQL tipo String */) {
        if (is_object($this->__CONEXION)):
            try {
                $this->__PDO = $this->__CONEXION->prepare($consulta);
                $this->__PDO->execute();
                return true;
                /* envia el apuntador PDO con toda la información de la consulta utilizando el objeto PDO para otras accciones */
            } catch (PDOException $error) {
                $this->consoleErrors__($error);
                return false;
            }//fin de trycatch
        else:
            print 'error -2 : La librería no ha detectado ni una conexión hacia un gestor de base de datos';
        endif;
    }

}

/*Fin De La Clase Conexion Base de datos*/