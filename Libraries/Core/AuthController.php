<?php
/**
 * Controlador base para páginas que requieren autenticación
 */
class AuthController extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        
        // Iniciar sesión si no está iniciada
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Regenerar ID de sesión para prevenir session fixation
        if (!isset($_SESSION['regenerated']) || $_SESSION['regenerated'] < (time() - 60)) {
            session_regenerate_id(true);
            $_SESSION['regenerated'] = time();
        }
        
        // Verificar si el usuario está autenticado
        if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
            header('Location: ' . BASE_URL . 'login');
            exit();
        }
    }
}