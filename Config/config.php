<?php

// URL base de la aplicación (ajústala si está en subcarpeta, por ejemplo: /Leapcol-Pinateria/)
define('BASE_URL', 'https://pinateria.comeya.xyz/');

// Zona horaria
date_default_timezone_set('America/Bogota');

// Configuración de la base de datos en el servidor (CWP)
define('DB_HOST', 'localhost');
define('DB_USER', 'comeyax_carlos');
define('DB_PASSWORD', 'tjWbWiOLVPO');
define('DB_NAME', 'comeyax_pinate');
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