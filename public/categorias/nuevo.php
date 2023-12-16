<?php

use App\Db\Categorias;
use App\Utils\Utilidades;

use const App\Utils\MAY_ON;

session_start();
require_once __DIR__ . "../../../vendor/autoload.php";

if (isset($_POST['btn'])) {
    $nombre = Utilidades::sanearTexto($_POST['nombre'], MAY_ON);
    $descripcion = Utilidades::sanearTexto($_POST['descripcion']);

    $errores = false;

    if (!Utilidades::comprobarTexto("Nombre", $nombre, 5)) {
        $errores = true;
    }
    if (!Utilidades::comprobarTexto("Descripcion", $descripcion, 15)) {
        $errores = true;
    }
    if (Categorias::existeNombre($nombre)) {
        $errores = true;
        $_SESSION['errNombre'] = "Ese nombre ya esta en la base de datos";
    }

    if ($errores) {
        header("Location:{$_SERVER['PHP_SELF']}");
        die();
    }

    (new Categorias)->setNombre($nombre)
        ->setDescripcion($descripcion)
        ->create();
    $_SESSION['mensaje']= "Categoria creada con exito";
    header("Location:index.php");
    die();
}
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
    <title>Editar</title>
</head>

<body style="background-color:blanchedalmond">
    <div class="container p-8 mx-auto">
        <!------------------------------------------------------ NAVBAR -->
        <ul class='flex flex-row-reverse mt-2'>
            <li class="mr-6">
                <a class="text-blue-500 hover:text-blue-800" href='index.php'><i class='fa-regular fa-newspaper'></i> Categorias</a>
            </li>
            <li class="mr-6">
                <a class="text-blue-500 hover:text-blue-800" href='../index.php'><i class='fas fa-home'></i> Home</a>
            </li>
        </ul> <!----------------------------------------------------- FIN NAV BAR -->
        <h3 class="text-2xl text-center mt-4">Crear Categoria</h3>
        <div class="w-3/4 mx-auto p-6 rounded-xl bg-gray-400">
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']  ?>" enctype="multipart/form-data">
                <div class="mb-6">
                    <label for="nombre" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Nombre</label>
                    <input type="text" name="nombre" id="nombre"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <?php
                    Utilidades::mostrarError("errNombre");
                    ?>
                </div>
                <div class="mb-6">
                    <label for="descripcion" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Descripcion</label>
                    <textarea name="descripcion" rows='5' id="descripcion" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
                    <?php
                    Utilidades::mostrarError("errDescripcion");
                    ?>
                </div>
                <div class="flex flex-row-reverse">
                    <button type="submit" name="btn" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <i class="fas fa-edit mr-2"></i>CREAR
                    </button>
                    <button type="reset" class="mr-2 text-white bg-yellow-700 hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-blue-800">
                        <i class="fas fa-paintbrush mr-2"></i>LIMPIAR
                    </button>
                    <a href="index.php" class="mr-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-blue-800">
                        <i class="fas fa-backward mr-2"></i>VOLVER
                    </a>
                </div>

            </form>
        </div>
    </div>
    
</body>

</html>