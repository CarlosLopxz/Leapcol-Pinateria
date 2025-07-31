<?php
class CajaModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getCajaAbierta($usuarioId)
    {
        $sql = "SELECT c.*, 
                       (c.monto_inicial + COALESCE(c.total_ventas, 0) + 
                        (SELECT COALESCE(SUM(monto), 0) FROM movimientos_caja WHERE caja_id = c.id AND tipo = 'ingreso') - 
                        (SELECT COALESCE(SUM(monto), 0) FROM movimientos_caja WHERE caja_id = c.id AND tipo = 'egreso')) as total_actual
                FROM cajas c 
                WHERE c.usuario_id = ? AND c.estado = 1 
                ORDER BY c.id DESC LIMIT 1";
        return $this->select($sql, [intval($usuarioId)]);
    }

    public function abrirCaja($datos)
    {
        $query = "INSERT INTO cajas(usuario_id, monto_inicial, observaciones) VALUES(?, ?, ?)";
        $arrData = [
            $datos['usuario_id'],
            $datos['monto_inicial'],
            $datos['observaciones']
        ];
        return $this->insert($query, $arrData);
    }

    public function cerrarCaja($cajaId, $montoFinal, $observaciones)
    {
        // Actualizar totales antes de cerrar
        $this->actualizarTotalesCaja($cajaId);
        
        $sql = "UPDATE cajas SET fecha_cierre = NOW(), monto_final = ?, observaciones = CONCAT(COALESCE(observaciones, ''), ?, ?), estado = 0 WHERE id = ?";
        $arrData = [
            $montoFinal,
            $observaciones ? ' | Cierre: ' : '',
            $observaciones,
            intval($cajaId)
        ];
        return $this->update($sql, $arrData);
    }

    public function registrarMovimiento($datos)
    {
        $query = "INSERT INTO movimientos_caja(caja_id, tipo, concepto, monto, metodo_pago, venta_id, usuario_id) 
                  VALUES(?, ?, ?, ?, ?, ?, ?)";
        $arrData = [
            $datos['caja_id'],
            $datos['tipo'],
            $datos['concepto'],
            $datos['monto'],
            $datos['metodo_pago'],
            $datos['venta_id'] ?? null,
            $datos['usuario_id']
        ];
        return $this->insert($query, $arrData);
    }

    public function getMovimientos($cajaId)
    {
        $sql = "SELECT mc.*, u.nombre as usuario_nombre
                FROM movimientos_caja mc
                INNER JOIN usuarios u ON mc.usuario_id = u.idusuario
                WHERE mc.caja_id = ?
                ORDER BY mc.fecha DESC";
        return $this->select_all($sql, [intval($cajaId)]);
    }

    public function getResumenCaja($cajaId)
    {
        $sql = "SELECT 
                    c.*,
                    u.nombre as usuario_nombre,
                    (SELECT COALESCE(SUM(monto), 0) FROM movimientos_caja WHERE caja_id = c.id AND tipo = 'ingreso') as total_ingresos,
                    (SELECT COALESCE(SUM(monto), 0) FROM movimientos_caja WHERE caja_id = c.id AND tipo = 'egreso') as total_egresos,
                    COALESCE(c.total_ventas, 0) as total_ventas_caja,
                    COALESCE(c.total_efectivo, 0) as efectivo_ventas,
                    COALESCE(c.total_tarjeta, 0) as tarjeta_ventas,
                    COALESCE(c.total_transferencia, 0) as transferencia_ventas,
                    (c.monto_inicial + COALESCE(c.total_ventas, 0) + 
                     (SELECT COALESCE(SUM(monto), 0) FROM movimientos_caja WHERE caja_id = c.id AND tipo = 'ingreso') - 
                     (SELECT COALESCE(SUM(monto), 0) FROM movimientos_caja WHERE caja_id = c.id AND tipo = 'egreso')) as total_actual
                FROM cajas c
                INNER JOIN usuarios u ON c.usuario_id = u.idusuario
                WHERE c.id = ?";
        return $this->select($sql, [intval($cajaId)]);
    }

    public function actualizarTotalesCaja($cajaId)
    {
        $sql = "UPDATE cajas c SET 
                    total_ventas = (SELECT COALESCE(SUM(monto), 0) FROM movimientos_caja WHERE caja_id = c.id AND tipo = 'venta'),
                    total_efectivo = (SELECT COALESCE(SUM(monto), 0) FROM movimientos_caja WHERE caja_id = c.id AND tipo = 'venta' AND metodo_pago = 1),
                    total_tarjeta = (SELECT COALESCE(SUM(monto), 0) FROM movimientos_caja WHERE caja_id = c.id AND tipo = 'venta' AND metodo_pago = 2),
                    total_transferencia = (SELECT COALESCE(SUM(monto), 0) FROM movimientos_caja WHERE caja_id = c.id AND tipo = 'venta' AND metodo_pago = 4)
                WHERE id = ?";
        return $this->update($sql, [intval($cajaId)]);
    }

    public function getHistorialCajas($usuarioId = null, $limite = 20)
    {
        $sql = "SELECT c.*, 
                       u.nombre as usuario_nombre,
                       COALESCE(c.total_ventas, 0) as total_ventas,
                       COALESCE(c.total_efectivo, 0) as total_efectivo,
                       COALESCE(c.total_tarjeta, 0) as total_tarjeta,
                       COALESCE(c.total_transferencia, 0) as total_transferencia,
                       (SELECT COUNT(*) FROM movimientos_caja WHERE caja_id = c.id AND tipo = 'venta') as cantidad_ventas,
                       (SELECT COALESCE(SUM(monto), 0) FROM movimientos_caja WHERE caja_id = c.id AND tipo = 'ingreso') as total_ingresos_extra,
                       (SELECT COALESCE(SUM(monto), 0) FROM movimientos_caja WHERE caja_id = c.id AND tipo = 'egreso') as total_egresos
                FROM cajas c
                INNER JOIN usuarios u ON c.usuario_id = u.idusuario";
        
        $params = [];
        if($usuarioId) {
            $sql .= " WHERE c.usuario_id = ?";
            $params[] = intval($usuarioId);
        }
        
        $sql .= " ORDER BY c.fecha_apertura DESC LIMIT " . intval($limite);
        
        return $this->select_all($sql, $params);
    }
    
    public function getCaja($cajaId)
    {
        $sql = "SELECT c.*, u.nombre as usuario_nombre
                FROM cajas c
                INNER JOIN usuarios u ON c.usuario_id = u.idusuario
                WHERE c.id = ?";
        return $this->select($sql, [intval($cajaId)]);
    }
}