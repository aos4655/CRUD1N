<?php

use App\Db\Articulos;
use App\Db\Categorias;

require_once __DIR__."/../vendor/autoload.php";
Categorias::generarCategorias(5);
Articulos::generarArticulos(25);
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
    <h3 class="text-xl text-center my-2 pt-8">SELECCIONA</h3>
    <ul class="flex mt-4 w-3/4 mx-auto" style="align-items: center; justify-content: center; padding-top: 18%">
        <li class="mr-16">
            <a class="text-blue-500 hover:text-blue-800" href="./articulos/index.php"><i class="fa-regular fa-newspaper"></i> Articulos</a>
        </li>
        <li class="mr-6">
            <a class="text-blue-500 hover:text-blue-800" href="./categorias/index.php"><i class="fa-solid fa-list"></i> Categorias</a>
        </li>
    </ul>
</body>

</html>