<?php
require_once "Libraries/Core/AuthController.php";

class Pos extends AuthController
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new PosModel();
        $this->cajaModel = new CajaModel();
    }

    public function index()
    {
        $data['page_tag'] = "Punto de Venta - " . NOMBRE_EMPRESA;
        $data['page_title'] = "Punto de Venta";
        $data['page_name'] = "pos";
        $data['cajaAbierta'] = $this->cajaModel->getCajaAbierta($_SESSION['userData']['idusuario']);
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
                    $destinoCaja = $_POST['destino_caja'] ?? 'general';
                    $cliente = $_POST['cliente'];
                    
                    // Si el destino es creación, obtener el ID del cliente especial de creación
                    if($destinoCaja === 'creacion' || $cliente === 'creacion') {
                        $clienteCreacion = $this->model->getClienteCreacion();
                        $cliente = $clienteCreacion ? $clienteCreacion['id'] : null;
                    } else {
                        $cliente = intval($cliente);
                        if ($cliente === 0) $cliente = null;
                    }
                    
                    $datos = [
                        'cliente' => $cliente,
                        'fechaVenta' => date('Y-m-d H:i:s'),
                        'subtotal' => floatval($_POST['subtotal']),
                        'impuestos' => floatval($_POST['impuestos']),
                        'descuentos' => floatval($_POST['descuentos']),
                        'manoObra' => floatval($_POST['manoObra'] ?? 0),
                        'total' => floatval($_POST['total']),
                        'metodoPago' => intval($_POST['metodo_pago']),
                        'pagoCon' => floatval($_POST['pagoCon'] ?? 0),
                        'cambio' => floatval($_POST['cambio'] ?? 0),
                        'observaciones' => strClean($_POST['observaciones']),
                        'usuario' => $_SESSION['userData']['idusuario'] ?? 1,
                        'productos' => json_decode($_POST['productos'], true),
                        'destino_caja' => $destinoCaja
                    ];
                    
                    $result = $this->model->insertVenta($datos);
                    
                    if($result > 0) {
                        // Registrar la venta en la caja abierta del usuario
                        $this->registrarVentaEnCaja($result, $datos['total'], $datos['metodoPago']);
                        
                        // Actualizar totales de caja_creacion
                        $creacionModel = new CreacionModel();
                        if($destinoCaja === 'creacion') {
                            $creacionModel->actualizarTotalVendido($datos['total']);
                        } elseif($cliente && $cliente == $creacionModel->getClienteCreacionId()) {
                            $creacionModel->actualizarTotalGastado($datos['total']);
                        }
                        
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
    
    private function registrarVentaEnCaja($ventaId, $total, $metodoPago)
    {
        try {
            $cajaAbierta = $this->cajaModel->getCajaAbierta($_SESSION['userData']['idusuario']);
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
                
                $this->cajaModel->registrarMovimiento($datos);
                $this->cajaModel->actualizarTotalesCaja($cajaAbierta['id']);
            }
        } catch (Exception $e) {
            error_log("Error al registrar venta en caja: " . $e->getMessage());
        }
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
                    $result = $this->cajaModel->registrarProductoTemporal(
                        $nombre, 
                        $precio, 
                        $_SESSION['userData']['idusuario']
                    );
                    
                    if($result > 0) {
                        $arrResponse = [
                            'status' => true, 
                            'msg' => 'Producto temporal agregado al carrito', 
                            'producto' => [
                                'id' => 'temp_' . $result,
                                'nombre' => $nombre,
                                'precio' => $precio,
                                'temporal' => true
                            ]
                        ];
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
                } else {
                    $result = $this->cajaModel->registrarCancelacion(
                        $ventaId, 
                        $motivo, 
                        $montoDevuelto, 
                        $ajusteCaja, 
                        $_SESSION['userData']['idusuario']
                    );
                    
                    if($result > 0) {
                        if($ajusteCaja && $montoDevuelto > 0) {
                            $cajaAbierta = $this->cajaModel->getCajaAbierta($_SESSION['userData']['idusuario']);
                            if($cajaAbierta) {
                                $datos = [
                                    'caja_id' => $cajaAbierta['id'],
                                    'tipo' => 'egreso',
                                    'concepto' => 'Devolución por cancelación - Venta #' . $ventaId,
                                    'monto' => $montoDevuelto,
                                    'metodo_pago' => 1,
                                    'cancelacion_id' => $result,
                                    'usuario_id' => $_SESSION['userData']['idusuario']
                                ];
                                
                                $this->cajaModel->registrarMovimiento($datos);
                                $this->cajaModel->actualizarTotalesCaja($cajaAbierta['id']);
                            }
                        }
                        
                        $arrResponse = ['status' => true, 'msg' => 'Venta cancelada correctamente'];
                    } else {
                        $arrResponse = ['status' => false, 'msg' => 'Error al cancelar la venta'];
                    }
                }
                
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $e) {
            error_log("Error en cancelarVenta: " . $e->getMessage());
            echo json_encode(['status' => false, 'msg' => 'Error al procesar la solicitud'], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}