<?php

namespace App\Db;

use PDO;
use PDOException;

class Conexion
{
    protected static $conexion; 
    /* Creo el constructor */
    public function __construct()
    {
        self::setConexion();
    }
    public static function setConexion()
    {
        if (self::$conexion != null) return; //Si ya hay una conexion abierta, no se puede abrir otra
        /* Cargo librerias de PHP */
        $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__."/../../");
        $dotenv->load();
        $user = $_ENV['USER'];
        $pass = $_ENV['PASS'];
        $host = $_ENV['HOST'];
        $db = $_ENV['DB'];
        /* Me creo una variable donde guarde el nombre del descriptor de servicio */
        $dsn = "mysql:$host=localhost;dbname=$db;chaset=utf8mb4";
        $opciones = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
        /* Intentaremos realizar la conexion, si falla mostrara un mensaje de error */
        try {
            self::$conexion = new PDO($dsn, $user, $pass, $opciones);
        } catch (PDOException $ex) {
            die("Error en conexion".$ex->getMessage());
        }
    }
}
