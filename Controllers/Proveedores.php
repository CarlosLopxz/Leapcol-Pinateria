<?php
require_once "Libraries/Core/AuthController.php";

class Proveedores extends AuthController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['page_tag'] = "Proveedores - " . NOMBRE_EMPRESA;
        $data['page_title'] = "Gestión de Proveedores";
        $data['page_name'] = "proveedores";
        $this->views->getView($this, "proveedores", $data);
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
    
    public function getProveedor($idProveedor)
    {
        try {
            // Establecer el encabezado de contenido como JSON
            header('Content-Type: application/json; charset=utf-8');
            
            $idProveedor = intval($idProveedor);
            if($idProveedor > 0) {
                $arrData = $this->model->getProveedor($idProveedor);
                if($arrData) {
                    echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
                } else {
                    echo json_encode(['error' => 'Proveedor no encontrado'], JSON_UNESCAPED_UNICODE);
                }
            } else {
                echo json_encode(['error' => 'ID de proveedor inválido'], JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $e) {
            error_log("Error en getProveedor: " . $e->getMessage());
            echo json_encode(['error' => 'Error al obtener el proveedor'], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function setProveedor()
    {
        try {
            // Establecer el encabezado de contenido como JSON
            header('Content-Type: application/json; charset=utf-8');
            
            if($_POST) {
                // Validación de campos obligatorios
                if(empty($_POST['nombre']) || empty($_POST['telefono'])) {
                    $arrResponse = ['status' => false, 'msg' => 'Todos los campos marcados con * son obligatorios'];
                } else {
                    $idProveedor = intval($_POST['idProveedor']);
                    $nombre = strClean($_POST['nombre']);
                    $contacto = strClean($_POST['contacto']);
                    $telefono = strClean($_POST['telefono']);
                    $email = strClean($_POST['email']);
                    $direccion = strClean($_POST['direccion']);
                    $estado = intval($_POST['estado']);
                    
                    $datos = [
                        'idProveedor' => $idProveedor,
                        'nombre' => $nombre,
                        'contacto' => $contacto,
                        'telefono' => $telefono,
                        'email' => $email,
                        'direccion' => $direccion,
                        'estado' => $estado
                    ];
                    
                    if($idProveedor == 0) {
                        // Nuevo proveedor
                        $result = $this->model->insertProveedor($datos);
                        $arrResponse = ['status' => true, 'msg' => 'Proveedor registrado correctamente'];
                    } else {
                        // Actualizar proveedor
                        $result = $this->model->updateProveedor($datos);
                        $arrResponse = ['status' => true, 'msg' => 'Proveedor actualizado correctamente'];
                    }
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $e) {
            error_log("Error en setProveedor: " . $e->getMessage());
            echo json_encode(['status' => false, 'msg' => 'Error al procesar la solicitud'], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function deleteProveedor()
    {
        try {
            // Establecer el encabezado de contenido como JSON
            header('Content-Type: application/json; charset=utf-8');
            
            if($_POST) {
                $idProveedor = intval($_POST['idProveedor']);
                if($idProveedor > 0) {
                    // Verificar si el proveedor tiene compras asociadas
                    $comprasProveedor = $this->model->getComprasPorProveedor($idProveedor);
                    if(!empty($comprasProveedor)) {
                        $arrResponse = ['status' => false, 'msg' => 'No se puede eliminar el proveedor porque tiene compras asociadas'];
                    } else {
                        $result = $this->model->deleteProveedor($idProveedor);
                        if($result) {
                            $arrResponse = ['status' => true, 'msg' => 'Proveedor eliminado correctamente'];
                        } else {
                            $arrResponse = ['status' => false, 'msg' => 'Error al eliminar el proveedor'];
                        }
                    }
                } else {
                    $arrResponse = ['status' => false, 'msg' => 'ID de proveedor inválido'];
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $e) {
            error_log("Error en deleteProveedor: " . $e->getMessage());
            echo json_encode(['status' => false, 'msg' => 'Error al procesar la solicitud'], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function getComprasProveedor($idProveedor)
    {
        try {
            // Establecer el encabezado de contenido como JSON
            header('Content-Type: application/json; charset=utf-8');
            
            $idProveedor = intval($idProveedor);
            if($idProveedor > 0) {
                $arrData = $this->model->getComprasProveedor($idProveedor);
                echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
            } else {
                echo json_encode([], JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $e) {
            error_log("Error en getComprasProveedor: " . $e->getMessage());
            echo json_encode([], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}