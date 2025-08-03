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
        
        // Verificar permisos para el módulo actual
        $this->checkModulePermission();
    }
    
    /**
     * Verificar si el usuario tiene permisos para acceder al módulo actual
     */
    private function checkModulePermission()
    {
        // Obtener el nombre del controlador actual
        $currentController = strtolower(get_class($this));
        
        // Módulos que no requieren validación de permisos específicos
        $exemptModules = ['dashboard', 'logout', 'perfil'];
        
        if (in_array($currentController, $exemptModules)) {
            return;
        }
        
        // Verificar si tiene permisos para este módulo
        if (!hasPermission($currentController)) {
            // Redirigir al dashboard con mensaje de error
            $_SESSION['error_message'] = 'No tienes permisos para acceder a este módulo';
            header('Location: ' . BASE_URL . 'dashboard');
            exit();
        }
    }
}