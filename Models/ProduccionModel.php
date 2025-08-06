<?php
class ProduccionModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getProducciones()
    {
        $sql = "SELECT p.*, pr.nombre as producto_final, u.nombre as usuario
                FROM producciones p
                INNER JOIN productos pr ON p.producto_final_id = pr.id
                INNER JOIN usuarios u ON p.usuario_id = u.idusuario
                WHERE p.estado != 0
                ORDER BY p.id DESC";
        return $this->select_all($sql);
    }

    public function getProductosRecursos()
    {
        $sql = "SELECT id, codigo, nombre, stock, precio_compra
                FROM productos
                WHERE estado = 1 AND stock > 0
                ORDER BY nombre ASC";
        return $this->select_all($sql);
    }

    public function verificarStockRecursos($recursos)
    {
        foreach($recursos as $recurso) {
            // Omitir verificación para recursos manuales
            if(isset($recurso['manual']) && $recurso['manual']) {
                continue;
            }
            
            $sql = "SELECT stock FROM productos WHERE id = " . intval($recurso['id']);
            $producto = $this->select($sql);
            
            if(!$producto) {
                return ['status' => false, 'msg' => 'Producto no encontrado'];
            }
            
            if($producto['stock'] < intval($recurso['cantidad'])) {
                return ['status' => false, 'msg' => 'Stock insuficiente para el recurso: ' . $recurso['nombre']];
            }
        }
        
        return ['status' => true];
    }

    public function insertProduccion($datos)
    {
        try {
            // Iniciar transacción
            $this->beginTransaction();
            
            // Calcular precio de compra basado en recursos (excluyendo manuales)
            $precioCompra = 0;
            foreach($datos['recursos'] as $recurso) {
                // Solo calcular precio para recursos del inventario, no manuales
                if(!isset($recurso['manual']) || !$recurso['manual']) {
                    $sql = "SELECT precio_compra FROM productos WHERE id = " . intval($recurso['id']);
                    $producto = $this->select($sql);
                    if($producto) {
                        $precioCompra += ($producto['precio_compra'] * intval($recurso['cantidad']));
                    }
                }
            }
            $precioCompra = $datos['cantidad'] > 0 ? $precioCompra / $datos['cantidad'] : 0; // Precio por unidad
            
            // Calcular precio de venta final (precio base + mano de obra)
            $precioVentaFinal = $datos['precio_venta'] + $datos['mano_obra'];
            
            // Generar código único para el producto
            $codigoProducto = 'P' . date('ymd') . rand(100, 999);
            
            // Crear el producto nuevo
            $query_producto = "INSERT INTO productos(codigo, nombre, descripcion, categoria_id, precio_compra, precio_venta, mano_obra, stock, estado) 
                             VALUES(?, ?, ?, ?, ?, ?, ?, ?, 1)";
            $arrProducto = [
                $codigoProducto,
                $datos['nombre_producto'],
                $datos['descripcion_producto'],
                $datos['categoria_producto'],
                $precioCompra,
                $precioVentaFinal,
                $datos['mano_obra'],
                $datos['cantidad']
            ];
            
            $productoId = $this->insert($query_producto, $arrProducto);
            
            if($productoId > 0) {
                // Generar código único para la producción
                $codigoProduccion = 'PR' . date('ymd') . rand(10, 99);
                
                // Insertar producción
                $query_produccion = "INSERT INTO producciones(codigo, producto_final_id, cantidad_producir, observaciones, usuario_id) 
                                   VALUES(?, ?, ?, ?, ?)";
                $arrProduccion = [
                    $codigoProduccion,
                    $productoId,
                    $datos['cantidad'],
                    $datos['observaciones'],
                    $datos['usuario_id']
                ];
                
                $produccionId = $this->insert($query_produccion, $arrProduccion);
                
                if($produccionId > 0) {
                    // Insertar detalle de producción
                    foreach($datos['recursos'] as $recurso) {
                        if(isset($recurso['manual']) && $recurso['manual']) {
                            // Para recursos manuales, usar NULL en producto_recurso_id
                            $query_detalle = "INSERT INTO detalle_produccion(produccion_id, producto_recurso_id, cantidad_utilizada, recurso_manual) 
                                            VALUES(?, NULL, ?, ?)";
                            $arrDetalle = [
                                $produccionId,
                                intval($recurso['cantidad']),
                                $recurso['nombre']
                            ];
                        } else {
                            // Para recursos del inventario
                            $query_detalle = "INSERT INTO detalle_produccion(produccion_id, producto_recurso_id, cantidad_utilizada, recurso_manual) 
                                            VALUES(?, ?, ?, NULL)";
                            $arrDetalle = [
                                $produccionId,
                                intval($recurso['id']),
                                intval($recurso['cantidad'])
                            ];
                        }
                        
                        $this->insert($query_detalle, $arrDetalle);
                        
                        // Descontar del inventario solo si está habilitado y no es recurso manual
                        if($datos['descontar_inventario'] == 1 && (!isset($recurso['manual']) || !$recurso['manual'])) {
                            $query_stock = "UPDATE productos SET stock = stock - ? WHERE id = ?";
                            $this->update($query_stock, [intval($recurso['cantidad']), intval($recurso['id'])]);
                        }
                    }
                    
                    // Confirmar transacción
                    $this->commit();
                    return $produccionId;
                }
            }
            
            $this->rollback();
            return false;
            
        } catch (Exception $e) {
            $this->rollback();
            error_log("Error en insertProduccion: " . $e->getMessage());
            return false;
        }
    }
    
    public function getCategorias()
    {
        $sql = "SELECT * FROM categorias WHERE estado = 1 ORDER BY nombre ASC";
        return $this->select_all($sql);
    }

    public function getDetalleProduccion($idProduccion)
    {
        $sql = "SELECT dp.*, 
                COALESCE(p.nombre, dp.recurso_manual) as producto_recurso, 
                COALESCE(p.codigo, 'MANUAL') as codigo
                FROM detalle_produccion dp
                LEFT JOIN productos p ON dp.producto_recurso_id = p.id
                WHERE dp.produccion_id = " . intval($idProduccion);
        return $this->select_all($sql);
    }
}