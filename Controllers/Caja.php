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
        $data['historialCajas'] = $this->model->getHistorialCajas($_SESSION['userData']['idusuario'], 5);
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
                $cajaId = isset($_POST['cajaId']) ? intval($_POST['cajaId']) : 0;
                $montoFinal = floatval($_POST['montoFinal'] ?? 0);
                $observaciones = strClean($_POST['observaciones'] ?? '');
                
                if($cajaId <= 0) {
                    $arrResponse = ['status' => false, 'msg' => 'ID de caja requerido'];
                    echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                    die();
                }
                
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
    
    public function cancelarVenta()
    {
        try {
            header('Content-Type: application/json; charset=utf-8');
            
            if($_POST) {
                $ventaId = intval($_POST['ventaId']);
                $motivo = strClean($_POST['motivo'] ?? '');
                $ajusteCaja = isset($_POST['ajusteCaja']) ? 1 : 0;
                $montoDevuelto = floatval($_POST['montoDevuelto'] ?? 0);
                
                if($ventaId <= 0) {
                    $arrResponse = ['status' => false, 'msg' => 'ID de venta requerido'];
                    echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                    die();
                }
                
                // Registrar cancelación
                $cancelacionId = $this->model->registrarCancelacion(
                    $ventaId, 
                    $motivo, 
                    $montoDevuelto, 
                    $ajusteCaja, 
                    $_SESSION['userData']['idusuario']
                );
                
                if($cancelacionId > 0) {
                    // Si se debe ajustar la caja y hay dinero a devolver
                    if($ajusteCaja && $montoDevuelto > 0) {
                        $cajaAbierta = $this->model->getCajaAbierta($_SESSION['userData']['idusuario']);
                        if($cajaAbierta) {
                            $datos = [
                                'caja_id' => $cajaAbierta['id'],
                                'tipo' => 'egreso',
                                'concepto' => 'Devolución por cancelación - Venta #' . $ventaId,
                                'monto' => $montoDevuelto,
                                'metodo_pago' => 1, // Efectivo
                                'cancelacion_id' => $cancelacionId,
                                'usuario_id' => $_SESSION['userData']['idusuario']
                            ];
                            
                            $this->model->registrarMovimiento($datos);
                            $this->model->actualizarTotalesCaja($cajaAbierta['id']);
                        }
                    }
                    
                    $arrResponse = ['status' => true, 'msg' => 'Venta cancelada correctamente'];
                } else {
                    $arrResponse = ['status' => false, 'msg' => 'Error al cancelar la venta'];
                }
                
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $e) {
            error_log("Error en cancelarVenta: " . $e->getMessage());
            echo json_encode(['status' => false, 'msg' => 'Error al procesar la solicitud'], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function agregarProductoTemporal()
    {
        try {
            header('Content-Type: application/json; charset=utf-8');
            
            if($_POST) {
                $nombre = strClean($_POST['nombre']);
                $precio = floatval($_POST['precio']);
                
                if(empty($nombre) || $precio <= 0) {
                    $arrResponse = ['status' => false, 'msg' => 'Nombre y precio son requeridos'];
                } else {
                    $result = $this->model->registrarProductoTemporal(
                        $nombre, 
                        $precio, 
                        $_SESSION['userData']['idusuario']
                    );
                    
                    if($result > 0) {
                        $arrResponse = ['status' => true, 'msg' => 'Producto temporal agregado', 'id' => $result];
                    } else {
                        $arrResponse = ['status' => false, 'msg' => 'Error al agregar producto temporal'];
                    }
                }
                
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $e) {
            error_log("Error en agregarProductoTemporal: " . $e->getMessage());
            echo json_encode(['status' => false, 'msg' => 'Error al procesar la solicitud'], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function getProductosTemporales()
    {
        try {
            header('Content-Type: application/json; charset=utf-8');
            $arrData = $this->model->getProductosTemporales($_SESSION['userData']['idusuario']);
            echo json_encode($arrData ?: [], JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            error_log("Error en getProductosTemporales: " . $e->getMessage());
            echo json_encode([], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function reporteCaja($cajaId)
    {
        $cajaId = intval($cajaId);
        $caja = $this->model->getCaja($cajaId);
        $movimientos = $this->model->getMovimientos($cajaId);
        $resumen = $this->model->getResumenCaja($cajaId);
        
        if(!$caja) {
            header('Location: ' . BASE_URL . 'caja');
            return;
        }
        
        // Cargar TCPDF
        require_once 'vendor/tecnickcom/tcpdf/tcpdf.php';
        
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(15, 15, 15);
        $pdf->AddPage();
        
        // Título
        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->Cell(0, 10, NOMBRE_EMPRESA, 0, 1, 'C');
        $pdf->SetFont('helvetica', 'B', 14);
        $pdf->Cell(0, 8, 'Reporte de Caja #' . $caja['id'], 0, 1, 'C');
        $pdf->Ln(5);
        
        // Información general
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(0, 6, 'Información General', 0, 1);
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(50, 6, 'Fecha Apertura:', 0, 0);
        $pdf->Cell(0, 6, date('d/m/Y H:i', strtotime($caja['fecha_apertura'])), 0, 1);
        $pdf->Cell(50, 6, 'Fecha Cierre:', 0, 0);
        $pdf->Cell(0, 6, $caja['fecha_cierre'] ? date('d/m/Y H:i', strtotime($caja['fecha_cierre'])) : 'Abierta', 0, 1);
        $pdf->Cell(50, 6, 'Usuario:', 0, 0);
        $pdf->Cell(0, 6, $caja['usuario_nombre'], 0, 1);
        $pdf->Cell(50, 6, 'Monto Inicial:', 0, 0);
        $pdf->Cell(0, 6, '$' . number_format($caja['monto_inicial'], 0), 0, 1);
        $pdf->Cell(50, 6, 'Monto Final:', 0, 0);
        $pdf->Cell(0, 6, '$' . number_format($caja['monto_final'] ?? 0, 0), 0, 1);
        $pdf->Ln(5);
        
        // Resumen de ingresos separado
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(0, 6, 'Resumen de Ingresos', 0, 1);
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(50, 6, 'Ingresos por Transferencias:', 0, 0);
        $pdf->Cell(0, 6, '$' . number_format($resumen['ingresos_transferencias'] ?? 0, 0), 0, 1);
        $pdf->Cell(50, 6, 'Ventas procesadas por Caja:', 0, 0);
        $pdf->Cell(0, 6, '$' . number_format($resumen['ingresos_efectivo'] ?? 0, 0), 0, 1);
        $pdf->Cell(50, 6, 'Ingresos Adicionales:', 0, 0);
        $pdf->Cell(0, 6, '$' . number_format($resumen['total_ingresos'] ?? 0, 0), 0, 1);
        $pdf->Cell(50, 6, 'Total Egresos:', 0, 0);
        $pdf->Cell(0, 6, '$' . number_format($resumen['total_egresos'] ?? 0, 0), 0, 1);
        $pdf->Cell(50, 6, 'Efectivo Disponible:', 0, 0);
        $pdf->Cell(0, 6, '$' . number_format($resumen['efectivo_disponible'] ?? 0, 0), 0, 1);
        $pdf->Ln(10);
        
        // Movimientos
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(0, 6, 'Detalle de Movimientos', 0, 1);
        $pdf->SetFont('helvetica', 'B', 9);
        $pdf->Cell(30, 8, 'Hora', 1, 0, 'C');
        $pdf->Cell(30, 8, 'Tipo', 1, 0, 'C');
        $pdf->Cell(80, 8, 'Concepto', 1, 0, 'C');
        $pdf->Cell(30, 8, 'Monto', 1, 1, 'C');
        
        $pdf->SetFont('helvetica', '', 8);
        foreach($movimientos as $mov) {
            $pdf->Cell(30, 6, date('H:i', strtotime($mov['fecha'])), 1, 0, 'C');
            $pdf->Cell(30, 6, ucfirst($mov['tipo']), 1, 0, 'C');
            $pdf->Cell(80, 6, $mov['concepto'], 1, 0);
            $pdf->Cell(30, 6, '$' . number_format($mov['monto'], 0), 1, 1, 'R');
        }
        
        $nombreArchivo = 'Reporte_Caja_' . $caja['id'] . '_' . date('YmdHis') . '.pdf';
        $pdf->Output($nombreArchivo, 'D');
        die();
    }
}