<?php
require_once "Libraries/Core/Conexion.php";
require_once "Libraries/Core/Mysql.php";
require_once "Libraries/Core/Views.php";
require_once "Libraries/Core/Controllers.php";
require_once "Libraries/Core/AuthController.php";

class Dashboard extends AuthController
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new DashboardModel();
    }

    public function index()
    {
        $data['page_tag'] = "Dashboard - " . NOMBRE_EMPRESA;
        $data['page_title'] = "Dashboard";
        $data['page_name'] = "dashboard";
        $data['totalProductos'] = $this->model->getTotalProductos();
        $data['totalClientes'] = $this->model->getTotalClientes();
        $data['totalVentas'] = $this->model->getTotalVentas();
        $data['totalIngresos'] = $this->model->getTotalIngresos();
        $data['ventasRecientes'] = $this->model->getVentasRecientes();
        $data['ventasPorMes'] = $this->model->getVentasPorMes();
        $this->views->getView($this, "dashboard", $data);
    }
    
    public function dashboard()
    {
        $this->index();
    }
    
    public function getTotalVentas()
    {
        $arrData = ['total' => $this->model->getTotalVentas()];
        echo json_encode($arrData);
        die();
    }
    
    public function getVentasMes()
    {
        $arrData = ['total' => $this->model->getVentasMes()];
        echo json_encode($arrData);
        die();
    }
    
    public function getTotalClientes()
    {
        $arrData = ['total' => $this->model->getTotalClientes()];
        echo json_encode($arrData);
        die();
    }
    

}