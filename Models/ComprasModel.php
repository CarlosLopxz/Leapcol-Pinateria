<?php
class ComprasModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getCompras()
    {
        try {
            $sql = "SELECT c.id, c.numero_factura, c.fecha_compra, p.nombre as proveedor, 
                    c.total, c.estado 
                    FROM compras c 
                    INNER JOIN proveedores p ON c.proveedor_id = p.id 
                    ORDER BY c.id DESC";
            $request = $this->select_all($sql);
            return $request;
        } catch (Exception $e) {
            error_log("Error en getCompras: " . $e->getMessage());
            return [];
        }
    }

    public function getCompra(int $idCompra)
    {
        try {
            $this->intIdCompra = $idCompra;
            $sql = "SELECT c.*, p.nombre as proveedor_nombre, u.nombre as usuario_nombre 
                    FROM compras c 
                    INNER JOIN proveedores p ON c.proveedor_id = p.id 
                    INNER JOIN usuarios u ON c.usuario_id = u.idusuario 
                    WHERE c.id = {$this->intIdCompra}";
            $request = $this->select($sql);
            return $request;
        } catch (Exception $e) {
            error_log("Error en getCompra: " . $e->getMessage());
            return null;
        }
    }

    public function getDetalleCompra(int $idCompra)
    {
        try {
            $sql = "SELECT d.*, p.codigo, p.nombre 
                    FROM detalle_compras d 
                    INNER JOIN productos p ON d.producto_id = p.id 
                    WHERE d.compra_id = {$idCompra}";
            $request = $this->select_all($sql);
            return $request;
        } catch (Exception $e) {
            error_log("Error en getDetalleCompra: " . $e->getMessage());
            return [];
        }
    }

    public function getProveedores()
    {
        try {
            $sql = "SELECT id, nombre FROM proveedores WHERE estado = 1 ORDER BY nombre ASC";
            $request = $this->select_all($sql);
            return $request;
        } catch (Exception $e) {
            error_log("Error en getProveedores: " . $e->getMessage());
            return [];
        }
    }

    public function getProductosActivos()
    {
        try {
            $sql = "SELECT id, codigo, nombre, precio_compra, stock_actual as stock 
                    FROM productos 
                    WHERE estado = 1 
                    ORDER BY nombre ASC";
            $request = $this->select_all($sql);
            return $request;
        } catch (Exception $e) {
            error_log("Error en getProductosActivos: " . $e->getMessage());
            return [];
        }
    }

    public function insertCompra(array $datos)
    {
        try {
            // Iniciar transacción
            $this->beginTransaction();
            
            // Insertar cabecera de compra
            $query = "INSERT INTO compras (proveedor_id, numero_factura, fecha_compra, subtotal, 
                      impuestos, descuentos, total, estado, observaciones, usuario_id) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $arrData = [
                $datos['proveedor'],
                $datos['numeroFactura'],
                $datos['fechaCompra'],
                $datos['subtotal'],
                $datos['impuestos'],
                $datos['descuentos'],
                $datos['total'],
                $datos['estado'],
                $datos['observaciones'],
                $datos['usuario']
            ];
            
            $idCompra = $this->insert($query, $arrData);
            
            if($idCompra > 0) {
                // Insertar detalle de compra
                foreach($datos['productos'] as $producto) {
                    $queryDetalle = "INSERT INTO detalle_compras (compra_id, producto_id, cantidad, 
                                    precio_unitario, subtotal) VALUES (?, ?, ?, ?, ?)";
                    $arrDataDetalle = [
                        $idCompra,
                        $producto['id'],
                        $producto['cantidad'],
                        $producto['precio'],
                        $producto['subtotal']
                    ];
                    
                    $idDetalle = $this->insert($queryDetalle, $arrDataDetalle);
                    
                    if($idDetalle > 0) {
                        // Actualizar stock del producto
                        $queryStock = "UPDATE productos SET stock_actual = stock_actual + ?, 
                                      precio_compra = ?, fecha_actualizacion = NOW() 
                                      WHERE id = ?";
                        $arrDataStock = [
                            $producto['cantidad'],
                            $producto['precio'],
                            $producto['id']
                        ];
                        
                        $this->update($queryStock, $arrDataStock);
                        
                        // Registrar movimiento de inventario
                        $queryMovimiento = "INSERT INTO movimientos_inventario (producto_id, tipo_movimiento, 
                                          cantidad, precio_unitario, total, referencia, usuario_id) 
                                          VALUES (?, 'entrada', ?, ?, ?, ?, ?)";
                        $arrDataMovimiento = [
                            $producto['id'],
                            $producto['cantidad'],
                            $producto['precio'],
                            $producto['subtotal'],
                            'Compra #' . $idCompra,
                            $datos['usuario']
                        ];
                        
                        $this->insert($queryMovimiento, $arrDataMovimiento);
                    }
                }
                
                // Confirmar transacción
                $this->commit();
                return $idCompra;
            } else {
                // Revertir transacción
                $this->rollback();
                return 0;
            }
        } catch (Exception $e) {
            // Revertir transacción en caso de error
            $this->rollback();
            error_log("Error en insertCompra: " . $e->getMessage());
            return 0;
        }
    }

    public function updateCompra(array $datos)
    {
        try {
            // Iniciar transacción
            $this->beginTransaction();
            
            // Obtener detalle actual para revertir stock
            $detalleActual = $this->getDetalleCompra($datos['idCompra']);
            
            // Revertir stock de productos
            foreach($detalleActual as $detalle) {
                $queryRevertir = "UPDATE productos SET stock_actual = stock_actual - ? 
                                 WHERE id = ?";
                $arrDataRevertir = [
                    $detalle['cantidad'],
                    $detalle['producto_id']
                ];
                
                $this->update($queryRevertir, $arrDataRevertir);
            }
            
            // Eliminar detalle actual
            $queryEliminar = "DELETE FROM detalle_compras WHERE compra_id = ?";
            $this->delete($queryEliminar, [$datos['idCompra']]);
            
            // Actualizar cabecera de compra
            $query = "UPDATE compras SET proveedor_id = ?, numero_factura = ?, fecha_compra = ?, 
                     subtotal = ?, impuestos = ?, descuentos = ?, total = ?, estado = ?, 
                     observaciones = ? WHERE id = ?";
            $arrData = [
                $datos['proveedor'],
                $datos['numeroFactura'],
                $datos['fechaCompra'],
                $datos['subtotal'],
                $datos['impuestos'],
                $datos['descuentos'],
                $datos['total'],
                $datos['estado'],
                $datos['observaciones'],
                $datos['idCompra']
            ];
            
            $result = $this->update($query, $arrData);
            
            if($result) {
                // Insertar nuevo detalle de compra
                foreach($datos['productos'] as $producto) {
                    $queryDetalle = "INSERT INTO detalle_compras (compra_id, producto_id, cantidad, 
                                    precio_unitario, subtotal) VALUES (?, ?, ?, ?, ?)";
                    $arrDataDetalle = [
                        $datos['idCompra'],
                        $producto['id'],
                        $producto['cantidad'],
                        $producto['precio'],
                        $producto['subtotal']
                    ];
                    
                    $idDetalle = $this->insert($queryDetalle, $arrDataDetalle);
                    
                    if($idDetalle > 0) {
                        // Actualizar stock del producto
                        $queryStock = "UPDATE productos SET stock_actual = stock_actual + ?, 
                                      precio_compra = ?, fecha_actualizacion = NOW() 
                                      WHERE id = ?";
                        $arrDataStock = [
                            $producto['cantidad'],
                            $producto['precio'],
                            $producto['id']
                        ];
                        
                        $this->update($queryStock, $arrDataStock);
                    }
                }
                
                // Confirmar transacción
                $this->commit();
                return true;
            } else {
                // Revertir transacción
                $this->rollback();
                return false;
            }
        } catch (Exception $e) {
            // Revertir transacción en caso de error
            $this->rollback();
            error_log("Error en updateCompra: " . $e->getMessage());
            return false;
        }
    }

    public function anularCompra(int $idCompra)
    {
        try {
            // Iniciar transacción
            $this->beginTransaction();
            
            // Obtener detalle de la compra
            $detalle = $this->getDetalleCompra($idCompra);
            
            // Revertir stock de productos
            foreach($detalle as $item) {
                $queryStock = "UPDATE productos SET stock_actual = stock_actual - ? 
                              WHERE id = ?";
                $arrDataStock = [
                    $item['cantidad'],
                    $item['producto_id']
                ];
                
                $this->update($queryStock, $arrDataStock);
            }
            
            // Anular compra
            $query = "UPDATE compras SET estado = 0 WHERE id = ?";
            $result = $this->update($query, [$idCompra]);
            
            if($result) {
                // Confirmar transacción
                $this->commit();
                return true;
            } else {
                // Revertir transacción
                $this->rollback();
                return false;
            }
        } catch (Exception $e) {
            // Revertir transacción en caso de error
            $this->rollback();
            error_log("Error en anularCompra: " . $e->getMessage());
            return false;
        }
    }
    
    // Métodos para el dashboard
    public function getTotalCompras()
    {
        try {
            $sql = "SELECT COUNT(*) as total FROM compras WHERE estado = 1";
            $request = $this->select($sql);
            return $request['total'];
        } catch (Exception $e) {
            error_log("Error en getTotalCompras: " . $e->getMessage());
            return 0;
        }
    }
    
    public function getComprasPorMes()
    {
        try {
            $sql = "SELECT MONTH(fecha_compra) as mes, SUM(total) as total 
                    FROM compras 
                    WHERE estado = 1 AND YEAR(fecha_compra) = YEAR(CURRENT_DATE()) 
                    GROUP BY MONTH(fecha_compra) 
                    ORDER BY MONTH(fecha_compra)";
            $request = $this->select_all($sql);
            return $request;
        } catch (Exception $e) {
            error_log("Error en getComprasPorMes: " . $e->getMessage());
            return [];
        }
    }
    
    public function getUltimasCompras($limit)
    {
        try {
            $sql = "SELECT c.id, c.fecha_compra, p.nombre as proveedor, c.total 
                    FROM compras c 
                    INNER JOIN proveedores p ON c.proveedor_id = p.id 
                    WHERE c.estado = 1 
                    ORDER BY c.fecha_compra DESC 
                    LIMIT {$limit}";
            $request = $this->select_all($sql);
            return $request;
        } catch (Exception $e) {
            error_log("Error en getUltimasCompras: " . $e->getMessage());
            return [];
        }
    }
    
    public function getComprasPorProveedor()
    {
        try {
            $sql = "SELECT p.nombre as proveedor, SUM(c.total) as total 
                    FROM compras c 
                    INNER JOIN proveedores p ON c.proveedor_id = p.id 
                    WHERE c.estado = 1 
                    GROUP BY p.nombre 
                    ORDER BY total DESC";
            $request = $this->select_all($sql);
            return $request;
        } catch (Exception $e) {
            error_log("Error en getComprasPorProveedor: " . $e->getMessage());
            return [];
        }
    }
    
    public function getProductosMasComprados($limit)
    {
        try {
            $sql = "SELECT p.nombre, SUM(d.cantidad) as cantidad 
                    FROM detalle_compras d 
                    INNER JOIN productos p ON d.producto_id = p.id 
                    INNER JOIN compras c ON d.compra_id = c.id 
                    WHERE c.estado = 1 
                    GROUP BY p.nombre 
                    ORDER BY cantidad DESC 
                    LIMIT {$limit}";
            $request = $this->select_all($sql);
            return $request;
        } catch (Exception $e) {
            error_log("Error en getProductosMasComprados: " . $e->getMessage());
            return [];
        }
    }
}