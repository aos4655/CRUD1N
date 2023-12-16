<?php

use App\Db\Articulos;
use App\Db\Categorias;
use App\Utils\Utilidades;

if (!isset($_GET['id'])) {
    header("Location:index.php");
    die();
}
$idArticulo = (int) $_GET['id'];
if ($idArticulo == 0) {
    header("Location:index.php");
    die();
}
require_once __DIR__."../../../vendor/autoload.php";

if (!Utilidades::comprobarIdCategoria($idArticulo, Articulos::read())) {
    header("Location:index.php");
    die();
}
$articulo = Articulos::read($idArticulo);
$nombreCat = (Categorias::read($articulo[0]->category_id))[0]->nombre;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwind css -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Document</title>
</head>

<body style="background-color:blanchedalmond">
    <!-- NAV BAR -->
    <ul class="flex flex-row-reverse mt-4 w-3/4 mx-auto">
        <li class="mr-6">
            <a class="text-blue-500 hover:text-blue-800" href="logout.php"><i class="fa-solid fa-arrow-right-from-bracket"></i> Salir</a>
        </li>
        <li class="mr-6">
            <a class="text-blue-500 hover:text-blue-800" href="index.php"><i class="fas fa-home"></i>Home</a>
        </li>
    </ul>
    <!-- FIN NAV BAR -->
    <h3 class="text-xl text-center my-2">ARTICULO DETALLADO</h3>

    <!-- CARD -->
    <div class="w-1/3 mx-auto bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
        <img class="rounded-t-lg w-full" src="./../<?php echo $articulo[0]->imagen?>" alt="" />
        <div class="p-5">
            <a href="#">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"><?php echo $articulo[0]->nombre?></h5>
            </a>
            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Precio: <?php echo $articulo[0]->precio?></p>
            <p class="mb-3 font-normal text-blue-700 dark:text-blue-400">Categoria: <?php echo $nombreCat ?></p>

        </div>
    </div>
    <!-- FIN CARD -->

</body>

</html>