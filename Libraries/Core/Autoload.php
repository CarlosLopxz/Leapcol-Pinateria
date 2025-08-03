<?php
// Cargar clases principales primero
require_once "Libraries/Core/Conexion.php";
require_once "Libraries/Core/Mysql.php";
require_once "Libraries/Core/Controllers.php";
require_once "Libraries/Core/Views.php";
require_once "Libraries/Core/AuthController.php";

spl_autoload_register(function ($class) {
    if (file_exists("Libraries/" . 'Core/' . $class . ".php")) {
        require_once ("Libraries/" . 'Core/' . $class . ".php");
    }
    if (file_exists("Models/" . $class . ".php")) {
        require_once ("Models/" . $class . ".php");
    }
});