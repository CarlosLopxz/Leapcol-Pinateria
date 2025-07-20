<?php
require_once "Libraries/Core/AuthController.php";

class Compras extends AuthController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['page_tag'] = "Compras - " . NOMBRE_EMPRESA;
        $data['page_title'] = "Gestión de Compras";
        $data['page_name'] = "compras";
        $this->views->getView($this, "compras", $data);
    }
    
    public function nueva()
    {
        $data['page_tag'] = "Nueva Compra - " . NOMBRE_EMPRESA;
        $data['page_title'] = "Registrar Nueva Compra";
        $data['page_name'] = "nueva_compra";
        $this->views->getView($this, "nueva", $data);
    }
    
    public function getCompras()
    {
        try {
            // Establecer el encabezado de contenido como JSON
            header('Content-Type: application/json; charset=utf-8');
            
            $arrData = $this->model->getCompras();
            if (empty($arrData)) {
                $arrData = [];
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            error_log("Error en getCompras: " . $e->getMessage());
            echo json_encode([], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function getCompra($idCompra)
    {
        try {
            // Establecer el encabezado de contenido como JSON
            header('Content-Type: application/json; charset=utf-8');
            
            $idCompra = intval($idCompra);
            if($idCompra > 0) {
                $arrData = $this->model->getCompra($idCompra);
                if($arrData) {
                    $arrData['detalle'] = $this->model->getDetalleCompra($idCompra);
                    echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
                } else {
                    echo json_encode(['error' => 'Compra no encontrada'], JSON_UNESCAPED_UNICODE);
                }
            } else {
                echo json_encode(['error' => 'ID de compra inválido'], JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $e) {
            error_log("Error en getCompra: " . $e->getMessage());
            echo json_encode(['error' => 'Error al obtener la compra'], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function getProveedores()
    {
        try {
            // Establecer el encabezado de contenido como JSON
            header('Content-Type: application/json; charset=utf-8');
            
            $arrData = $this->model->getProveedores();
            if (empty($arrData)) {
                $arrData = [];
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            error_log("Error en getProveedores: " . $e->getMessage());
            echo json_encode([], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function getProductos()
    {
        try {
            // Establecer el encabezado de contenido como JSON
            header('Content-Type: application/json; charset=utf-8');
            
            $arrData = $this->model->getProductosActivos();
            if (empty($arrData)) {
                $arrData = [];
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            error_log("Error en getProductos: " . $e->getMessage());
            echo json_encode([], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function setCompra()
    {
        try {
            // Establecer el encabezado de contenido como JSON
            header('Content-Type: application/json; charset=utf-8');
            
            if($_POST) {
                // Validación de campos obligatorios
                if(empty($_POST['proveedor']) || empty($_POST['fecha_compra']) || 
                   empty($_POST['productos']) || empty($_POST['total'])) {
                    $arrResponse = ['status' => false, 'msg' => 'Todos los campos marcados con * son obligatorios'];
                } else {
                    // Datos de la compra
                    $idCompra = intval($_POST['idCompra']);
                    $proveedor = intval($_POST['proveedor']);
                    $numeroFactura = strClean($_POST['numero_factura']);
                    $fechaCompra = strClean($_POST['fecha_compra']);
                    $subtotal = floatval($_POST['subtotal']);
                    $impuestos = floatval($_POST['impuestos']);
                    $descuentos = floatval($_POST['descuentos']);
                    $total = floatval($_POST['total']);
                    $estado = intval($_POST['estado']);
                    $observaciones = strClean($_POST['observaciones']);
                    $usuario = $_SESSION['userData']['idusuario'];
                    
                    // Productos
                    $productos = json_decode($_POST['productos'], true);
                    
                    if(empty($productos)) {
                        $arrResponse = ['status' => false, 'msg' => 'Debe agregar al menos un producto'];
                    } else {
                        $datos = [
                            'idCompra' => $idCompra,
                            'proveedor' => $proveedor,
                            'numeroFactura' => $numeroFactura,
                            'fechaCompra' => $fechaCompra,
                            'subtotal' => $subtotal,
                            'impuestos' => $impuestos,
                            'descuentos' => $descuentos,
                            'total' => $total,
                            'estado' => $estado,
                            'observaciones' => $observaciones,
                            'usuario' => $usuario,
                            'productos' => $productos
                        ];
                        
                        if($idCompra == 0) {
                            // Nueva compra
                            $result = $this->model->insertCompra($datos);
                            $arrResponse = ['status' => true, 'msg' => 'Compra registrada correctamente', 'idCompra' => $result];
                        } else {
                            // Actualizar compra
                            $result = $this->model->updateCompra($datos);
                            $arrResponse = ['status' => true, 'msg' => 'Compra actualizada correctamente'];
                        }
                    }
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $e) {
            error_log("Error en setCompra: " . $e->getMessage());
            echo json_encode(['status' => false, 'msg' => 'Error al procesar la solicitud'], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function anularCompra()
    {
        try {
            // Establecer el encabezado de contenido como JSON
            header('Content-Type: application/json; charset=utf-8');
            
            if($_POST) {
                $idCompra = intval($_POST['idCompra']);
                if($idCompra > 0) {
                    $result = $this->model->anularCompra($idCompra);
                    if($result) {
                        $arrResponse = ['status' => true, 'msg' => 'Compra anulada correctamente'];
                    } else {
                        $arrResponse = ['status' => false, 'msg' => 'Error al anular la compra'];
                    }
                } else {
                    $arrResponse = ['status' => false, 'msg' => 'ID de compra inválido'];
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $e) {
            error_log("Error en anularCompra: " . $e->getMessage());
            echo json_encode(['status' => false, 'msg' => 'Error al procesar la solicitud'], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function getDashboardData()
    {
        try {
            // Establecer el encabezado de contenido como JSON
            header('Content-Type: application/json; charset=utf-8');
            
            $data = [
                'totalCompras' => $this->model->getTotalCompras(),
                'comprasMes' => $this->model->getComprasPorMes(),
                'ultimasCompras' => $this->model->getUltimasCompras(5),
                'comprasPorProveedor' => $this->model->getComprasPorProveedor(),
                'productosMasComprados' => $this->model->getProductosMasComprados(5)
            ];
            
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            error_log("Error en getDashboardData: " . $e->getMessage());
            echo json_encode(['error' => 'Error al obtener datos del dashboard'], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}