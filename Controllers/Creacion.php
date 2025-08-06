<?php
require_once "Libraries/Core/AuthController.php";

class Creacion extends AuthController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        // Crear cliente creación si no existe
        $this->model->crearClienteCreacion();
        
        $data['page_tag'] = "Creación - " . NOMBRE_EMPRESA;
        $data['page_title'] = "Módulo de Creación";
        $data['page_name'] = "creacion";
        $this->views->getView($this, "creacion", $data);
    }
    
    public function getCajaCreacion()
    {
        header('Content-Type: application/json; charset=utf-8');
        $arrData = $this->model->getCajaCreacion();
        echo json_encode($arrData ?: [], JSON_UNESCAPED_UNICODE);
        die();
    }
    
    public function getInventarioCreacion()
    {
        header('Content-Type: application/json; charset=utf-8');
        $arrData = $this->model->getInventarioCreacion();
        echo json_encode($arrData ?: [], JSON_UNESCAPED_UNICODE);
        die();
    }
}