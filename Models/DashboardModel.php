<?php

class DashboardModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function getTotalVentas()
    {
        $sql = "SELECT COUNT(*) as total FROM ventas WHERE estado = 1";
        $request = $this->select($sql);
        $total = isset($request['total']) ? $request['total'] : 0;
        error_log("Total de ventas: " . $total);
        return $total;
    }
    
    public function getVentasMes()
    {
        $sql = "SELECT SUM(total) as total FROM ventas 
                WHERE MONTH(fecha_venta) = MONTH(CURRENT_DATE()) 
                AND YEAR(fecha_venta) = YEAR(CURRENT_DATE())
                AND estado = 1";
        $request = $this->select($sql);
        return isset($request['total']) ? $request['total'] : 0;
    }
    
    public function getTotalClientes()
    {
        $sql = "SELECT COUNT(*) as total FROM clientes WHERE estado = 1";
        $request = $this->select($sql);
        return isset($request['total']) ? $request['total'] : 0;
    }
    
    public function getTotalProductos()
    {
        $sql = "SELECT COUNT(*) as total FROM productos WHERE estado = 1";
        $request = $this->select($sql);
        return isset($request['total']) ? $request['total'] : 0;
    }
    
    public function getTotalIngresos()
    {
        // Obtener el total de la caja abierta actual
        $sql = "SELECT 
                    (c.monto_inicial + COALESCE(c.total_ventas, 0) + 
                     COALESCE((SELECT SUM(monto) FROM movimientos_caja WHERE caja_id = c.id AND tipo = 'ingreso'), 0) - 
                     COALESCE((SELECT SUM(monto) FROM movimientos_caja WHERE caja_id = c.id AND tipo = 'egreso'), 0)) as total_actual
                FROM cajas c 
                WHERE c.estado = 1 
                ORDER BY c.id DESC LIMIT 1";
        $request = $this->select($sql);
        return isset($request['total_actual']) ? $request['total_actual'] : 0;
    }
    
    public function getVentasRecientes()
    {
        $sql = "SELECT v.id, 
                       COALESCE(CONCAT(c.nombre, ' ', c.apellido), 'Cliente General') as cliente,
                       v.fecha_venta, 
                       v.total
                FROM ventas v
                LEFT JOIN clientes c ON v.cliente_id = c.id
                WHERE v.estado = 1
                ORDER BY v.fecha_venta DESC
                LIMIT 5";
        return $this->select_all($sql);
    }
    
    public function getVentasPorMes()
    {
        $sql = "SELECT 
                    MONTH(fecha_venta) as mes,
                    SUM(total) as total,
                    COUNT(*) as cantidad_ventas
                FROM ventas 
                WHERE estado = 1 AND YEAR(fecha_venta) = YEAR(CURDATE())
                GROUP BY MONTH(fecha_venta)
                ORDER BY MONTH(fecha_venta)";
        $result = $this->select_all($sql);
        
        // Debug: registrar en log los datos obtenidos
        error_log("Datos de ventas por mes: " . json_encode($result));
        
        return $result ?: [];
    }
}