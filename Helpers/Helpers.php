<?php
/**
 * Archivo de funciones auxiliares
 */

// Función para depurar
function dep($data)
{
    $format = print_r('<pre>');
    $format .= print_r($data);
    $format .= print_r('</pre>');
    return $format;
}

// Función para limpiar cadenas
function strClean($strCadena)
{
    $string = preg_replace(['/\s+/', '/^\s|\s$/'], [' ', ''], $strCadena);
    $string = trim($string);
    $string = stripslashes($string);
    $string = str_ireplace("<script>", "", $string);
    $string = str_ireplace("</script>", "", $string);
    $string = str_ireplace("<script src", "", $string);
    $string = str_ireplace("<script type=", "", $string);
    $string = str_ireplace("SELECT * FROM", "", $string);
    $string = str_ireplace("DELETE FROM", "", $string);
    $string = str_ireplace("INSERT INTO", "", $string);
    $string = str_ireplace("SELECT COUNT(*) FROM", "", $string);
    $string = str_ireplace("DROP TABLE", "", $string);
    $string = str_ireplace("OR '1'='1", "", $string);
    $string = str_ireplace('OR "1"="1"', "", $string);
    $string = str_ireplace('OR ´1´=´1´', "", $string);
    $string = str_ireplace("is NULL; --", "", $string);
    $string = str_ireplace("is NULL; --", "", $string);
    $string = str_ireplace("LIKE '", "", $string);
    $string = str_ireplace('LIKE "', "", $string);
    $string = str_ireplace("LIKE ´", "", $string);
    $string = str_ireplace("OR 'a'='a", "", $string);
    $string = str_ireplace('OR "a"="a', "", $string);
    $string = str_ireplace("OR ´a´=´a", "", $string);
    $string = str_ireplace("OR ´a´=´a", "", $string);
    $string = str_ireplace("--", "", $string);
    $string = str_ireplace("^", "", $string);
    $string = str_ireplace("[", "", $string);
    $string = str_ireplace("]", "", $string);
    $string = str_ireplace("==", "", $string);
    return $string;
}

// Función para generar una contraseña aleatoria
function passGenerator($length = 10)
{
    $pass = "";
    $longitudPass = $length;
    $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
    $longitudCadena = strlen($cadena);

    for ($i = 1; $i <= $longitudPass; $i++) {
        $pos = rand(0, $longitudCadena - 1);
        $pass .= substr($cadena, $pos, 1);
    }
    return $pass;
}

// Función para generar un token
function token()
{
    $r1 = bin2hex(random_bytes(10));
    $r2 = bin2hex(random_bytes(10));
    $r3 = bin2hex(random_bytes(10));
    $r4 = bin2hex(random_bytes(10));
    $token = $r1 . '-' . $r2 . '-' . $r3 . '-' . $r4;
    return $token;
}

// Función para formatear cantidades de dinero
function formatMoney($cantidad)
{
    $cantidad = number_format($cantidad, 2, SPD, SPM);
    return SMONEY . ' ' . $cantidad;
}

// Función para cargar el header
function headerAdmin($data = "")
{
    $view_header = "Views/Template/header.php";
    require_once($view_header);
}

// Función para cargar el footer
function footerAdmin($data = "")
{
    $view_footer = "Views/Template/footer.php";
    require_once($view_footer);
}

// Función para cargar modales
function getModal(string $nameModal, $data)
{
    $view_modal = "Views/Layouts/modals/{$nameModal}.php";
    if(file_exists($view_modal)){
        require_once $view_modal;
    }
}

// Función para subir imágenes
function uploadImage($file, $folder = 'uploads')
{
    if($file['error'] !== UPLOAD_ERR_OK) {
        return '';
    }
    
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    if(!in_array($file['type'], $allowedTypes)) {
        return '';
    }
    
    $uploadDir = "assets/images/{$folder}/";
    if(!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . '.' . $extension;
    $uploadPath = $uploadDir . $filename;
    
    if(move_uploaded_file($file['tmp_name'], $uploadPath)) {
        return $filename;
    }
    
    return '';
}

// Función para verificar permisos de usuario
function hasPermission($moduloUrl)
{
    if (!isset($_SESSION['userData']) || !isset($_SESSION['userData']['idrol'])) {
        return false;
    }
    
    // El administrador (rol 1) tiene acceso a todo
    if ($_SESSION['userData']['idrol'] == 1) {
        return true;
    }
    
    // Verificar si tiene permisos cargados en sesión
    if (isset($_SESSION['userData']['permisos'])) {
        return in_array($moduloUrl, $_SESSION['userData']['permisos']);
    }
    
    // Si no tiene permisos en sesión, verificar en base de datos
    require_once "Libraries/Core/Mysql.php";
    $mysql = new Mysql();
    
    $sql = "SELECT p.id FROM permisos p 
            INNER JOIN modulos m ON p.modulo_id = m.id 
            WHERE p.rol_id = ? AND m.url = ?";
    $result = $mysql->select($sql, [$_SESSION['userData']['idrol'], $moduloUrl]);
    
    return !empty($result);
}

// Función para obtener módulos con permisos del usuario
function getUserModules()
{
    if (!isset($_SESSION['userData']) || !isset($_SESSION['userData']['idrol'])) {
        return [];
    }
    
    require_once "Libraries/Core/Mysql.php";
    $mysql = new Mysql();
    
    // Si es administrador, obtener todos los módulos
    if ($_SESSION['userData']['idrol'] == 1) {
        $sql = "SELECT * FROM modulos WHERE estado = 1 ORDER BY nombre ASC";
        return $mysql->select_all($sql);
    }
    
    // Para otros roles, obtener solo módulos con permisos
    $sql = "SELECT m.* FROM modulos m 
            INNER JOIN permisos p ON m.id = p.modulo_id 
            WHERE p.rol_id = ? AND m.estado = 1 
            ORDER BY m.nombre ASC";
    return $mysql->select_all($sql, [$_SESSION['userData']['idrol']]);
}