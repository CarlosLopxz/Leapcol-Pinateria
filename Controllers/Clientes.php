<?php
require_once "Libraries/Core/AuthController.php";

class Clientes extends AuthController
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new ClientesModel();
    }

    public function index()
    {
        $data['page_tag'] = "Clientes - " . NOMBRE_EMPRESA;
        $data['page_title'] = "Gestión de Clientes";
        $data['page_name'] = "clientes";
        $this->views->getView($this, "clientes", $data);
    }
    
    public function getClientes()
    {
        try {
            // Establecer el encabezado de contenido como JSON
            header('Content-Type: application/json; charset=utf-8');
            
            $arrData = $this->model->getClientes();
            if (empty($arrData)) {
                $arrData = [];
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            error_log("Error en getClientes: " . $e->getMessage());
            echo json_encode([], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function getCliente($idCliente)
    {
        try {
            // Establecer el encabezado de contenido como JSON
            header('Content-Type: application/json; charset=utf-8');
            
            $idCliente = intval($idCliente);
            if($idCliente > 0) {
                $arrData = $this->model->getCliente($idCliente);
                if($arrData) {
                    echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
                } else {
                    echo json_encode(['error' => 'Cliente no encontrado'], JSON_UNESCAPED_UNICODE);
                }
            } else {
                echo json_encode(['error' => 'ID de cliente inválido'], JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $e) {
            error_log("Error en getCliente: " . $e->getMessage());
            echo json_encode(['error' => 'Error al obtener el cliente'], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function setCliente()
    {
        try {
            // Establecer el encabezado de contenido como JSON
            header('Content-Type: application/json; charset=utf-8');
            
            if($_POST) {
                // Validación de campos obligatorios
                if(empty($_POST['nombre']) || empty($_POST['apellido']) || empty($_POST['telefono'])) {
                    $arrResponse = ['status' => false, 'msg' => 'Todos los campos marcados con * son obligatorios'];
                } else {
                    $idCliente = intval($_POST['idCliente']);
                    $nombre = strClean($_POST['nombre']);
                    $apellido = strClean($_POST['apellido']);
                    $documento = strClean($_POST['documento']);
                    $tipoDocumento = strClean($_POST['tipo_documento']);
                    $telefono = strClean($_POST['telefono']);
                    $email = strClean($_POST['email']);
                    $direccion = strClean($_POST['direccion']);
                    $ciudad = strClean($_POST['ciudad']);
                    $fechaNacimiento = !empty($_POST['fecha_nacimiento']) ? $_POST['fecha_nacimiento'] : null;
                    $estado = intval($_POST['estado']);
                    
                    $datos = [
                        'idCliente' => $idCliente,
                        'nombre' => $nombre,
                        'apellido' => $apellido,
                        'documento' => $documento,
                        'tipoDocumento' => $tipoDocumento,
                        'telefono' => $telefono,
                        'email' => $email,
                        'direccion' => $direccion,
                        'ciudad' => $ciudad,
                        'fechaNacimiento' => $fechaNacimiento,
                        'estado' => $estado
                    ];
                    
                    if($idCliente == 0) {
                        // Verificar si ya existe un cliente con el mismo documento
                        if(!empty($documento)) {
                            $clienteExistente = $this->model->getClientePorDocumento($documento);
                            if($clienteExistente) {
                                $arrResponse = ['status' => false, 'msg' => 'El documento ya está registrado'];
                                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                                die();
                            }
                        }
                        
                        // Nuevo cliente
                        $result = $this->model->insertCliente($datos);
                        if($result > 0) {
                            $arrResponse = ['status' => true, 'msg' => 'Cliente registrado correctamente'];
                        } else {
                            error_log("Error insertCliente: resultado = " . var_export($result, true));
                            error_log("Datos enviados: " . json_encode($datos));
                            $arrResponse = ['status' => false, 'msg' => 'Error al registrar el cliente'];
                        }
                    } else {
                        // Verificar si ya existe otro cliente con el mismo documento
                        if(!empty($documento)) {
                            $clienteExistente = $this->model->getClientePorDocumento($documento, $idCliente);
                            if($clienteExistente) {
                                $arrResponse = ['status' => false, 'msg' => 'El documento ya está registrado por otro cliente'];
                                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                                die();
                            }
                        }
                        
                        // Actualizar cliente
                        $result = $this->model->updateCliente($datos);
                        if($result) {
                            $arrResponse = ['status' => true, 'msg' => 'Cliente actualizado correctamente'];
                        } else {
                            $arrResponse = ['status' => false, 'msg' => 'Error al actualizar el cliente'];
                        }
                    }
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $e) {
            error_log("Error en setCliente: " . $e->getMessage());
            echo json_encode(['status' => false, 'msg' => 'Error al procesar la solicitud'], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function deleteCliente()
    {
        try {
            // Establecer el encabezado de contenido como JSON
            header('Content-Type: application/json; charset=utf-8');
            
            if($_POST) {
                $idCliente = intval($_POST['idCliente']);
                if($idCliente > 0) {
                    // Verificar si el cliente tiene ventas asociadas
                    $ventasCliente = $this->model->getVentasPorCliente($idCliente);
                    if(!empty($ventasCliente)) {
                        $arrResponse = ['status' => false, 'msg' => 'No se puede eliminar el cliente porque tiene ventas asociadas'];
                    } else {
                        $result = $this->model->deleteCliente($idCliente);
                        if($result) {
                            $arrResponse = ['status' => true, 'msg' => 'Cliente eliminado correctamente'];
                        } else {
                            $arrResponse = ['status' => false, 'msg' => 'Error al eliminar el cliente'];
                        }
                    }
                } else {
                    $arrResponse = ['status' => false, 'msg' => 'ID de cliente inválido'];
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $e) {
            error_log("Error en deleteCliente: " . $e->getMessage());
            echo json_encode(['status' => false, 'msg' => 'Error al procesar la solicitud'], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function getComprasCliente($idCliente)
    {
        try {
            // Establecer el encabezado de contenido como JSON
            header('Content-Type: application/json; charset=utf-8');
            
            $idCliente = intval($idCliente);
            if($idCliente > 0) {
                $arrData = $this->model->getComprasCliente($idCliente);
                echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
            } else {
                echo json_encode([], JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $e) {
            error_log("Error en getComprasCliente: " . $e->getMessage());
            echo json_encode([], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function getVentasCliente($idCliente)
    {
        try {
            // Establecer el encabezado de contenido como JSON
            header('Content-Type: application/json; charset=utf-8');
            
            $idCliente = intval($idCliente);
            if($idCliente > 0) {
                $arrData = $this->model->getVentasCliente($idCliente);
                echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
            } else {
                echo json_encode([], JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $e) {
            error_log("Error en getVentasCliente: " . $e->getMessage());
            echo json_encode([], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function getDashboardData()
    {
        try {
            // Establecer el encabezado de contenido como JSON
            header('Content-Type: application/json; charset=utf-8');
            
            $data = [
                'totalClientes' => $this->model->getTotalClientes(),
                'clientesNuevosMes' => $this->model->getClientesNuevosMes(),
                'clientesPorCiudad' => $this->model->getClientesPorCiudad(),
                'ultimosClientes' => $this->model->getUltimosClientes(5)
            ];
            
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            error_log("Error en getDashboardData: " . $e->getMessage());
            echo json_encode(['error' => 'Error al obtener datos del dashboard'], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}