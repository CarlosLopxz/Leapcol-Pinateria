<?php
require_once "Libraries/Core/AuthController.php";

class Roles extends AuthController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['page_tag'] = "Roles - " . NOMBRE_EMPRESA;
        $data['page_title'] = "Gestión de Roles";
        $data['page_name'] = "roles";
        $this->views->getView($this, "roles", $data);
    }
    
    public function getRoles()
    {
        try {
            header('Content-Type: application/json; charset=utf-8');
            $arrData = $this->model->getRoles();
            echo json_encode($arrData ?: [], JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            error_log("Error en getRoles: " . $e->getMessage());
            echo json_encode([], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function getModulos()
    {
        try {
            header('Content-Type: application/json; charset=utf-8');
            $arrData = $this->model->getModulos();
            echo json_encode($arrData ?: [], JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            error_log("Error en getModulos: " . $e->getMessage());
            echo json_encode([], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function getPermisos($rolId)
    {
        try {
            header('Content-Type: application/json; charset=utf-8');
            $rolId = intval($rolId);
            if($rolId > 0) {
                $arrData = $this->model->getPermisos($rolId);
                echo json_encode($arrData ?: [], JSON_UNESCAPED_UNICODE);
            } else {
                echo json_encode([], JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $e) {
            error_log("Error en getPermisos: " . $e->getMessage());
            echo json_encode([], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function setPermisos()
    {
        try {
            header('Content-Type: application/json; charset=utf-8');
            
            if($_POST) {
                if(empty($_POST['rolId'])) {
                    $arrResponse = ['status' => false, 'msg' => 'Rol requerido'];
                } else {
                    $rolId = intval($_POST['rolId']);
                    $modulos = isset($_POST['modulos']) ? $_POST['modulos'] : [];
                    
                    $result = $this->model->setPermisos($rolId, $modulos);
                    if($result) {
                        $arrResponse = ['status' => true, 'msg' => 'Permisos actualizados correctamente'];
                    } else {
                        $arrResponse = ['status' => false, 'msg' => 'Error al actualizar permisos'];
                    }
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $e) {
            error_log("Error en setPermisos: " . $e->getMessage());
            echo json_encode(['status' => false, 'msg' => 'Error al procesar la solicitud'], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}