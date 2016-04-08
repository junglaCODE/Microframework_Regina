# Microframework_Regina 
**Creado con todas las buenas intenciones de compartir**
- Idea Principal .- Juan Luis Garcia Corrales [ alias @monolinux ]
- Dedicado con todo mi amor hacia mi hija  --Regina Yolotzi Garcia Morales--
- Desde Villagran,Gto. Mexico para el mundo entero
- Deseas Ayudarme correo monolinux@junglacode.org
=====================================================

# ¿ Que es Regina MicroFrameworks ?

Es un proyecto sacado de mi caoticamente mente , abstrayendo las mejoras cosas que he visto a lo largo de vida como programador y 
algunas otras locuras elaborado todas las buenas intenciones de ayudar a toda la comunidad de programadores PHP novatos, ya que de antemano se 
que mi desarrollo no es el mejor de todos pero se que pueden extraer buenas ideas y con su ayuda ; pues uno nunca sabe hasta donde llega el poder de la union. 

Por otro lado quize desarrollar este framework. Por que tenia la necesidad de aprender mas sobre cualidades mas espcificas php y la tecnología PDO.
Este proyecto me dio varias ideas de seguridad , y metodos para agilizar codigo y ademas de buenas practicas. Así que este conocimiento no tenia 
que quedar arrumbado en un parte olvidada de un sector de mi disco duro asi que decidi que lo mejor era compartirlo.

Mas que un framework, que en cierto modo se pretende llegar a ese punto ; Regina es una metodología de desarrollo web, 
que practicamente unifica de una manera mas comoda las vista-controlador ante eventos de tipo ajax. añadiendo una capa 
extra llamada vinculador y de esta manera crear una arquitectura de tipo [ modelo-vista-vinculador-controlador ], 
y estaba enfocada a que los usuarios que iniciaban con php, aprendieran POO de una manera mas rapida y realizar sus pequeños proyectos 
sin tener que entrar en la complejidad de conocer un framework mas complejo como : CodeIgniter , Symfony , Laravel etc...

Ya que nosotros tenemos la firme idea de que conocer las bases de todo un lenguaje es el primer paso para aprender cualquier cosa.

================================================================================

# Requerimientos:
- PHP version 5.x.x en adelante: http://php.net
- Modulo PDO en PHP fuente : http://php.net/manual/es/book.pdo.php
- La conexión hacia base de datos:
  - mysql 5.5.x en adelante
  - mariaDB 10.x.x en adelante

# WÍINKIL
- Esta palabra es significa cuerpo y es de origen maya. 
*En esta sección veremos los directorios principales de regina asi como una pequela descripcion*

-- WÍINKIL PRINCIPAL DE REGINA

**Microframework_Regina**
- __config :: archivos de configuración global de la aplicación a desarrollar
- __librerias :: lugar donde se almacenaran todas las librerias propias del framework como externar.
    - okol_modelos :: palabra maya que significa entrada a modelos, esta libreria es la encargada de estableces la conexión a los diferentes SGDB
        - conectores : interface donde se podran especificar el programador los diferentes conexiones a los gestores de base de datos [mysql,postgresql,sqlite]
        - seguridad   : es una clase que nos ayudara a evitar ataques al motor de base de datos como [sqlinjectión ] ademas de agilización de codigo /*aun no esta completa*/
        - dataconexión : esta es la clase que realmente hace la magia para la conexión solo necesita construir el dns.
- __testing__ :: lugar donde se debugeara las clases, se puede borrar el directorio ya que puede estar propensa a errores

--------------------------------------------------------------------------------
** Ejemplo simple de conexion  :D **
class testing_dataconexion extends Conexion_Databases {

    function __construct() {
        parent::__setConnectionToDB__();
    }
    
    public function  setDatosTable(){
        parent::___executePdo___('select * from new_table');
        $table = $this->__PDO->fetchAll();
        var_dump($table);
    }
    }
--------------------------------------------------------------------------------

--------------------------------------------------------------------------------
** Ejemplo de una inserccion  :D **
class testing_dataconexion extends Conexion_Databases {

    function __construct() {
        parent::__setConnectionToDB__();
    }

     public function __insertDatosTable() {
        $_SQL_ = "INSERT INTO `new_table` (`edad`, `nombre`) VALUES (2 ,'regina')";
        return parent::___execQuery___($_SQL_);
    }

     public function __createSQLUpdate(){
        $sql =  parent::__createSqlUpdate__($this->__TABLE['name'],  array_slice($this->__TABLE['cols'],1,2)
                , $this->__TABLE['cols'][0].'=:id',false); 
        echo parent::___executeQuery___($sql, array(10001,'@monolinux',':id'=>2));
    }
    }
--------------------------------------------------------------------------------
Genial no crees :)