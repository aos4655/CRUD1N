<?php

use App\Db\Articulos;
use App\Db\Categorias;
use App\Utils\Utilidades;

use const App\Utils\MAY_ON;

session_start();
require_once __DIR__ . "/../../vendor/autoload.php";

$categorias = Categorias::read();
$idCategorias = Categorias::idCategorias();
//He cargado todo, falta comprobar antes de hacer update
if (isset($_POST['btn'])) {
    $nombre = Utilidades::sanearTexto($_POST['nombre'], MAY_ON);
    $precio = Utilidades::sanearTexto($_POST['precio']);
    $disponible = (isset($_POST['disponible'])) ? 'SI' : 'NO'; //Envia por post si esta chequeado
    $categoria = (int) $_POST['categoria'];

    $errores = false;
    if (!Utilidades::comprobarTexto("Nombre", $nombre, 20)) {
        $errores = true;
    }
    if (!Utilidades::comprobarPrecio($precio)) {
        $errores = true;
    }
    if (!Utilidades::comprobarIdCategoria($categoria, $idCategorias)) {
        $errores = true;
    }
    $imagen = "img/articulos/default.png";
    if (is_uploaded_file($_FILES['imagen']['tmp_name'])) {
        if (Utilidades::comprobarImagen($_FILES['imagen']['type'], $_FILES['imagen']['size'])) {
            $ruta = "./../";
            $imagen = "img/articulos/" . uniqid() . "_" . $_FILES['imagen']['name'];
            if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta . $imagen)) {
                $_SESSION['errImagen'] = "Error al mover la imagen";
                $errores = true;
            }
        } else {
            $errores = true;
        }
    }
    if ($errores) {
        header("Location:{$_SERVER['PHP_SELF']}");
        die();
    }
    (new Articulos)->setNombre($nombre)
        ->setPrecio($precio)
        ->setDisponible($disponible)
        ->setCategoria($categoria)
        ->setImagen($imagen)
        ->create();
    $_SESSION['mensaje'] = "Articulo creado con exito";
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
                <a class="text-blue-500 hover:text-blue-800" href='index.php'><i class='fa-regular fa-newspaper'></i> Articulos</a>
            </li>
            <li class="mr-6">
                <a class="text-blue-500 hover:text-blue-800" href='../index.php'><i class='fas fa-home'></i> Home</a>
            </li>
        </ul> <!----------------------------------------------------- FIN NAV BAR -->
        <h3 class="text-2xl text-center mt-4">Crear Articulo</h3>
        <div class="w-3/4 mx-auto p-6 rounded-xl bg-gray-400">
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
                <div class="mb-6">
                    <label for="nombre" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Nombre</label>
                    <input type="text" placeholder="Nombre..." name="nombre" id="nombre" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <?php
                    Utilidades::mostrarError("errNombre");
                    ?>
                </div>
                <div class="mb-6">
                    <label for="desc" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Disponible</label>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-300 mr-2">
                                No
                            </span>
                            <div class="relative">
                                <input type="checkbox" name="disponible" value="j" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                            </div>
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-300 ml-2">
                                Si
                            </span>
                        </label>

                    </label>

                </div>
                <div class="mb-6">
                    <label for="precio" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Precio</label>
                    <input type="text" name="precio" id="precio" placeholder="0.00-100.00..." class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <?php
                    Utilidades::mostrarError("errPrecio");
                    ?>
                </div>
                <div class="mb-6">
                    <label for="categoria" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Categoria</label>
                    <select name="categoria" id="categoria" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <?php
                        foreach ($categorias as $categoria) {
                            echo <<<TXT
                                <option value="{$categoria->id}">{$categoria->nombre}</option>
                                TXT;
                        }
                        ?>
                    </select>
                    <?php
                    Utilidades::mostrarError("errCategoria");
                    ?>
                </div>
                <div class="mb-6">
                    <div class="flex w-full">
                        <div class="w-1/2 mr-2">
                            <label for="imagen" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                IMAGEN</label>
                            <input type="file" id="imagen" oninput="img.src=window.URL.createObjectURL(this.files[0])" name="imagen" accept="image/*" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                            <?php
                            Utilidades::mostrarError("errImagen");
                            ?>
                        </div>
                        <div class="w-1/2">
                            <img src="../img/articulos/default.png" class="h-72 rounded w-full object-cover border-4 border-black" id="img">
                        </div>
                    </div>

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