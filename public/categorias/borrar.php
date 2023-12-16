<?php

use App\Db\Categorias;
require_once __DIR__."/../../vendor/autoload.php";
session_start();
$id =(int) $_POST['id'];
if ($id != 0) {
    Categorias::delete($id);
    $_SESSION['mensaje']= "Categoria borrada exitosamente";
}
header("Location:index.php");
?>