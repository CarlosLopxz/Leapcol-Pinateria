<?php
class PosModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getClientes()
    {
        $sql = "SELECT id, CONCAT(nombre, ' ', apellido) as nombre, documento, telefono
                FROM clientes
                WHERE estado = 1
                ORDER BY nombre ASC";
        return $this->select_all($sql);
    }

    public function getProductosActivos()
    {
        $sql = "SELECT id, codigo, nombre, descripcion, precio_venta, mano_obra, stock
                FROM productos
                WHERE estado = 1
                ORDER BY nombre ASC";
        return $this->select_all($sql) ?: [];
    }
    
    public function verificarStock($idProducto)
    {
        $sql = "SELECT stock FROM productos WHERE id = ?";
        $request = $this->select($sql, [$idProducto]);
        return $request ? $request['stock'] : 0;
    }
    
    public function insertVenta($datos)
    {
        try {
            $this->beginTransaction();
            
            $cliente = $datos['cliente'];
            if ($cliente > 0) {
                $sql = "SELECT id FROM clientes WHERE id = ?";
                $clienteExiste = $this->select($sql, [$cliente]);
                if (!$clienteExiste) {
                    throw new Exception("El cliente seleccionado no existe");
                }
            }
            
            // Insertar venta
            $query = "INSERT INTO ventas(cliente_id, fecha_venta, subtotal, impuestos, descuentos, total, metodo_pago, pago_con, cambio, estado, observaciones, usuario_id) 
                      VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $arrData = [
                $cliente, 
                $datos['fechaVenta'], 
                $datos['subtotal'], 
                $datos['impuestos'], 
                $datos['descuentos'], 
                $datos['total'], 
                $datos['metodoPago'], 
                $datos['pagoCon'], 
                $datos['cambio'], 
                1, 
                $datos['observaciones'], 
                $datos['usuario']
            ];
            
            $ventaId = $this->insert($query, $arrData);
            
            if ($ventaId > 0) {
                // Verificar stock antes de insertar detalles (solo para productos normales)
                foreach ($datos['productos'] as $producto) {
                    // Saltar productos temporales
                    if (is_string($producto['id']) && strpos($producto['id'], 'temp_') === 0) {
                        continue;
                    }
                    
                    $stockActual = $this->verificarStock($producto['id']);
                    if ($stockActual < $producto['cantidad']) {
                        $sql = "SELECT nombre FROM productos WHERE id = ?";
                        $prod = $this->select($sql, [$producto['id']]);
                        $nombreProducto = $prod ? $prod['nombre'] : 'Producto';
                        throw new Exception("Stock insuficiente para {$nombreProducto}. Stock disponible: {$stockActual}, solicitado: {$producto['cantidad']}");
                    }
                }
                
                // Insertar detalles
                foreach ($datos['productos'] as $producto) {
                    // Manejar productos temporales
                    if (is_string($producto['id']) && strpos($producto['id'], 'temp_') === 0) {
                        $query = "INSERT INTO detalle_venta(venta_id, producto_id, cantidad, precio_unitario, costo_unitario, subtotal, costo_total, ganancia) 
                                  VALUES(?, NULL, ?, ?, ?, ?, ?, ?)";
                        $this->insert($query, [
                            $ventaId, 
                            $producto['cantidad'], 
                            $producto['precio'], 
                            0, 
                            $producto['subtotal'], 
                            0, 
                            $producto['subtotal']
                        ]);
                    } else {
                        $sql = "SELECT precio_compra FROM productos WHERE id = ?";
                        $prod = $this->select($sql, [$producto['id']]);
                        $costoUnitario = $prod ? $prod['precio_compra'] : 0;
                        $costoTotal = $costoUnitario * $producto['cantidad'];
                        $ganancia = $producto['subtotal'] - $costoTotal;
                        
                        $query = "INSERT INTO detalle_venta(venta_id, producto_id, cantidad, precio_unitario, costo_unitario, subtotal, costo_total, ganancia) 
                                  VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
                        $this->insert($query, [
                            $ventaId, 
                            $producto['id'], 
                            $producto['cantidad'], 
                            $producto['precio'], 
                            $costoUnitario, 
                            $producto['subtotal'], 
                            $costoTotal, 
                            $ganancia
                        ]);
                    }
                }
                
                $this->commit();
                return $ventaId;
            }
            
            $this->rollback();
            return 0;
        } catch (Exception $e) {
            $this->rollback();
            error_log("Error en insertVenta: " . $e->getMessage());
            return 0;
        }
    }
    
    public function getVenta($idVenta)
    {
        $sql = "SELECT v.*, 
                IFNULL(CONCAT(c.nombre, ' ', c.apellido), 'Cliente General') as cliente_nombre,
                CONCAT(u.nombre, ' ', u.apellido) as usuario_nombre
                FROM ventas v
                LEFT JOIN clientes c ON v.cliente_id = c.id
                INNER JOIN usuarios u ON v.usuario_id = u.idusuario
                WHERE v.id = ?";
        return $this->select($sql, [$idVenta]);
    }
    
    public function getClienteCreacion()
    {
        $sql = "SELECT id FROM clientes WHERE nombre = 'Cliente' AND apellido = 'Chela' LIMIT 1";
        return $this->select($sql);
    }
}