<?php
require_once "Libraries/Core/AuthController.php";

class Dashboard extends AuthController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['page_tag'] = "Dashboard - " . NOMBRE_EMPRESA;
        $data['page_title'] = "Dashboard";
        $data['page_name'] = "dashboard";
        $this->views->getView($this, "dashboard", $data);
    }
    
    public function dashboard()
    {
        $this->index();
    }
}