<?php

class Controllers
{
    protected $views;
    protected $model;

    public function __construct()
    {
        $this->views = new Views();
        $this->loadModel();
        
        // Registrar automáticamente el acceso al módulo para todos los usuarios
        if (isset($_SESSION['login']) && $_SESSION['login']) {
            $this->registrarAccesoAutomatico();
        }
    }

    public function loadModel()
    {
        //HomeModel.php
        $model = get_class($this) . "Model";
        $routClass = "Models/" . $model . ".php";
        if (file_exists($routClass)) {
            require_once $routClass;
            $this->model = new $model();
        }
    }
    
    /**
     * Registra automáticamente el acceso al módulo actual
     */
    private function registrarAccesoAutomatico()
    {
        // Obtener el nombre del controlador actual (módulo)
        $modulo = get_class($this);
        
        // Registrar el acceso
        $this->registrarAccesoModulo($modulo);
    }
    
    /**
     * Registra el acceso a un módulo en el archivo de auditoría
     * @param string $modulo Nombre del módulo accedido
     * @return bool
     */
    public function registrarAccesoModulo($modulo)
    {
        if (isset($_SESSION['login']) && $_SESSION['login']) {
            // Verificar si existe el modelo de auditoría
            $modelPath = "Models/AuditoriaModel.php";
            if (file_exists($modelPath)) {
                require_once $modelPath;
                $auditoriaModel = new AuditoriaModel();
                
                // Obtener datos del usuario
                $idUsuario = $_SESSION['userData']['idusuario'] ?? 0;
                $nombre = $_SESSION['userData']['nombre'] ?? 'Usuario desconocido';
                $rol = $_SESSION['userData']['nombrerol'] ?? 'Sin rol';
                
                // Registrar el acceso
                return $auditoriaModel->registrarAccesoModulo($idUsuario, $nombre, $rol, $modulo);
            }
        }
        return false;
    }
}