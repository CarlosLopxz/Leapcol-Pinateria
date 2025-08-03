<?php
/**
 * Script de prueba para verificar el sistema de permisos
 * Ejecutar desde el navegador: http://localhost/Leapcol-Pinateria/test_permisos.php
 */

require_once "Config/config.php";
require_once "Helpers/Helpers.php";
require_once "Libraries/Core/Mysql.php";

// Iniciar sesión
session_start();

echo "<h2>Test del Sistema de Permisos</h2>";

// Verificar estructura de base de datos
$mysql = new Mysql();

echo "<h3>1. Verificando estructura de base de datos:</h3>";

// Verificar tabla roles
$roles = $mysql->select_all("SELECT * FROM roles WHERE estado = 1");
echo "<strong>Roles encontrados:</strong><br>";
foreach($roles as $rol) {
    echo "- ID: {$rol['idrol']}, Nombre: {$rol['nombrerol']}<br>";
}

// Verificar tabla modulos
$modulos = $mysql->select_all("SELECT * FROM modulos WHERE estado = 1");
echo "<br><strong>Módulos encontrados:</strong><br>";
foreach($modulos as $modulo) {
    echo "- ID: {$modulo['id']}, Nombre: {$modulo['nombre']}, URL: {$modulo['url']}<br>";
}

// Verificar tabla permisos
$permisos = $mysql->select_all("SELECT p.*, r.nombrerol, m.nombre as modulo_nombre FROM permisos p 
                                INNER JOIN roles r ON p.rol_id = r.idrol 
                                INNER JOIN modulos m ON p.modulo_id = m.id");
echo "<br><strong>Permisos asignados:</strong><br>";
foreach($permisos as $permiso) {
    echo "- Rol: {$permiso['nombrerol']} -> Módulo: {$permiso['modulo_nombre']}<br>";
}

echo "<h3>2. Probando funciones de permisos:</h3>";

// Simular usuario administrador
$_SESSION['userData'] = [
    'idusuario' => 3,
    'nombre' => 'Admin',
    'apellido' => 'Test',
    'idrol' => 1,
    'nombrerol' => 'Administrador'
];

echo "<strong>Usuario Administrador (Rol 1):</strong><br>";
echo "- Permiso para 'productos': " . (hasPermission('productos') ? 'SÍ' : 'NO') . "<br>";
echo "- Permiso para 'ventas': " . (hasPermission('ventas') ? 'SÍ' : 'NO') . "<br>";
echo "- Permiso para 'usuarios': " . (hasPermission('usuarios') ? 'SÍ' : 'NO') . "<br>";

// Simular usuario con rol limitado
$_SESSION['userData'] = [
    'idusuario' => 8,
    'nombre' => 'Usuario',
    'apellido' => 'Test',
    'idrol' => 2,
    'nombrerol' => 'Prueba'
];

echo "<br><strong>Usuario con Rol 2 (Prueba):</strong><br>";
echo "- Permiso para 'productos': " . (hasPermission('productos') ? 'SÍ' : 'NO') . "<br>";
echo "- Permiso para 'ventas': " . (hasPermission('ventas') ? 'SÍ' : 'NO') . "<br>";
echo "- Permiso para 'usuarios': " . (hasPermission('usuarios') ? 'SÍ' : 'NO') . "<br>";

echo "<h3>3. Probando función getUserModules():</h3>";
$userModules = getUserModules();
echo "<strong>Módulos disponibles para el usuario actual:</strong><br>";
foreach($userModules as $module) {
    echo "- {$module['nombre']} ({$module['url']})<br>";
}

echo "<br><strong>Test completado!</strong>";
?>