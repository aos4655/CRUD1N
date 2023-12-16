<?php

namespace App\Db;

use PDO;
use PDOException;
/* Todas las clases de nuestra base de datos extenderan de la clase Conexion */
class Categorias extends Conexion{
/* Creamos tantos atributos privados como atributos tuviera la tabla Articulos en mi base de datos */
    private int $id;
    private string $nombre;
    private string $descripcion;
/* Me creo el constructor, que a su vez llamara al constructor de la clase padre, es decir, Conexion */
    public function __construct()
    {
        parent::__construct();
    }
    //-----------CRUD----------
    public function create(){
        $q = "insert into categorias(nombre, descripcion) values(:n, :d)";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute([
                ':n'=> $this->nombre,
                ':d' => $this->descripcion
            ]);
        } catch (PDOException $ex) {
            die("Error en create".$ex->getMessage());
        }
        parent::$conexion=null;
    }
    public static function read(?int $idArticulo = null){
        parent::setConexion();
        $q =($idArticulo == null)? "select * from categorias": "select * from categorias where id=:i";
        $stmt = parent::$conexion->prepare($q);
        try {
            ($idArticulo == null)?$stmt->execute():$stmt->execute([':i'=>$idArticulo]);
        } catch (PDOException $ex) {
            die("Error en read".$ex->getMessage());
        }
        parent::$conexion=null;
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    public function update(int $idCat){
        $q = "update categorias set nombre=:n, descripcion=:d where id=:i";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute([
                ':n'=> $this->nombre,
                ':d' => $this->descripcion,
                ':i' => $idCat
            ]);
        } catch (PDOException $ex) {
            die("Error en update".$ex->getMessage());
        }
        parent::$conexion=null;
    }
    public static function delete(int $idCat){
        parent::setConexion();
        $q = "delete from categorias where id=:i";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute([
                ':i' => $idCat
            ]); 
        } catch (PDOException $ex) {
            die("Error en delete".$ex->getMessage());
        }
        parent::$conexion=null;
    }
    public static function existeNombre(string $nombre){
        parent::setConexion();
        $q = "select * from categorias where nombre=:n";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute([':n'=>$nombre]);
        } catch (PDOException $ex) {
            die("Error en existeNombre".$ex->getMessage());
        }
        parent::$conexion=null;
        return $stmt->rowCount();
    }
    //---------------FAKER------------

    public static function generarCategorias(int $cantidad){
        if (self::hayCategorias()) return;
        $faker = \Faker\Factory::create('es_ES');
        for ($i=0; $i <$cantidad ; $i++) { 
            $nombre = ucfirst($faker->words(random_int(2,5), true));
            $descripcion = $faker->text();
            (new Categorias)->setNombre($nombre)
            ->setDescripcion($descripcion)
            ->create();
        }
    }
    private static function hayCategorias():bool{
        parent::setConexion();
        $q = "select id from categorias";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            die("Error en hayCategorias".$ex->getMessage());
        }
        parent::$conexion=null;
        return $stmt->rowCount();
    }
    public static function idCategorias(){
        parent::setConexion();
        $q = "select id from categorias";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            die("Error en idCategorias".$ex->getMessage());
        }
        parent::$conexion=null;
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    //---------------SETTERS---------

    /**
     * Set the value of id
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set the value of nombre
     */
    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Set the value of descripcion
     */
    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }
}