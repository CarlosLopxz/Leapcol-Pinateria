<?php
class ClientesModel extends Mysql
{
    private $intIdCliente;
    private $strNombre;
    private $strApellido;
    private $strDocumento;
    private $strTipoDocumento;
    private $strTelefono;
    private $strEmail;
    private $strDireccion;
    private $strCiudad;
    private $dateFechaNacimiento;
    private $intEstado;

    public function __construct()
    {
        parent::__construct();
    }

    public function getClientes()
    {
        try {
            $sql = "SELECT id, CONCAT(nombre, ' ', apellido) as nombre_completo, 
                    documento, telefono, email, ciudad, estado 
                    FROM clientes 
                    ORDER BY id DESC";
            $request = $this->select_all($sql);
            return $request;
        } catch (Exception $e) {
            error_log("Error en getClientes: " . $e->getMessage());
            return [];
        }
    }

    public function getCliente(int $idCliente)
    {
        try {
            $this->intIdCliente = $idCliente;
            $sql = "SELECT * FROM clientes WHERE id = {$this->intIdCliente}";
            $request = $this->select($sql);
            return $request;
        } catch (Exception $e) {
            error_log("Error en getCliente: " . $e->getMessage());
            return null;
        }
    }
    
    public function getClientePorDocumento(string $documento, int $idExcluir = 0)
    {
        try {
            $this->strDocumento = $documento;
            $sql = "SELECT * FROM clientes WHERE documento = '{$this->strDocumento}'";
            
            if($idExcluir > 0) {
                $sql .= " AND id != {$idExcluir}";
            }
            
            $request = $this->select($sql);
            return $request;
        } catch (Exception $e) {
            error_log("Error en getClientePorDocumento: " . $e->getMessage());
            return null;
        }
    }

    public function insertCliente(array $datos)
    {
        try {
            $this->strNombre = $datos['nombre'];
            $this->strApellido = $datos['apellido'];
            $this->strDocumento = $datos['documento'];
            $this->strTipoDocumento = $datos['tipoDocumento'];
            $this->strTelefono = $datos['telefono'];
            $this->strEmail = $datos['email'];
            $this->strDireccion = $datos['direccion'];
            $this->strCiudad = $datos['ciudad'];
            $this->dateFechaNacimiento = $datos['fechaNacimiento'];
            $this->intEstado = $datos['estado'];
            
            $query = "INSERT INTO clientes (nombre, apellido, documento, tipo_documento, 
                      telefono, email, direccion, ciudad, fecha_nacimiento, estado) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $arrData = [
                $this->strNombre,
                $this->strApellido,
                $this->strDocumento,
                $this->strTipoDocumento,
                $this->strTelefono,
                $this->strEmail,
                $this->strDireccion,
                $this->strCiudad,
                $this->dateFechaNacimiento,
                $this->intEstado
            ];
            
            $request = $this->insert($query, $arrData);
            return $request;
        } catch (Exception $e) {
            error_log("Error en insertCliente: " . $e->getMessage());
            return 0;
        }
    }

    public function updateCliente(array $datos)
    {
        try {
            $this->intIdCliente = $datos['idCliente'];
            $this->strNombre = $datos['nombre'];
            $this->strApellido = $datos['apellido'];
            $this->strDocumento = $datos['documento'];
            $this->strTipoDocumento = $datos['tipoDocumento'];
            $this->strTelefono = $datos['telefono'];
            $this->strEmail = $datos['email'];
            $this->strDireccion = $datos['direccion'];
            $this->strCiudad = $datos['ciudad'];
            $this->dateFechaNacimiento = $datos['fechaNacimiento'];
            $this->intEstado = $datos['estado'];
            
            $query = "UPDATE clientes SET nombre = ?, apellido = ?, documento = ?, 
                      tipo_documento = ?, telefono = ?, email = ?, direccion = ?, 
                      ciudad = ?, fecha_nacimiento = ?, estado = ? 
                      WHERE id = {$this->intIdCliente}";
            $arrData = [
                $this->strNombre,
                $this->strApellido,
                $this->strDocumento,
                $this->strTipoDocumento,
                $this->strTelefono,
                $this->strEmail,
                $this->strDireccion,
                $this->strCiudad,
                $this->dateFechaNacimiento,
                $this->intEstado
            ];
            
            $request = $this->update($query, $arrData);
            return $request;
        } catch (Exception $e) {
            error_log("Error en updateCliente: " . $e->getMessage());
            return false;
        }
    }

    public function deleteCliente(int $idCliente)
    {
        try {
            $this->intIdCliente = $idCliente;
            $query = "DELETE FROM clientes WHERE id = {$this->intIdCliente}";
            $request = $this->delete($query);
            return $request;
        } catch (Exception $e) {
            error_log("Error en deleteCliente: " . $e->getMessage());
            return false;
        }
    }
    
    public function getVentasPorCliente(int $idCliente)
    {
        try {
            $sql = "SELECT id FROM ventas WHERE cliente_id = {$idCliente}";
            $request = $this->select_all($sql);
            return $request;
        } catch (Exception $e) {
            error_log("Error en getVentasPorCliente: " . $e->getMessage());
            return [];
        }
    }
    
    public function getComprasCliente(int $idCliente)
    {
        try {
            $sql = "SELECT c.id, c.numero_factura, c.fecha_compra, p.nombre as proveedor, 
                    c.total, c.estado 
                    FROM compras c 
                    INNER JOIN proveedores p ON c.proveedor_id = p.id 
                    WHERE c.estado = 1 
                    ORDER BY c.fecha_compra DESC 
                    LIMIT 10";
            $request = $this->select_all($sql);
            return $request;
        } catch (Exception $e) {
            error_log("Error en getComprasCliente: " . $e->getMessage());
            return [];
        }
    }
    
    public function getVentasCliente(int $idCliente)
    {
        try {
            $sql = "SELECT v.id, v.numero_factura, v.fecha_venta, v.total, v.estado 
                    FROM ventas v 
                    WHERE v.cliente_id = {$idCliente} 
                    ORDER BY v.fecha_venta DESC";
            $request = $this->select_all($sql);
            return $request;
        } catch (Exception $e) {
            error_log("Error en getVentasCliente: " . $e->getMessage());
            return [];
        }
    }
    
    // Métodos para el dashboard
    public function getTotalClientes()
    {
        try {
            $sql = "SELECT COUNT(*) as total FROM clientes WHERE estado = 1";
            $request = $this->select($sql);
            return $request['total'];
        } catch (Exception $e) {
            error_log("Error en getTotalClientes: " . $e->getMessage());
            return 0;
        }
    }
    
    public function getClientesNuevosMes()
    {
        try {
            $sql = "SELECT COUNT(*) as total FROM clientes 
                    WHERE MONTH(fecha_creacion) = MONTH(CURRENT_DATE()) 
                    AND YEAR(fecha_creacion) = YEAR(CURRENT_DATE())";
            $request = $this->select($sql);
            return $request['total'];
        } catch (Exception $e) {
            error_log("Error en getClientesNuevosMes: " . $e->getMessage());
            return 0;
        }
    }
    
    public function getClientesPorCiudad()
    {
        try {
            $sql = "SELECT ciudad, COUNT(*) as total FROM clientes 
                    WHERE estado = 1 AND ciudad != '' 
                    GROUP BY ciudad 
                    ORDER BY total DESC";
            $request = $this->select_all($sql);
            return $request;
        } catch (Exception $e) {
            error_log("Error en getClientesPorCiudad: " . $e->getMessage());
            return [];
        }
    }
    
    public function getUltimosClientes($limit)
    {
        try {
            $sql = "SELECT id, CONCAT(nombre, ' ', apellido) as nombre_completo, 
                    telefono, email, fecha_creacion 
                    FROM clientes 
                    WHERE estado = 1 
                    ORDER BY fecha_creacion DESC 
                    LIMIT {$limit}";
            $request = $this->select_all($sql);
            return $request;
        } catch (Exception $e) {
            error_log("Error en getUltimosClientes: " . $e->getMessage());
            return [];
        }
    }
}