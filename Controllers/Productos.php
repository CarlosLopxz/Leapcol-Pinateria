<?php
require_once "Libraries/Core/AuthController.php";

class Productos extends AuthController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['page_tag'] = "Productos - " . NOMBRE_EMPRESA;
        $data['page_title'] = "Gestión de Productos";
        $data['page_name'] = "productos";
        $this->views->getView($this, "productos", $data);
    }
    
    public function getProductos()
    {
        try {
            header('Content-Type: application/json; charset=utf-8');
            $arrData = $this->model->getProductos();
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
    
    public function getProducto($idProducto)
    {
        try {
            header('Content-Type: application/json; charset=utf-8');
            $idProducto = intval($idProducto);
            if($idProducto > 0) {
                $arrData = $this->model->getProducto($idProducto);
                if($arrData) {
                    echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
                } else {
                    echo json_encode(['error' => 'Producto no encontrado'], JSON_UNESCAPED_UNICODE);
                }
            } else {
                echo json_encode(['error' => 'ID de producto inválido'], JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $e) {
            error_log("Error en getProducto: " . $e->getMessage());
            echo json_encode(['error' => 'Error al obtener el producto'], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function getCategorias()
    {
        try {
            header('Content-Type: application/json; charset=utf-8');
            $arrData = $this->model->getCategorias();
            if (empty($arrData)) {
                $arrData = [];
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            error_log("Error en getCategorias: " . $e->getMessage());
            echo json_encode([], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function setProducto()
    {
        try {
            header('Content-Type: application/json; charset=utf-8');
            
            if($_POST) {
                // Validación de campos obligatorios
                if(empty($_POST['codigo']) || empty($_POST['nombre']) || empty($_POST['precio_venta']) || empty($_POST['categoria'])) {
                    $arrResponse = ['status' => false, 'msg' => 'Todos los campos marcados con * son obligatorios'];
                } else {
                    // Datos del producto
                    $idProducto = intval($_POST['idProducto']);
                    $codigo = strClean($_POST['codigo']);
                    $nombre = strClean($_POST['nombre']);
                    $descripcion = strClean($_POST['descripcion']);
                    $precioCompra = floatval($_POST['precio_compra']);
                    $precioVenta = floatval($_POST['precio_venta']);
                    $manoObra = floatval($_POST['mano_obra'] ?? 0);
                    $stock = intval($_POST['stock']);
                    $stockMinimo = intval($_POST['stock_minimo']);
                    $categoria = intval($_POST['categoria']);
                    $estado = intval($_POST['estado']);
                    
                    // Validar que el precio de venta sea mayor que el de compra
                    if($precioVenta <= $precioCompra) {
                        $arrResponse = ['status' => false, 'msg' => 'El precio de venta debe ser mayor al precio de compra'];
                        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                        die();
                    }
                    
                    // Imagen
                    $foto = '';
                    if(isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
                        $foto = uploadImage($_FILES['imagen'], 'productos');
                    }
                    
                    $datos = [
                        'idProducto' => $idProducto,
                        'codigo' => $codigo,
                        'nombre' => $nombre,
                        'descripcion' => $descripcion,
                        'precioCompra' => $precioCompra,
                        'precioVenta' => $precioVenta,
                        'manoObra' => $manoObra,
                        'stock' => $stock,
                        'stockMinimo' => $stockMinimo,
                        'categoria' => $categoria,
                        'imagen' => $foto,
                        'estado' => $estado
                    ];
                    
                    if($idProducto == 0) {
                        // Nuevo producto
                        // Verificar que el código no exista
                        $existe = $this->model->getProductoPorCodigo($codigo);
                        if($existe) {
                            $arrResponse = ['status' => false, 'msg' => 'El código del producto ya existe'];
                        } else {
                            $result = $this->model->insertProducto($datos);
                            if($result > 0) {
                                $arrResponse = ['status' => true, 'msg' => 'Producto guardado correctamente'];
                            } else {
                                $arrResponse = ['status' => false, 'msg' => 'Error al guardar el producto'];
                            }
                        }
                    } else {
                        // Actualizar producto
                        $result = $this->model->updateProducto($datos);
                        if($result) {
                            $arrResponse = ['status' => true, 'msg' => 'Producto actualizado correctamente'];
                        } else {
                            $arrResponse = ['status' => false, 'msg' => 'Error al actualizar el producto'];
                        }
                    }
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $e) {
            error_log("Error en setProducto: " . $e->getMessage());
            echo json_encode(['status' => false, 'msg' => 'Error al procesar la solicitud'], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function delProducto()
    {
        try {
            header('Content-Type: application/json; charset=utf-8');
            
            if($_POST) {
                $idProducto = intval($_POST['idProducto']);
                if($idProducto > 0) {
                    $result = $this->model->deleteProducto($idProducto);
                    if($result) {
                        $arrResponse = ['status' => true, 'msg' => 'Producto eliminado correctamente'];
                    } else {
                        $arrResponse = ['status' => false, 'msg' => 'Error al eliminar el producto'];
                    }
                } else {
                    $arrResponse = ['status' => false, 'msg' => 'ID de producto inválido'];
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $e) {
            error_log("Error en delProducto: " . $e->getMessage());
            echo json_encode(['status' => false, 'msg' => 'Error al procesar la solicitud'], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function getProductosActivos()
    {
        try {
            header('Content-Type: application/json; charset=utf-8');
            $arrData = $this->model->getProductosActivos();
            if (empty($arrData)) {
                $arrData = [];
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            error_log("Error en getProductosActivos: " . $e->getMessage());
            echo json_encode([], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}