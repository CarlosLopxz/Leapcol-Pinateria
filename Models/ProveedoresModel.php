<?php
class ProveedoresModel extends Mysql
{
    private $intIdProveedor;
    private $strNombre;
    private $strContacto;
    private $strTelefono;
    private $strEmail;
    private $strDireccion;
    private $intEstado;

    public function __construct()
    {
        parent::__construct();
    }

    public function getProveedores()
    {
        try {
            $sql = "SELECT id, nombre, contacto, telefono, email, estado 
                    FROM proveedores 
                    ORDER BY id DESC";
            $request = $this->select_all($sql);
            return $request;
        } catch (Exception $e) {
            error_log("Error en getProveedores: " . $e->getMessage());
            return [];
        }
    }

    public function getProveedor(int $idProveedor)
    {
        try {
            $this->intIdProveedor = $idProveedor;
            $sql = "SELECT * FROM proveedores WHERE id = {$this->intIdProveedor}";
            $request = $this->select($sql);
            return $request;
        } catch (Exception $e) {
            error_log("Error en getProveedor: " . $e->getMessage());
            return null;
        }
    }

    public function insertProveedor(array $datos)
    {
        try {
            $this->strNombre = $datos['nombre'];
            $this->strContacto = $datos['contacto'];
            $this->strTelefono = $datos['telefono'];
            $this->strEmail = $datos['email'];
            $this->strDireccion = $datos['direccion'];
            $this->intEstado = $datos['estado'];
            
            $query = "INSERT INTO proveedores (nombre, contacto, telefono, email, direccion, estado) 
                      VALUES (?, ?, ?, ?, ?, ?)";
            $arrData = [
                $this->strNombre,
                $this->strContacto,
                $this->strTelefono,
                $this->strEmail,
                $this->strDireccion,
                $this->intEstado
            ];
            
            $request = $this->insert($query, $arrData);
            return $request;
        } catch (Exception $e) {
            error_log("Error en insertProveedor: " . $e->getMessage());
            return 0;
        }
    }

    public function updateProveedor(array $datos)
    {
        try {
            $this->intIdProveedor = $datos['idProveedor'];
            $this->strNombre = $datos['nombre'];
            $this->strContacto = $datos['contacto'];
            $this->strTelefono = $datos['telefono'];
            $this->strEmail = $datos['email'];
            $this->strDireccion = $datos['direccion'];
            $this->intEstado = $datos['estado'];
            
            $query = "UPDATE proveedores SET nombre = ?, contacto = ?, telefono = ?, 
                      email = ?, direccion = ?, estado = ? 
                      WHERE id = {$this->intIdProveedor}";
            $arrData = [
                $this->strNombre,
                $this->strContacto,
                $this->strTelefono,
                $this->strEmail,
                $this->strDireccion,
                $this->intEstado
            ];
            
            $request = $this->update($query, $arrData);
            return $request;
        } catch (Exception $e) {
            error_log("Error en updateProveedor: " . $e->getMessage());
            return false;
        }
    }

    public function deleteProveedor(int $idProveedor)
    {
        try {
            $this->intIdProveedor = $idProveedor;
            $query = "DELETE FROM proveedores WHERE id = {$this->intIdProveedor}";
            $request = $this->delete($query);
            return $request;
        } catch (Exception $e) {
            error_log("Error en deleteProveedor: " . $e->getMessage());
            return false;
        }
    }
    
    public function getComprasPorProveedor(int $idProveedor)
    {
        try {
            $sql = "SELECT id FROM compras WHERE proveedor_id = {$idProveedor}";
            $request = $this->select_all($sql);
            return $request;
        } catch (Exception $e) {
            error_log("Error en getComprasPorProveedor: " . $e->getMessage());
            return [];
        }
    }
    
    public function getComprasProveedor(int $idProveedor)
    {
        try {
            $sql = "SELECT c.id, c.numero_factura, c.fecha_compra, c.total, c.estado 
                    FROM compras c 
                    WHERE c.proveedor_id = {$idProveedor} 
                    ORDER BY c.fecha_compra DESC";
            $request = $this->select_all($sql);
            return $request;
        } catch (Exception $e) {
            error_log("Error en getComprasProveedor: " . $e->getMessage());
            return [];
        }
    }
    
    public function getTotalProveedores()
    {
        try {
            $sql = "SELECT COUNT(*) as total FROM proveedores WHERE estado = 1";
            $request = $this->select($sql);
            return $request['total'];
        } catch (Exception $e) {
            error_log("Error en getTotalProveedores: " . $e->getMessage());
            return 0;
        }
    }
}