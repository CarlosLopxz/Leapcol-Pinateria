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
        
        // Si está en dashboard y no tiene permisos, redirigir al primer módulo disponible
        $this->redirectIfNoDashboardAccess();
    }
    
    /**
     * Verificar si el usuario tiene permisos para acceder al módulo actual
     */
    private function checkModulePermission()
    {
        // Obtener el nombre del controlador actual
        $currentController = strtolower(get_class($this));
        
        // Módulos que no requieren validación de permisos específicos
        $exemptModules = ['logout', 'perfil', 'dashboard'];
        
        if (in_array($currentController, $exemptModules)) {
            return;
        }
        
        // Verificar si tiene permisos para este módulo
        if (!hasPermission($currentController)) {
            // Redirigir al primer módulo disponible
            $this->redirectToFirstAvailableModule();
        }
    }
    
    /**
     * Redirigir si no tiene acceso al dashboard
     */
    private function redirectIfNoDashboardAccess()
    {
        // Dashboard maneja sus propios permisos internamente
        return;
    }
    
    /**
     * Redirigir al primer módulo disponible para el usuario
     */
    private function redirectToFirstAvailableModule()
    {
        $userModules = getUserModules();
        
        if (!empty($userModules)) {
            // Redirigir al primer módulo disponible
            header('Location: ' . BASE_URL . $userModules[0]['url']);
            exit();
        } else {
            // Si no tiene ningún módulo, mostrar mensaje de error
            $_SESSION['error_message'] = 'No tienes permisos para acceder a ningún módulo del sistema';
            header('Location: ' . BASE_URL . 'logout');
            exit();
        }
    }
}