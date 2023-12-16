<?php

use App\Db\Categorias;

session_start();
require_once __DIR__."../../../vendor/autoload.php";
$categorias = Categorias::read();
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
            <a class="text-blue-500 hover:text-blue-800" href="../index.php"><i class="fas fa-home"></i>Home</a>
        </li>
    </ul>
    <!-- FIN NAV BAR -->
    <h3 class="text-xl text-center my-2">CATEGORIAS</h3>

    <!-- TABLA CATEGORIAS -->
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <div class=" w-3/4 mx-auto flex flex-row-reverse my-2">
            <a href="nuevo.php" class="mb-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-add">NUEVO</i>
            </a>
        </div>
        <div class=" w-3/4 mx-auto flex flex-row-reverse my-2">
            <table class=" w-3/4 mx-auto  text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Nombre
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Descripcion
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($categorias as $categoria) {
                        echo <<<TXT
                        <tr class=" bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                {$categoria->nombre}
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                            {$categoria->descripcion}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <form action="borrar.php" method="POST">
                                    <input type="hidden" name="id" value="{$categoria->id}" />
                                    <a href="update.php?id={$categoria->id}"><i class="fas fa-edit mx-2"> </i> </a>
                                    <button type="submit"> <i class="fas fa-trash "></i></button>
                                </form>
                            </td>
                        </tr>
                        TXT;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- FIN TABLA CATEGORIAS -->
    <?php
    if (isset($_SESSION['mensaje'])) {
        echo <<<TXT
        <script>
        Swal.fire({
            icon: "success",
            title: "{$_SESSION['mensaje']}",
            showConfirmButton: false,
            timer: 1500
        });
        </script>

        TXT;
        unset($_SESSION['mensaje']);
    }

    ?>
</body>

</html>