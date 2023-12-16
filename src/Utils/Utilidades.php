<?php
namespace App\Utils;
require_once __DIR__."/../../vendor/autoload.php";
const MAY_ON = 1;
const MAY_OFF = 0;

class Utilidades{
    public static array $tiposImagen = [
        'image/jpeg',
        'image/gif', 
        'image/png', 
        'image/jpeg', 
        'image/bmp', 
        'image/webp',
        'image/x-icon',
        'image/svg+xml'
    ];
    public static function sanearTexto(string $texto, $mode = MAY_OFF){
        return ($mode == MAY_ON) ? ucfirst(htmlspecialchars(trim($texto))) : htmlspecialchars(trim($texto)); 
    }
    public static function comprobarTexto(string $nombre, string $valor, int $longitud){
        if (strlen($valor)<$longitud) {
            $_SESSION['err'.$nombre] = "El $nombre debe tener una longitud de al menos $longitud carcateres";
            return false;
        }
        return true;
    }
    public static function comprobarPrecio(string $valor){
        if ($valor<1.00 || $valor>100.00) {
            $_SESSION['errPrecio'] = "El precio debe debe estar entre 1.00 y 100.00";
            return false;
        }
        return true;
    }
    public static function comprobarImagen(string $tipo, string $tamanio){
        if (!in_array($tipo , self::$tiposImagen)) {
            $_SESSION['errImagen'] = "No se ha subido un archivo de tipo imagen";
            return false;
        }
        if ($tamanio>2000000) {
            $_SESSION['errImagen'] = "El tamanio de la imagen excede los 2MB";
            return false;
        }
        return true;
    }
    public static function comprobarIdCategoria(int $idCategoria, array $arrayCategorias){
        foreach ($arrayCategorias as $categoria) {
            if ((int)$categoria->id == $idCategoria) {
                return true;
            }
        }
        $_SESSION["errCategoria"] = "La categoria introducida no es valida";
        return false;
    }
    public static function mostrarError(string $nombre){
        if (isset($_SESSION[$nombre])) {
            echo "<p class = 'text-red-700 italic'>{$_SESSION[$nombre]}</p>";
            unset($_SESSION[$nombre]);
        }
    }
}