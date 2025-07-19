<?php
require_once "Libraries/Core/AuthController.php";

class Inventario extends AuthController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['page_tag'] = "Inventario - " . NOMBRE_EMPRESA;
        $data['page_title'] = "Gestión de Inventario";
        $data['page_name'] = "inventario";
        $this->views->getView($this, "inventario", $data);
    }
}