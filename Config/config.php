<?php

// URL base de la aplicación
define('BASE_URL', 'http://localhost/Leapcol-Pinateria/');

// Zona horaria
date_default_timezone_set('America/Bogota');

// Configuración de la base de datos
define('DB_HOST', 'localhost:3306');     
define('DB_USER', 'root');          
define('DB_PASSWORD', '');          
define('DB_NAME', 'pinateria');     
define('DB_CHARSET', 'utf8mb4');    

// Datos de la empresa
define('NOMBRE_EMPRESA', 'Piñatería');
define('DIRECCION', 'Dirección de la empresa');
define('TELEFONO', '123456789');
define('EMAIL', 'info@pinateria.com');

// Delimitadores decimal y millar
define('SPD', '.');
define('SPM', ',');

// Símbolo de moneda
define('SMONEY', '$');