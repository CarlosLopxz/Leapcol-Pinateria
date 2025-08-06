<?php
require_once "Libraries/Core/AuthController.php";

class Produccion extends AuthController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['page_tag'] = "Producción - " . NOMBRE_EMPRESA;
        $data['page_title'] = "Gestión de Producción";
        $data['page_name'] = "produccion";
        $this->views->getView($this, "produccion", $data);
    }
    
    public function getProducciones()
    {
        try {
            header('Content-Type: application/json; charset=utf-8');
            $arrData = $this->model->getProducciones();
            echo json_encode($arrData ?: [], JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            error_log("Error en getProducciones: " . $e->getMessage());
            echo json_encode([], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function getProductosRecursos()
    {
        try {
            header('Content-Type: application/json; charset=utf-8');
            $arrData = $this->model->getProductosRecursos();
            echo json_encode($arrData ?: [], JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            error_log("Error en getProductosRecursos: " . $e->getMessage());
            echo json_encode([], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function getCategorias()
    {
        try {
            header('Content-Type: application/json; charset=utf-8');
            $arrData = $this->model->getCategorias();
            echo json_encode($arrData ?: [], JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            error_log("Error en getCategorias: " . $e->getMessage());
            echo json_encode([], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function verificarStock()
    {
        try {
            header('Content-Type: application/json; charset=utf-8');
            
            if($_POST && isset($_POST['recursos'])) {
                $recursos = json_decode($_POST['recursos'], true);
                $resultado = $this->model->verificarStockRecursos($recursos);
                echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
            } else {
                echo json_encode(['status' => false, 'msg' => 'Datos inválidos'], JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $e) {
            error_log("Error en verificarStock: " . $e->getMessage());
            echo json_encode(['status' => false, 'msg' => 'Error al verificar stock'], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function setProduccion()
    {
        try {
            header('Content-Type: application/json; charset=utf-8');
            
            if($_POST) {
                if(empty($_POST['nombre_producto']) || empty($_POST['cantidad']) || empty($_POST['recursos'])) {
                    $arrResponse = ['status' => false, 'msg' => 'Todos los campos son obligatorios'];
                } else {
                    $nombreProducto = strClean($_POST['nombre_producto']);
                    $descripcion = strClean($_POST['descripcion_producto'] ?? '');
                    $categoria = intval($_POST['categoria_producto']);
                    $precioVenta = floatval($_POST['precio_venta']);
                    $manoObra = floatval($_POST['mano_obra'] ?? 0);
                    $cantidad = intval($_POST['cantidad']);
                    $recursos = json_decode($_POST['recursos'], true);
                    $observaciones = strClean($_POST['observaciones'] ?? '');
                    $descontarInventario = intval($_POST['descontar_inventario'] ?? 1);
                    
                    if($cantidad <= 0) {
                        $arrResponse = ['status' => false, 'msg' => 'La cantidad debe ser mayor a 0'];
                    } else if(empty($recursos)) {
                        $arrResponse = ['status' => false, 'msg' => 'Debe agregar al menos un recurso'];
                    } else {
                        // Verificar stock antes de procesar
                        $stockValido = $this->model->verificarStockRecursos($recursos);
                        if(!$stockValido['status']) {
                            $arrResponse = $stockValido;
                        } else {
                            $datos = [
                                'nombre_producto' => $nombreProducto,
                                'descripcion_producto' => $descripcion,
                                'categoria_producto' => $categoria,
                                'precio_venta' => $precioVenta,
                                'mano_obra' => $manoObra,
                                'cantidad' => $cantidad,
                                'recursos' => $recursos,
                                'observaciones' => $observaciones,
                                'descontar_inventario' => $descontarInventario,
                                'usuario_id' => $_SESSION['userData']['idusuario']
                            ];
                            
                            $result = $this->model->insertProduccion($datos);
                            if($result > 0) {
                                $arrResponse = ['status' => true, 'msg' => 'Producción procesada correctamente'];
                            } else {
                                $arrResponse = ['status' => false, 'msg' => 'Error al procesar la producción'];
                            }
                        }
                    }
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $e) {
            error_log("Error en setProduccion: " . $e->getMessage());
            echo json_encode(['status' => false, 'msg' => 'Error al procesar la solicitud'], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function getDetalleProduccion($idProduccion)
    {
        try {
            header('Content-Type: application/json; charset=utf-8');
            $idProduccion = intval($idProduccion);
            if($idProduccion > 0) {
                $arrData = $this->model->getDetalleProduccion($idProduccion);
                echo json_encode($arrData ?: [], JSON_UNESCAPED_UNICODE);
            } else {
                echo json_encode(['error' => 'ID de producción inválido'], JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $e) {
            error_log("Error en getDetalleProduccion: " . $e->getMessage());
            echo json_encode(['error' => 'Error al obtener el detalle'], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}