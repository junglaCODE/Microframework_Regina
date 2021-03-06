<?php
/**
 * descripcion .- Este archivo contiene los diferentes tipos de conectores de base de datos los cuales 
 * se implementaran en dataconexion.inc.php #se debe tener cuidado en las rutas del requiere o include
 * http://php.net/manual/es/language.oop5.interfaces.php
 * 
 *@fecha .- 7-abril/2016
 *@autor: JLGC @monolinux
 *@email: monolinux@junglacode.org
 *@web:   reginas.junglacode.org
 */
header("Content-Type: text/html;charset=utf-8"); //codificación del archivo
interface Conectores_Databases {
    /*definir  los parametros de conexion*/
    const __ParametrosConexion = '{"user":"root","pass":"junglacode","bd":"prueba","server":"localhost","port":3306}'; 
    public function __conectorMysql($dsn);
//    public function __conectorPostgresql($dns);
//    public function __conectorSqlite($dns);
}
