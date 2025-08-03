<?php
require_once "Libraries/Core/AuthController.php";

class Pos extends AuthController
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new PosModel();
    }

    public function index()
    {
        $data['page_tag'] = "Punto de Venta - " . NOMBRE_EMPRESA;
        $data['page_title'] = "Punto de Venta";
        $data['page_name'] = "pos";
        $this->views->getView($this, "pos", $data);
    }
    
    public function getClientes()
    {
        try {
            header('Content-Type: application/json; charset=utf-8');
            $arrData = $this->model->getClientes();
            echo json_encode($arrData ?: [], JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            error_log("Error en getClientes: " . $e->getMessage());
            echo json_encode([], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function getProductos()
    {
        try {
            header('Content-Type: application/json; charset=utf-8');
            $arrData = $this->model->getProductosActivos();
            echo json_encode($arrData ?: [], JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            error_log("Error en getProductos: " . $e->getMessage());
            echo json_encode([], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function procesarVenta()
    {
        try {
            header('Content-Type: application/json; charset=utf-8');
            
            if($_POST) {
                if(empty($_POST['productos']) || empty($_POST['total'])) {
                    $arrResponse = ['status' => false, 'msg' => 'Debe agregar al menos un producto'];
                } else {
                    $cliente = intval($_POST['cliente']);
                    if ($cliente === 0) $cliente = null;
                    
                    $datos = [
                        'cliente' => $cliente,
                        'fechaVenta' => date('Y-m-d H:i:s'),
                        'subtotal' => floatval($_POST['subtotal']),
                        'impuestos' => floatval($_POST['impuestos']),
                        'descuentos' => floatval($_POST['descuentos']),
                        'total' => floatval($_POST['total']),
                        'metodoPago' => intval($_POST['metodo_pago']),
                        'pagoCon' => floatval($_POST['pagoCon'] ?? 0),
                        'cambio' => floatval($_POST['cambio'] ?? 0),
                        'observaciones' => strClean($_POST['observaciones']),
                        'usuario' => $_SESSION['userData']['idusuario'] ?? 1,
                        'productos' => json_decode($_POST['productos'], true)
                    ];
                    
                    $result = $this->model->insertVenta($datos);
                    
                    if($result > 0) {
                        $arrResponse = [
                            'status' => true, 
                            'msg' => 'Venta registrada correctamente', 
                            'idVenta' => $result
                        ];
                    } else {
                        $arrResponse = ['status' => false, 'msg' => 'Error al registrar la venta'];
                    }
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $e) {
            error_log("Error en procesarVenta: " . $e->getMessage());
            echo json_encode(['status' => false, 'msg' => 'Error al procesar la venta'], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function imprimirTicket($idVenta)
    {
        $idVenta = intval($idVenta);
        if($idVenta <= 0) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['status' => false, 'msg' => 'ID de venta inválido'], JSON_UNESCAPED_UNICODE);
            die();
        }
        
        $venta = $this->model->getVenta($idVenta);
        if(!$venta) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['status' => false, 'msg' => 'Venta no encontrada'], JSON_UNESCAPED_UNICODE);
            die();
        }
        
        // Redirigir al método de impresión de tickets del controlador de ventas
        header("Location: " . BASE_URL . "ventas/imprimirTicket/" . $idVenta);
        die();
    }
}