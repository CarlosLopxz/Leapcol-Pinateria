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
        $data['page_tag'] = "Creación - " . NOMBRE_EMPRESA;
        $data['page_title'] = "Módulo de Creación";
        $data['page_name'] = "creacion";
        $this->views->getView($this, "creacion", $data);
    }
    
    public function getInventarioCreacion()
    {
        try {
            header('Content-Type: application/json; charset=utf-8');
            $arrData = $this->model->getInventarioCreacion();
            echo json_encode($arrData ?: [], JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            error_log("Error en getInventarioCreacion: " . $e->getMessage());
            echo json_encode([], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function getCajaCreacion()
    {
        try {
            header('Content-Type: application/json; charset=utf-8');
            $arrData = $this->model->getCajaCreacionActual();
            echo json_encode($arrData ?: [], JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            error_log("Error en getCajaCreacion: " . $e->getMessage());
            echo json_encode([], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function getMovimientosCaja()
    {
        try {
            header('Content-Type: application/json; charset=utf-8');
            $arrData = $this->model->getMovimientosCajaCreacion();
            echo json_encode($arrData ?: [], JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            error_log("Error en getMovimientosCaja: " . $e->getMessage());
            echo json_encode([], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function abrirCaja()
    {
        try {
            header('Content-Type: application/json; charset=utf-8');
            
            if($_POST) {
                $montoInicial = floatval($_POST['monto_inicial'] ?? 0);
                $observaciones = strClean($_POST['observaciones'] ?? '');
                
                $result = $this->model->abrirCajaCreacion($montoInicial, $observaciones, $_SESSION['userData']['idusuario']);
                
                if($result > 0) {
                    $arrResponse = ['status' => true, 'msg' => 'Caja de creación abierta correctamente'];
                } else {
                    $arrResponse = ['status' => false, 'msg' => 'Error al abrir la caja'];
                }
                
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $e) {
            error_log("Error en abrirCaja: " . $e->getMessage());
            echo json_encode(['status' => false, 'msg' => 'Error al procesar la solicitud'], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function cerrarCaja()
    {
        try {
            header('Content-Type: application/json; charset=utf-8');
            
            if($_POST) {
                $montoFinal = floatval($_POST['monto_final']);
                $observaciones = strClean($_POST['observaciones'] ?? '');
                
                $result = $this->model->cerrarCajaCreacion($montoFinal, $observaciones);
                
                if($result) {
                    $arrResponse = ['status' => true, 'msg' => 'Caja de creación cerrada correctamente'];
                } else {
                    $arrResponse = ['status' => false, 'msg' => 'Error al cerrar la caja'];
                }
                
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $e) {
            error_log("Error en cerrarCaja: " . $e->getMessage());
            echo json_encode(['status' => false, 'msg' => 'Error al procesar la solicitud'], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function getResumen()
    {
        try {
            header('Content-Type: application/json; charset=utf-8');
            $arrData = $this->model->getResumenCreacion();
            echo json_encode($arrData ?: [], JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            error_log("Error en getResumen: " . $e->getMessage());
            echo json_encode([], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}