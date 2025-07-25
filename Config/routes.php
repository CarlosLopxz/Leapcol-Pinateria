<?php
/**
 * Configuración de rutas
 */

// Rutas que requieren autenticación
$protected_routes = [
    'dashboard',
    'usuarios',
    'productos',
    'clientes',
    'ventas',
    'reportes',
    'configuracion',
    'categorias',
    'eventos',
    'produccion',
    'roles',
    'caja'
];

// Rutas públicas
$public_routes = [
    'login',
    'register',
    'recover',
    'error'
];