<?php
require_once "Libraries/Core/AuthController.php";

class Inventario extends AuthController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function getSubcategorias($categoriaId)
    {
        // Establecer el encabezado de contenido como JSON
        header('Content-Type: application/json; charset=utf-8');
        
        try {
            $categoriaId = intval($categoriaId);
            if($categoriaId > 0) {
                $arrData = $this->model->getSubcategorias($categoriaId);
                echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
            } else {
                echo json_encode([], JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $e) {
            error_log("Error en getSubcategorias: " . $e->getMessage());
            echo json_encode([], JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function index()
    {
        $data['page_tag'] = "Inventario - " . NOMBRE_EMPRESA;
        $data['page_title'] = "Gestión de Inventario";
        $data['page_name'] = "inventario";
        $this->views->getView($this, "inventario", $data);
    }
    
    public function getProductos()
    {
        try {
            $arrData = $this->model->getProductos();
            if (empty($arrData)) {
                $arrData = [];
            }
            echo json_encode($arrData);
        } catch (Exception $e) {
            // Si hay un error, devolver un array vacío
            echo json_encode([]);
        }
        die();
    }
    
    public function getProducto($idProducto)
    {
        try {
            // Establecer el encabezado de contenido como JSON
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
            // Si hay un error, devolver un mensaje de error
            error_log("Error en getProducto: " . $e->getMessage());
            echo json_encode(['error' => 'Error al obtener el producto'], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function setProducto()
    {
        // Establecer el encabezado de contenido como JSON
        header('Content-Type: application/json; charset=utf-8');
        
        if($_POST) {
            // Validación de campos obligatorios
            if(empty($_POST['codigo']) || empty($_POST['nombre']) || empty($_POST['categoria']) || 
               empty($_POST['stock_actual']) || empty($_POST['precio_compra']) || empty($_POST['precio_venta'])) {
                $arrResponse = array('status' => false, 'msg' => 'Todos los campos marcados con * son obligatorios');
            } else {
                $idProducto = intval($_POST['idProducto']);
                $codigo = strClean($_POST['codigo']);
                $nombre = strClean($_POST['nombre']);
                $descripcion = strClean($_POST['descripcion']);
                $categoria = intval($_POST['categoria']);
                $subcategoria = !empty($_POST['subcategoria']) ? intval($_POST['subcategoria']) : null;
                $unidadMedida = strClean($_POST['unidad_medida']);
                $tamanio = strClean($_POST['tamanio']);
                $presentacion = strClean($_POST['presentacion']);
                $almacen = !empty($_POST['almacen']) ? intval($_POST['almacen']) : 1; // Valor por defecto 1 si está vacío
                $ubicacion = strClean($_POST['ubicacion']);
                $condiciones = strClean($_POST['condiciones']);
                $observaciones = strClean($_POST['observaciones_ubicacion']);
                $stockActual = intval($_POST['stock_actual']);
                $stockMinimo = !empty($_POST['stock_minimo']) ? intval($_POST['stock_minimo']) : 0;
                $stockMaximo = !empty($_POST['stock_maximo']) ? intval($_POST['stock_maximo']) : '';
                $precioCompra = floatval($_POST['precio_compra']);
                $precioVenta = floatval($_POST['precio_venta']);
                $costosAdicionales = !empty($_POST['costos_adicionales']) ? floatval($_POST['costos_adicionales']) : 0;
                $estado = intval($_POST['estado']);
                
                $datos = array(
                    'idProducto' => $idProducto,
                    'codigo' => $codigo,
                    'nombre' => $nombre,
                    'descripcion' => $descripcion,
                    'categoria' => $categoria,
                    'subcategoria' => $subcategoria,
                    'unidad_medida' => $unidadMedida,
                    'tamanio' => $tamanio,
                    'presentacion' => $presentacion,
                    'almacen' => $almacen,
                    'ubicacion' => $ubicacion,
                    'condiciones' => $condiciones,
                    'observaciones_ubicacion' => $observaciones,
                    'stock_actual' => $stockActual,
                    'stock_minimo' => $stockMinimo,
                    'stock_maximo' => $stockMaximo,
                    'precio_compra' => $precioCompra,
                    'precio_venta' => $precioVenta,
                    'costos_adicionales' => $costosAdicionales,
                    'estado' => $estado
                );
                
                // Verificar si es un nuevo producto o una actualización
                if($idProducto == 0) {
                    // Verificar si ya existe un producto con el mismo código
                    $sql = "SELECT * FROM productos WHERE codigo = '{$codigo}'";
                    $request = $this->model->select($sql);
                    if(empty($request)) {
                        $result = $this->model->setProducto($datos);
                        $arrResponse = array('status' => true, 'msg' => 'Producto guardado correctamente');
                    } else {
                        $arrResponse = array('status' => false, 'msg' => 'El código ya existe, ingrese otro');
                    }
                } else {
                    // Actualizar producto
                    try {
                        $result = $this->model->setProducto($datos);
                        if($result) {
                            $arrResponse = array('status' => true, 'msg' => 'Producto actualizado correctamente');
                        } else {
                            $arrResponse = array('status' => false, 'msg' => 'Error al actualizar el producto');
                            error_log("Error al actualizar producto: No se pudo actualizar en la base de datos");
                        }
                    } catch (Exception $e) {
                        $arrResponse = array('status' => false, 'msg' => 'Error al actualizar el producto');
                        error_log("Error al actualizar producto: " . $e->getMessage());
                    }
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function deleteProducto()
    {
        // Establecer el encabezado de contenido como JSON
        header('Content-Type: application/json; charset=utf-8');
        
        if($_POST) {
            $idProducto = intval($_POST['idProducto']);
            if($idProducto > 0) {
                $result = $this->model->deleteProducto($idProducto);
                if($result) {
                    $arrResponse = array('status' => true, 'msg' => 'Producto eliminado correctamente');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el producto');
                }
            } else {
                $arrResponse = array('status' => false, 'msg' => 'ID de producto inválido');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}