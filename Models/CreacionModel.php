<?php
class CreacionModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getInventarioCreacion()
    {
        $sql = "SELECT ic.*, p.codigo, p.nombre, p.precio_venta, c.nombre as categoria
                FROM inventario_creacion ic
                INNER JOIN productos p ON ic.producto_id = p.id
                INNER JOIN categorias c ON p.categoria_id = c.id
                WHERE ic.stock_creacion > 0
                ORDER BY p.nombre ASC";
        return $this->select_all($sql);
    }
    
    public function getCajaCreacionActual()
    {
        $sql = "SELECT cc.*, u.nombre as usuario
                FROM caja_creacion cc
                INNER JOIN usuarios u ON cc.usuario_id = u.idusuario
                WHERE cc.estado = 1
                ORDER BY cc.id DESC LIMIT 1";
        return $this->select($sql);
    }
    
    public function getMovimientosCajaCreacion($limit = 50)
    {
        $sql = "SELECT mcc.*, p.nombre as producto_nombre
                FROM movimientos_caja_creacion mcc
                LEFT JOIN ventas v ON mcc.venta_id = v.id
                LEFT JOIN detalle_venta dv ON v.id = dv.venta_id
                LEFT JOIN productos p ON dv.producto_id = p.id
                WHERE mcc.caja_creacion_id = (
                    SELECT id FROM caja_creacion WHERE estado = 1 ORDER BY id DESC LIMIT 1
                )
                ORDER BY mcc.fecha DESC
                LIMIT " . intval($limit);
        return $this->select_all($sql);
    }
    
    public function abrirCajaCreacion($montoInicial, $observaciones, $usuarioId)
    {
        // Verificar si hay una caja abierta
        $cajaAbierta = $this->select("SELECT id FROM caja_creacion WHERE estado = 1");
        if($cajaAbierta) {
            return false; // Ya hay una caja abierta
        }
        
        $sql = "INSERT INTO caja_creacion (usuario_id, monto_inicial, observaciones) VALUES (?, ?, ?)";
        return $this->insert($sql, [$usuarioId, $montoInicial, $observaciones]);
    }
    
    public function cerrarCajaCreacion($montoFinal, $observaciones)
    {
        $sql = "UPDATE caja_creacion 
                SET fecha_cierre = NOW(), monto_final = ?, observaciones = CONCAT(observaciones, ' - Cierre: ', ?), estado = 0
                WHERE estado = 1";
        return $this->update($sql, [$montoFinal, $observaciones]);
    }
    
    public function getClienteCreacion()
    {
        $sql = "SELECT id FROM clientes WHERE nombre = 'Cliente' AND apellido = 'Chela' LIMIT 1";
        return $this->select($sql);
    }
    
    public function getResumenCreacion()
    {
        $sql = "SELECT 
                    COUNT(DISTINCT ic.producto_id) as total_productos,
                    COALESCE(SUM(ic.stock_creacion), 0) as total_stock,
                    COALESCE(SUM(ic.stock_creacion * ic.costo_promedio), 0) as valor_inventario,
                    COALESCE((SELECT total_gastado FROM caja_creacion WHERE estado = 1 LIMIT 1), 0) as total_gastos,
                    COALESCE((SELECT total_vendido FROM caja_creacion WHERE estado = 1 LIMIT 1), 0) as total_ventas
                FROM inventario_creacion ic
                WHERE ic.stock_creacion > 0";
        return $this->select($sql);
    }
    
    public function getClienteCreacionId()
    {
        $sql = "SELECT id FROM clientes WHERE nombre = 'Cliente' AND apellido = 'Chela' LIMIT 1";
        $result = $this->select($sql);
        return $result ? $result['id'] : null;
    }
    
    public function actualizarTotalGastado($monto)
    {
        $sql = "UPDATE caja_creacion SET total_gastado = total_gastado + ? WHERE estado = 1";
        return $this->update($sql, [$monto]);
    }
    
    public function actualizarTotalVendido($monto)
    {
        $sql = "UPDATE caja_creacion SET total_vendido = total_vendido + ? WHERE estado = 1";
        return $this->update($sql, [$monto]);
    }
    
    public function getResumenDiario()
    {
        $sql = "SELECT 
                    COALESCE(SUM(CASE WHEN tipo = 'gasto' THEN monto ELSE 0 END), 0) as gastos_diarios,
                    COALESCE(SUM(CASE WHEN tipo = 'venta' THEN monto ELSE 0 END), 0) as ventas_diarias
                FROM movimientos_caja_creacion 
                WHERE DATE(fecha) = CURDATE() 
                AND caja_creacion_id = (SELECT id FROM caja_creacion WHERE estado = 1 LIMIT 1)";
        return $this->select($sql);
    }
}