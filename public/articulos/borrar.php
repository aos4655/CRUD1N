<?php

use App\Db\Articulos;
require_once __DIR__."/../../vendor/autoload.php";

session_start();
$id =(int) $_POST['id'];
if ($id != 0) {
    Articulos::delete($id);
    $_SESSION['mensaje']= "Articulo borrado exitosamente";
}
header("Location:index.php");
?>