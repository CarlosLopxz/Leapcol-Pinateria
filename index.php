<?php
    // Cargamos las configuraciones
    require_once "Config/config.php";
    require_once "Config/routes.php";
    require_once "Helpers/Helpers.php";
    
    // Iniciar sesión
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    // Obtener la URL solicitada
    $url = !empty($_GET['url']) ? $_GET['url'] : 'login';
    $arrUrl = explode("/", $url);
    $controller = $arrUrl[0];
    
    // Verificar si la ruta requiere autenticación
    if (in_array($controller, $protected_routes) && (!isset($_SESSION['login']) || $_SESSION['login'] !== true)) {
        header('Location: ' . BASE_URL . 'login');
        exit();
    }
    
    // Cargamos las librerías principales
    require_once "Libraries/Core/Autoload.php";
    require_once "Libraries/Core/Load.php";
    
    // Inicializamos la aplicación
    $app = new Load();