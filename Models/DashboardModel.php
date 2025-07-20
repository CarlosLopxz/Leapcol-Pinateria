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
        return isset($request['total']) ? $request['total'] : 0;
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
    
    public function getTotalProductosVendidos()
    {
        $sql = "SELECT SUM(dv.cantidad) as total 
                FROM detalle_venta dv 
                INNER JOIN ventas v ON dv.id_venta = v.id 
                WHERE v.estado = 1";
        $request = $this->select($sql);
        return isset($request['total']) ? $request['total'] : 0;
    }
}