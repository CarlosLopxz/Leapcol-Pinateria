<?php
require_once "Libraries/Core/AuthController.php";

class Caja extends AuthController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['page_tag'] = "Caja - " . NOMBRE_EMPRESA;
        $data['page_title'] = "Gestión de Caja";
        $data['page_name'] = "caja";
        $data['cajaAbierta'] = $this->model->getCajaAbierta($_SESSION['userData']['idusuario']);
        $this->views->getView($this, "caja", $data);
    }
    
    public function abrirCaja()
    {
        try {
            header('Content-Type: application/json; charset=utf-8');
            
            if($_POST) {
                $montoInicial = floatval($_POST['montoInicial']);
                $observaciones = strClean($_POST['observaciones'] ?? '');
                $usuarioId = $_SESSION['userData']['idusuario'];
                
                // Verificar si ya hay una caja abierta
                $cajaAbierta = $this->model->getCajaAbierta($usuarioId);
                if($cajaAbierta) {
                    $arrResponse = ['status' => false, 'msg' => 'Ya tienes una caja abierta'];
                } else {
                    $datos = [
                        'usuario_id' => $usuarioId,
                        'monto_inicial' => $montoInicial,
                        'observaciones' => $observaciones
                    ];
                    
                    $result = $this->model->abrirCaja($datos);
                    if($result > 0) {
                        $arrResponse = ['status' => true, 'msg' => 'Caja abierta correctamente', 'cajaId' => $result];
                    } else {
                        $arrResponse = ['status' => false, 'msg' => 'Error al abrir la caja'];
                    }
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
                $cajaId = intval($_POST['cajaId']);
                $montoFinal = floatval($_POST['montoFinal']);
                $observaciones = strClean($_POST['observaciones'] ?? '');
                
                $result = $this->model->cerrarCaja($cajaId, $montoFinal, $observaciones);
                if($result) {
                    $arrResponse = ['status' => true, 'msg' => 'Caja cerrada correctamente'];
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
    
    public function registrarMovimiento()
    {
        try {
            header('Content-Type: application/json; charset=utf-8');
            
            if($_POST) {
                $cajaId = intval($_POST['cajaId']);
                $tipo = strClean($_POST['tipo']);
                $concepto = strClean($_POST['concepto']);
                $monto = floatval($_POST['monto']);
                $metodoPago = intval($_POST['metodoPago']);
                
                // Validar que si es egreso, no exceda el dinero disponible
                if($tipo === 'egreso') {
                    $resumen = $this->model->getResumenCaja($cajaId);
                    $totalActual = $resumen['total_actual'] ?? 0;
                    
                    if($monto > $totalActual) {
                        $arrResponse = ['status' => false, 'msg' => 'No hay suficiente dinero en caja. Disponible: $' . number_format($totalActual, 0)];
                        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                        die();
                    }
                }
                
                $datos = [
                    'caja_id' => $cajaId,
                    'tipo' => $tipo,
                    'concepto' => $concepto,
                    'monto' => $monto,
                    'metodo_pago' => $metodoPago,
                    'usuario_id' => $_SESSION['userData']['idusuario']
                ];
                
                $result = $this->model->registrarMovimiento($datos);
                if($result > 0) {
                    // Actualizar totales después del movimiento
                    $this->model->actualizarTotalesCaja($cajaId);
                    $arrResponse = ['status' => true, 'msg' => 'Movimiento registrado correctamente'];
                } else {
                    $arrResponse = ['status' => false, 'msg' => 'Error al registrar el movimiento'];
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $e) {
            error_log("Error en registrarMovimiento: " . $e->getMessage());
            echo json_encode(['status' => false, 'msg' => 'Error al procesar la solicitud'], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function getMovimientos($cajaId)
    {
        try {
            header('Content-Type: application/json; charset=utf-8');
            $cajaId = intval($cajaId);
            if($cajaId > 0) {
                $arrData = $this->model->getMovimientos($cajaId);
                echo json_encode($arrData ?: [], JSON_UNESCAPED_UNICODE);
            } else {
                echo json_encode([], JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $e) {
            error_log("Error en getMovimientos: " . $e->getMessage());
            echo json_encode([], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function getResumenCaja($cajaId)
    {
        try {
            header('Content-Type: application/json; charset=utf-8');
            $cajaId = intval($cajaId);
            if($cajaId > 0) {
                $arrData = $this->model->getResumenCaja($cajaId);
                echo json_encode($arrData ?: [], JSON_UNESCAPED_UNICODE);
            } else {
                echo json_encode([], JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $e) {
            error_log("Error en getResumenCaja: " . $e->getMessage());
            echo json_encode([], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function registrarVentaEnCaja($ventaId, $total, $metodoPago)
    {
        $cajaAbierta = $this->model->getCajaAbierta($_SESSION['userData']['idusuario']);
        if($cajaAbierta) {
            $datos = [
                'caja_id' => $cajaAbierta['id'],
                'tipo' => 'venta',
                'concepto' => 'Venta #' . $ventaId,
                'monto' => $total,
                'metodo_pago' => $metodoPago,
                'venta_id' => $ventaId,
                'usuario_id' => $_SESSION['userData']['idusuario']
            ];
            
            $this->model->registrarMovimiento($datos);
            $this->model->actualizarTotalesCaja($cajaAbierta['id']);
        }
    }
}