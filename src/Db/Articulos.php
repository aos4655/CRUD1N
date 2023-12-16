<?php

namespace App\Db;

use PDO;
use PDOException;
/* Todas las clases de nuestra base de datos extenderan de la clase Conexion */
class Articulos extends Conexion{
/* Creamos tantos atributos privados como atributos tuviera la tabla Articulos en mi base de datos */
    private int $id;
    private string $nombre;
    private string $disponible;
    private float $precio;
    private string $imagen;
    private string $categoria;

/* Me creo el constructor, que a su vez llamara al constructor de la clase padre, es decir, Conexion */
    public function __construct()
    {
        parent::__construct();
    }
    //-----------CRUD----------
    public function create(){
        $q = "insert into articulos(nombre, disponible, precio, imagen, category_id) values(:n, :d, :p, :i, :c)";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute([
                ':n'=> $this->nombre,
                ':d' => $this->disponible,
                ':p' => $this->precio,
                ':i' => $this->imagen,
                ':c' => $this->categoria
            ]);
        } catch (PDOException $ex) {
            die("Error en create".$ex->getMessage());
        }
        parent::$conexion=null;
    }
    public static function read(?int $idArticulo=null){
        parent::setConexion();
        $q = ($idArticulo == null) ? "select * from articulos" : "select * from articulos where id=:i";
        $stmt = parent::$conexion->prepare($q);
        try {
            ($idArticulo == null) ? $stmt->execute(): $stmt->execute([':i'=>$idArticulo]);
        } catch (PDOException $ex) {
            die("Error en read".$ex->getMessage());
        }
        parent::$conexion=null;
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    public function update(int $idCat){
        $q = "update articulos set nombre=:n, disponible=:d, precio=:p, imagen=:i, category_id=:c where id=:ic";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute([
                ':n'=> $this->nombre,
                ':d' => $this->disponible,
                ':p' => $this->precio,
                ':i' => $this->imagen,
                ':c' => $this->categoria,
                ':ic' => $idCat
            ]);
        } catch (PDOException $ex) {
            die("Error en update".$ex->getMessage());
        }
        parent::$conexion=null;
    }
    public static function delete(int $idCat){
        parent::setConexion();
        $q = "delete from articulos where id=:i";
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
        $q = "select * from articulos where nombre=:n";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute([':n'=>$nombre]);
        } catch (PDOException $ex) {
            die("Error en existeNombre".$ex->getMessage());
        }
        parent::$conexion=null;
        return $stmt->rowCount();
    }
    //-----------FAKER-----------------------------------
    public static function generarArticulos(int $cantidad){
        if (self::hayArticulos()) return;//Comprobamos que no haya articulos
        $faker = $faker = \Faker\Factory::create("es_ES");//Importamos faker
        $faker->addProvider(new \Mmo\Faker\PicsumProvider($faker));//Añadimos provider de fotos
        for ($i=0; $i < $cantidad; $i++) { 
            $nombre = ucfirst($faker->words(random_int(2,7), true));
            $disponible = $faker->randomElement(["Si", "No"]);
            $precio = $faker->randomFloat(2, 1, 100);
            $imagen = "img/articulos/".$faker->picsum("../public/img/articulos/", 640, 480, false);
            $categoria = $faker->randomElement(Categorias::read())->id;
            (new Articulos)->setNombre($nombre)
            ->setDisponible($disponible)
            ->setPrecio($precio)
            ->setImagen($imagen)
            ->setCategoria($categoria)
            ->create();
        }
    }
    private static function hayArticulos(){
        parent::setConexion();
        $q = "select id from articulos";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            die("Error en hayArticulos".$ex->getMessage());
        }
        parent::$conexion=null;
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

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
     * Set the value of disponible
     */
    public function setDisponible(string $disponible): self
    {
        $this->disponible = $disponible;

        return $this;
    }

    /**
     * Set the value of precio
     */
    public function setPrecio(int $precio): self
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * Set the value of imagen
     */
    public function setImagen(string $imagen): self
    {
        $this->imagen = $imagen;

        return $this;
    }

    /**
     * Set the value of categoria
     */
    public function setCategoria(string $categoria): self
    {
        $this->categoria = $categoria;

        return $this;
    }
}