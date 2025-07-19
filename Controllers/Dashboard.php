<?php
class Dashboard extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        session_regenerate_id(true);
        if (empty($_SESSION['login'])) {
            header('Location: ' . BASE_URL . 'login');
            die();
        }
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