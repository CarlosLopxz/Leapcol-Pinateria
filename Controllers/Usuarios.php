<?php
require_once "Libraries/Core/AuthController.php";

class Usuarios extends AuthController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['page_tag'] = "Usuarios - " . NOMBRE_EMPRESA;
        $data['page_title'] = "Gestión de Usuarios";
        $data['page_name'] = "usuarios";
        $this->views->getView($this, "usuarios", $data);
    }
    
    public function getUsuarios()
    {
        try {
            header('Content-Type: application/json; charset=utf-8');
            $arrData = $this->model->getUsuarios();
            echo json_encode($arrData ?: [], JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            error_log("Error en getUsuarios: " . $e->getMessage());
            echo json_encode([], JSON_UNESCAPED_UNICODE);
        }
        die();
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
    
    public function setUsuario()
    {
        try {
            header('Content-Type: application/json; charset=utf-8');
            
            if($_POST) {
                if(empty($_POST['nombre']) || empty($_POST['apellido']) || empty($_POST['usuario']) || empty($_POST['email']) || empty($_POST['rolid'])) {
                    $arrResponse = ['status' => false, 'msg' => 'Todos los campos son obligatorios'];
                } else {
                    $idUsuario = intval($_POST['idUsuario']);
                    $nombre = strClean($_POST['nombre']);
                    $apellido = strClean($_POST['apellido']);
                    $usuario = strClean($_POST['usuario']);
                    $email = strClean($_POST['email']);
                    $password = strClean($_POST['password']);
                    $rolid = intval($_POST['rolid']);
                    $estado = intval($_POST['estado']);
                    
                    if($idUsuario == 0) {
                        if(empty($password)) {
                            $arrResponse = ['status' => false, 'msg' => 'La contraseña es obligatoria'];
                        } else {
                            $datos = [
                                'nombre' => $nombre,
                                'apellido' => $apellido,
                                'usuario' => $usuario,
                                'email' => $email,
                                'password' => password_hash($password, PASSWORD_DEFAULT),
                                'rolid' => $rolid,
                                'estado' => $estado
                            ];
                            
                            $result = $this->model->insertUsuario($datos);
                            if($result > 0) {
                                $arrResponse = ['status' => true, 'msg' => 'Usuario creado correctamente'];
                            } else {
                                $arrResponse = ['status' => false, 'msg' => 'Error al crear el usuario'];
                            }
                        }
                    } else {
                        $datos = [
                            'idUsuario' => $idUsuario,
                            'nombre' => $nombre,
                            'apellido' => $apellido,
                            'usuario' => $usuario,
                            'email' => $email,
                            'rolid' => $rolid,
                            'estado' => $estado
                        ];
                        
                        if(!empty($password)) {
                            $datos['password'] = password_hash($password, PASSWORD_DEFAULT);
                        }
                        
                        $result = $this->model->updateUsuario($datos);
                        if($result) {
                            $arrResponse = ['status' => true, 'msg' => 'Usuario actualizado correctamente'];
                        } else {
                            $arrResponse = ['status' => false, 'msg' => 'Error al actualizar el usuario'];
                        }
                    }
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $e) {
            error_log("Error en setUsuario: " . $e->getMessage());
            echo json_encode(['status' => false, 'msg' => 'Error al procesar la solicitud'], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function getUsuario($idUsuario)
    {
        try {
            header('Content-Type: application/json; charset=utf-8');
            $idUsuario = intval($idUsuario);
            if($idUsuario > 0) {
                $arrData = $this->model->getUsuario($idUsuario);
                echo json_encode($arrData ?: [], JSON_UNESCAPED_UNICODE);
            } else {
                echo json_encode(['error' => 'ID de usuario inválido'], JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $e) {
            error_log("Error en getUsuario: " . $e->getMessage());
            echo json_encode(['error' => 'Error al obtener el usuario'], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function delUsuario()
    {
        try {
            header('Content-Type: application/json; charset=utf-8');
            
            if($_POST) {
                $idUsuario = intval($_POST['idUsuario']);
                if($idUsuario > 0) {
                    $result = $this->model->deleteUsuario($idUsuario);
                    if($result) {
                        $arrResponse = ['status' => true, 'msg' => 'Usuario eliminado correctamente'];
                    } else {
                        $arrResponse = ['status' => false, 'msg' => 'Error al eliminar el usuario'];
                    }
                } else {
                    $arrResponse = ['status' => false, 'msg' => 'ID de usuario inválido'];
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $e) {
            error_log("Error en delUsuario: " . $e->getMessage());
            echo json_encode(['status' => false, 'msg' => 'Error al procesar la solicitud'], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}