<?php
    // Cargamos las configuraciones
    require_once "Config/config.php";
    require_once "Helpers/Helpers.php";
    
    // Cargamos las librerías principales
    require_once "Libraries/Core/Autoload.php";
    require_once "Libraries/Core/Load.php";
    
    // Inicializamos la aplicación
    $app = new Load();