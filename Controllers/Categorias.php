<?php
require_once "Libraries/Core/AuthController.php";

class Categorias extends AuthController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['page_tag'] = "Categorías - " . NOMBRE_EMPRESA;
        $data['page_title'] = "Gestión de Categorías";
        $data['page_name'] = "categorias";
        $this->views->getView($this, "categorias", $data);
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
    
    public function getCategoria($idCategoria)
    {
        try {
            header('Content-Type: application/json; charset=utf-8');
            $idCategoria = intval($idCategoria);
            if($idCategoria > 0) {
                $arrData = $this->model->getCategoria($idCategoria);
                if($arrData) {
                    echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
                } else {
                    echo json_encode(['error' => 'Categoría no encontrada'], JSON_UNESCAPED_UNICODE);
                }
            } else {
                echo json_encode(['error' => 'ID de categoría inválido'], JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $e) {
            error_log("Error en getCategoria: " . $e->getMessage());
            echo json_encode(['error' => 'Error al obtener la categoría'], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function setCategoria()
    {
        try {
            header('Content-Type: application/json; charset=utf-8');
            
            if($_POST) {
                // Validación de campos obligatorios
                if(empty($_POST['nombre'])) {
                    $arrResponse = ['status' => false, 'msg' => 'El nombre de la categoría es obligatorio'];
                } else {
                    // Datos de la categoría
                    $idCategoria = intval($_POST['idCategoria']);
                    $nombre = strClean($_POST['nombre']);
                    $descripcion = strClean($_POST['descripcion']);
                    $estado = intval($_POST['estado']);
                    
                    $datos = [
                        'idCategoria' => $idCategoria,
                        'nombre' => $nombre,
                        'descripcion' => $descripcion,
                        'estado' => $estado
                    ];
                    
                    if($idCategoria == 0) {
                        // Nueva categoría
                        $result = $this->model->insertCategoria($datos);
                        if($result > 0) {
                            $arrResponse = ['status' => true, 'msg' => 'Categoría guardada correctamente'];
                        } else {
                            $arrResponse = ['status' => false, 'msg' => 'Error al guardar la categoría'];
                        }
                    } else {
                        // Actualizar categoría
                        $result = $this->model->updateCategoria($datos);
                        if($result) {
                            $arrResponse = ['status' => true, 'msg' => 'Categoría actualizada correctamente'];
                        } else {
                            $arrResponse = ['status' => false, 'msg' => 'Error al actualizar la categoría'];
                        }
                    }
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $e) {
            error_log("Error en setCategoria: " . $e->getMessage());
            echo json_encode(['status' => false, 'msg' => 'Error al procesar la solicitud'], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function delCategoria()
    {
        try {
            header('Content-Type: application/json; charset=utf-8');
            
            if($_POST) {
                $idCategoria = intval($_POST['idCategoria']);
                if($idCategoria > 0) {
                    // Verificar si la categoría tiene productos asociados
                    $tieneProductos = $this->model->verificarProductosCategoria($idCategoria);
                    if($tieneProductos) {
                        $arrResponse = ['status' => false, 'msg' => 'No se puede eliminar la categoría porque tiene productos asociados'];
                    } else {
                        $result = $this->model->deleteCategoria($idCategoria);
                        if($result) {
                            $arrResponse = ['status' => true, 'msg' => 'Categoría eliminada correctamente'];
                        } else {
                            $arrResponse = ['status' => false, 'msg' => 'Error al eliminar la categoría'];
                        }
                    }
                } else {
                    $arrResponse = ['status' => false, 'msg' => 'ID de categoría inválido'];
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $e) {
            error_log("Error en delCategoria: " . $e->getMessage());
            echo json_encode(['status' => false, 'msg' => 'Error al procesar la solicitud'], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}