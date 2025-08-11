<?php
// MODIFICACIÓN PARA VENTAS.PHP - AGREGAR AL MÉTODO setVenta()

// En el método setVenta(), después de obtener los datos básicos, agregar:

// Determinar destino basado en cliente
$destino = ($cliente == 8) ? 'creacion' : 'normal';

// Modificar el array $datos para incluir destino:
$datos = [
    'idVenta' => $idVenta,
    'cliente' => $cliente,
    'destino' => $destino,  // NUEVO CAMPO
    'fechaVenta' => $fechaVenta,
    'subtotal' => $subtotal,
    'impuestos' => $impuestos,
    'descuentos' => $descuentos,
    'total' => $total,
    'metodoPago' => $metodoPago,
    'pagoCon' => $pagoCon,
    'cambio' => $cambio,
    'estado' => $estado,
    'observaciones' => $observaciones,
    'usuario' => $usuario,
    'productos' => $productos
];

// CÓDIGO COMPLETO PARA REEMPLAZAR EN setVenta():
/*
// Después de la línea: $cliente = intval($_POST['cliente']);
// Agregar:
$destino = ($cliente == 8) ? 'creacion' : 'normal';

// En el array $datos, agregar la línea:
'destino' => $destino,
*/
?>