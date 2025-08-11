<?php
// MODIFICACIONES PARA VentasModel.php

// AGREGAR AL MÉTODO insertVenta() después de obtener los datos básicos:

// Determinar destino
$destino = isset($datos['destino']) ? $datos['destino'] : 'normal';

// MODIFICAR LA CONSULTA SQL PARA INCLUIR EL CAMPO DESTINO:

// Cambiar esta línea:
// $query_insert = "INSERT INTO ventas(cliente_id, fecha_venta, subtotal, impuestos, descuentos, total, metodo_pago, pago_con, cambio, estado, observaciones, usuario_id) 

// Por esta:
// $query_insert = "INSERT INTO ventas(cliente_id, destino, fecha_venta, subtotal, impuestos, descuentos, total, metodo_pago, pago_con, cambio, estado, observaciones, usuario_id) 

// Y en el array de datos agregar $destino:
// $arrData = array($cliente, $destino, $fechaVenta, $subtotal, $impuestos, $descuentos, $total, $metodoPago, $pagoCon, $cambio, $estado, $observaciones, $usuario);

// CÓDIGO COMPLETO PARA REEMPLAZAR EN insertVenta():
/*
// Después de la línea: $observaciones = isset($datos['observaciones']) ? $datos['observaciones'] : '';
// Agregar:
$destino = isset($datos['destino']) ? $datos['destino'] : 'normal';

// Cambiar la consulta SQL:
if (!empty($pagoCampoExiste)) {
    $pagoCon = isset($datos['pagoCon']) ? floatval($datos['pagoCon']) : null;
    $cambio = isset($datos['cambio']) ? floatval($datos['cambio']) : null;
    
    $query_insert = "INSERT INTO ventas(cliente_id, destino, fecha_venta, subtotal, impuestos, descuentos, total, metodo_pago, pago_con, cambio, estado, observaciones, usuario_id) 
                    VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $arrData = array($cliente, $destino, $fechaVenta, $subtotal, $impuestos, $descuentos, $total, $metodoPago, $pagoCon, $cambio, $estado, $observaciones, $usuario);
} else {
    $query_insert = "INSERT INTO ventas(cliente_id, destino, fecha_venta, subtotal, impuestos, descuentos, total, metodo_pago, estado, observaciones, usuario_id) 
                    VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $arrData = array($cliente, $destino, $fechaVenta, $subtotal, $impuestos, $descuentos, $total, $metodoPago, $estado, $observaciones, $usuario);
}
*/
?>