<?php
class ReportesModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    // Reportes de Ventas
    public function getVentasPorPeriodo($fechaInicio, $fechaFin)
    {
        $sql = "SELECT v.*, COALESCE(CONCAT(c.nombre, ' ', c.apellido), 'Cliente General') as cliente
                FROM ventas v
                LEFT JOIN clientes c ON v.cliente_id = c.id
                WHERE v.fecha_venta BETWEEN ? AND ? AND v.estado = 1
                ORDER BY v.fecha_venta DESC";
        return $this->select_all($sql, [$fechaInicio, $fechaFin]);
    }

    public function getProductosMasVendidos($limite = 10)
    {
        $sql = "SELECT p.nombre, p.codigo, SUM(dv.cantidad) as total_vendido, SUM(dv.subtotal) as total_ingresos
                FROM detalle_venta dv
                INNER JOIN productos p ON dv.producto_id = p.id
                INNER JOIN ventas v ON dv.venta_id = v.id
                WHERE v.estado = 1
                GROUP BY p.id, p.nombre, p.codigo
                ORDER BY total_vendido DESC
                LIMIT " . intval($limite);
        return $this->select_all($sql);
    }

    public function getVentasPorCategoria($fechaInicio, $fechaFin)
    {
        $sql = "SELECT c.nombre as categoria, SUM(dv.subtotal) as total, COUNT(dv.id) as cantidad
                FROM detalle_venta dv
                INNER JOIN productos p ON dv.producto_id = p.id
                INNER JOIN categorias c ON p.categoria_id = c.id
                INNER JOIN ventas v ON dv.venta_id = v.id
                WHERE v.fecha_venta BETWEEN ? AND ? AND v.estado = 1
                GROUP BY c.id, c.nombre
                ORDER BY total DESC";
        return $this->select_all($sql, [$fechaInicio, $fechaFin]);
    }

    public function getVentasDiarias($fechaInicio, $fechaFin)
    {
        $sql = "SELECT DATE(fecha_venta) as fecha, COUNT(*) as cantidad, SUM(total) as total
                FROM ventas
                WHERE fecha_venta BETWEEN ? AND ? AND estado = 1
                GROUP BY DATE(fecha_venta)
                ORDER BY fecha ASC";
        return $this->select_all($sql, [$fechaInicio, $fechaFin]);
    }

    // Reportes de Producción
    public function getProduccionesPorPeriodo($fechaInicio, $fechaFin)
    {
        $sql = "SELECT pr.*, p.nombre as producto_final
                FROM producciones pr
                INNER JOIN productos p ON pr.producto_final_id = p.id
                WHERE pr.fecha_produccion BETWEEN ? AND ? AND pr.estado = 1
                ORDER BY pr.fecha_produccion DESC";
        return $this->select_all($sql, [$fechaInicio, $fechaFin]);
    }

    public function getRecursosMasUtilizados($limite = 10)
    {
        $sql = "SELECT p.nombre, p.codigo, SUM(dp.cantidad_utilizada) as total_utilizado
                FROM detalle_produccion dp
                INNER JOIN productos p ON dp.producto_recurso_id = p.id
                INNER JOIN producciones pr ON dp.produccion_id = pr.id
                WHERE pr.estado = 1
                GROUP BY p.id, p.nombre, p.codigo
                ORDER BY total_utilizado DESC
                LIMIT " . intval($limite);
        return $this->select_all($sql);
    }

    // Reportes de Inventario
    public function getStockBajo()
    {
        $sql = "SELECT codigo, nombre, stock, stock_minimo, categoria_id
                FROM productos
                WHERE stock <= stock_minimo AND estado = 1
                ORDER BY (stock - stock_minimo) ASC";
        return $this->select_all($sql);
    }

    public function getInventarioGeneral()
    {
        $sql = "SELECT p.codigo, p.nombre, p.stock, p.precio_compra, p.precio_venta, 
                       (p.stock * p.precio_compra) as valor_inventario, c.nombre as categoria
                FROM productos p
                INNER JOIN categorias c ON p.categoria_id = c.id
                WHERE p.estado = 1
                ORDER BY p.nombre ASC";
        return $this->select_all($sql);
    }

    // Reportes Financieros
    public function getResumenFinanciero($fechaInicio, $fechaFin)
    {
        $sql = "SELECT 
                    SUM(total) as total_ventas,
                    SUM(costo_total) as total_costos,
                    SUM(ganancia) as total_ganancia,
                    COUNT(*) as total_transacciones
                FROM ventas
                WHERE fecha_venta BETWEEN ? AND ? AND estado = 1";
        return $this->select($sql, [$fechaInicio, $fechaFin]);
    }

    public function getClientesTop($limite = 10)
    {
        $sql = "SELECT COALESCE(CONCAT(c.nombre, ' ', c.apellido), 'Cliente General') as cliente,
                       COUNT(v.id) as total_compras,
                       SUM(v.total) as total_gastado
                FROM ventas v
                LEFT JOIN clientes c ON v.cliente_id = c.id
                WHERE v.estado = 1
                GROUP BY v.cliente_id, cliente
                ORDER BY total_gastado DESC
                LIMIT " . intval($limite);
        return $this->select_all($sql);
    }
}