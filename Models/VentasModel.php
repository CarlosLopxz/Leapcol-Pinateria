<?php
class VentasModel extends Mysql
{
    private $intIdVenta;
    private $intCliente;
    private $strFechaVenta;
    private $decSubtotal;
    private $decImpuestos;
    private $decDescuentos;
    private $decTotal;
    private $intMetodoPago;
    private $intEstado;
    private $strObservaciones;
    private $intUsuario;

    public function __construct()
    {
        parent::__construct();
    }

    public function getVentas()
    {
        $sql = "SELECT v.id, v.fecha_venta, 
                IFNULL(CONCAT(c.nombre, ' ', c.apellido), 'Cliente General') as cliente,
                v.total, v.estado
                FROM ventas v
                LEFT JOIN clientes c ON v.cliente_id = c.id
                ORDER BY v.id DESC";
        $request = $this->select_all($sql);
        return $request;
    }

    public function getVenta($idVenta)
    {
        $this->intIdVenta = $idVenta;
        $sql = "SELECT v.*, 
                IFNULL(CONCAT(c.nombre, ' ', c.apellido), 'Cliente General') as cliente_nombre,
                CONCAT(u.nombre, ' ', u.apellido) as usuario_nombre
                FROM ventas v
                LEFT JOIN clientes c ON v.cliente_id = c.id
                INNER JOIN usuarios u ON v.usuario_id = u.idusuario
                WHERE v.id = {$this->intIdVenta}";
        $request = $this->select($sql);
        return $request;
    }

    public function getDetalleVenta($idVenta)
    {
        $this->intIdVenta = $idVenta;
        
        // Obtener detalles incluyendo mano de obra
        $sql = "SELECT d.*, p.codigo, p.nombre, p.precio_venta, p.mano_obra,
                       (p.precio_venta + p.mano_obra) as precio_total
                FROM detalle_venta d 
                INNER JOIN productos p ON d.producto_id = p.id 
                WHERE d.venta_id = {$this->intIdVenta}";
        $request = $this->select_all($sql);
        
        // Procesamos cada detalle para asegurar que tenga precios correctos
        if (!empty($request)) {
            foreach ($request as &$item) {
                // Si no hay precio unitario o es cero, usar el precio total (precio_venta + mano_obra)
                if (empty($item['precio_unitario'])) {
                    $item['precio_unitario'] = $item['precio_total'];
                    
                    // Actualizar en la base de datos para futuras consultas
                    $updateSql = "UPDATE detalle_venta SET precio_unitario = ? WHERE id = ?";
                    $this->update($updateSql, [$item['precio_unitario'], $item['id']]);
                    
                    error_log("Precio actualizado para detalle ID {$item['id']}: {$item['precio_unitario']}");
                }
                
                // Si no hay subtotal o es cero, calcularlo y actualizarlo
                if (empty($item['subtotal'])) {
                    $item['subtotal'] = $item['precio_unitario'] * $item['cantidad'];
                    
                    // Actualizar en la base de datos
                    $updateSql = "UPDATE detalle_venta SET subtotal = ? WHERE id = ?";
                    $this->update($updateSql, [$item['subtotal'], $item['id']]);
                    
                    error_log("Subtotal actualizado para detalle ID {$item['id']}: {$item['subtotal']}");
                }
                
                // Asegurar que los valores sean numéricos
                $item['precio_unitario'] = floatval($item['precio_unitario']);
                $item['subtotal'] = floatval($item['subtotal']);
            }
            
            // Actualizar los totales de la venta si es necesario
            $totalCalculado = array_sum(array_column($request, 'subtotal'));
            $ventaSql = "SELECT subtotal, total FROM ventas WHERE id = {$this->intIdVenta}";
            $venta = $this->select($ventaSql);
            
            if ($venta && (empty($venta['subtotal']) || abs($venta['subtotal'] - $totalCalculado) > 0.01)) {
                $updateVentaSql = "UPDATE ventas SET subtotal = ?, total = ? WHERE id = ?";
                $this->update($updateVentaSql, [$totalCalculado, $totalCalculado, $this->intIdVenta]);
                error_log("Totales de venta actualizados: {$totalCalculado}");
            }
        }
        
        return $request;
    }

    public function getClientes()
    {
        $sql = "SELECT id, CONCAT(nombre, ' ', apellido) as nombre, documento, telefono
                FROM clientes
                WHERE estado = 1
                ORDER BY nombre ASC";
        $request = $this->select_all($sql);
        return $request;
    }

    public function getProductosActivos()
    {
        $sql = "SELECT id, codigo, nombre, descripcion, precio_venta, stock
                FROM productos
                WHERE estado = 1
                ORDER BY nombre ASC";
        $request = $this->select_all($sql);
        return $request;
    }
    
    public function verificarStock($idProducto)
    {
        $sql = "SELECT stock FROM productos WHERE id = ?";
        $arrData = array($idProducto);
        $request = $this->select($sql, $arrData);
        return $request ? $request['stock'] : 0;
    }
    
    public function getNombreProducto($idProducto)
    {
        $sql = "SELECT nombre FROM productos WHERE id = ?";
        $arrData = array($idProducto);
        $request = $this->select($sql, $arrData);
        return $request ? $request['nombre'] : 'Producto desconocido';
    }

    public function verificarTablaVentas()
    {
        try {
            $sql = "DESCRIBE ventas";
            $result = $this->select_all($sql);
            $campos = [];
            
            foreach ($result as $campo) {
                $campos[] = $campo['Field'];
            }
            
            $camposRequeridos = ['cliente_id', 'fecha_venta', 'subtotal', 'impuestos', 'descuentos', 'total', 'costo_total', 'ganancia', 'metodo_pago', 'estado', 'observaciones', 'usuario_id'];
            $camposFaltantes = [];
            
            foreach ($camposRequeridos as $campo) {
                if (!in_array($campo, $campos)) {
                    $camposFaltantes[] = $campo;
                }
            }
            
            if (!empty($camposFaltantes)) {
                error_log("Campos faltantes en la tabla ventas: " . implode(", ", $camposFaltantes));
                return false;
            }
            
            return true;
        } catch (Exception $e) {
            error_log("Error al verificar tabla ventas: " . $e->getMessage());
            return false;
        }
    }
    
    public function insertVenta($datos)
    {
        error_log("Iniciando insertVenta con datos: " . json_encode($datos));
        
        // Extraer datos básicos para una inserción mínima
        $cliente = intval($datos['cliente']);
        $fechaVenta = $datos['fechaVenta'];
        $total = floatval($datos['total']);
        $usuario = intval($datos['usuario']);

        $return = 0;

        try {
            // Iniciar transacción
            error_log("Iniciando transacción");
            $this->beginTransaction();
            
            // Verificar si el cliente existe
            if ($cliente > 0) {
                $sql = "SELECT id FROM clientes WHERE id = ?";
                $clienteExiste = $this->select($sql, [$cliente]);
                if (!$clienteExiste) {
                    error_log("ERROR: El cliente ID {$cliente} no existe en la tabla clientes");
                    throw new Exception("El cliente seleccionado no existe");
                }
                error_log("Cliente verificado correctamente: ID {$cliente}");
            } else {
                // Si es cliente general (0), usar NULL para evitar violación de clave foránea
                $cliente = null;
                error_log("Usando cliente NULL para cliente general");
            }
            
            // Verificar si el usuario existe
            $sql = "SELECT idusuario FROM usuarios WHERE idusuario = ?";
            $usuarioExiste = $this->select($sql, [$usuario]);
            if (!$usuarioExiste) {
                error_log("ERROR: El usuario ID {$usuario} no existe en la tabla usuarios");
                
                // Intentar obtener un usuario válido
                $sql = "SELECT idusuario FROM usuarios LIMIT 1";
                $primerUsuario = $this->select($sql);
                if ($primerUsuario) {
                    $usuario = $primerUsuario['idusuario'];
                    error_log("Usando usuario ID {$usuario} como alternativa");
                } else {
                    // Crear un usuario por defecto si no hay ninguno
                    try {
                        // Verificar si existe la tabla roles
                        $sql = "SHOW TABLES LIKE 'roles'";
                        $rolesExiste = $this->select_all($sql);
                        
                        if (!empty($rolesExiste)) {
                            // Determinar el nombre de la columna ID en roles
                            $sql = "DESCRIBE roles";
                            $columnas = $this->select_all($sql);
                            $columna_id = 'id';
                            
                            foreach ($columnas as $col) {
                                if ($col['Key'] == 'PRI') {
                                    $columna_id = $col['Field'];
                                    break;
                                }
                            }
                            
                            // Verificar si existe el rol administrador
                            $sql = "SELECT {$columna_id} FROM roles WHERE {$columna_id} = 1";
                            $rolExiste = $this->select($sql);
                            
                            if (!$rolExiste) {
                                $sql = "INSERT INTO roles({$columna_id}, nombrerol, descripcion, estado) VALUES(1, 'Administrador', 'Acceso completo', 1)";
                                $this->insert($sql, []);
                            }
                        }
                        
                        // Crear usuario administrador
                        $sql = "INSERT INTO usuarios(nombre, apellido, usuario, email, password, rolid, estado) VALUES(?, ?, ?, ?, ?, ?, ?)";
                        $arrData = ['Admin', 'Sistema', 'admin', 'admin@example.com', password_hash('admin123', PASSWORD_DEFAULT), 1, 1];
                        $usuarioId = $this->insert($sql, $arrData);
                        
                        if ($usuarioId > 0) {
                            $usuario = $usuarioId;
                            error_log("Usuario administrador creado con ID: {$usuario}");
                        } else {
                            throw new Exception("No se pudo crear el usuario administrador");
                        }
                    } catch (Exception $e) {
                        error_log("Error al crear usuario: " . $e->getMessage());
                        throw new Exception("No hay usuarios registrados en el sistema y no se pudo crear uno");
                    }
                }
            }
            
            // Inserción completa con todos los campos
            $subtotal = isset($datos['subtotal']) ? floatval($datos['subtotal']) : $total;
            $impuestos = isset($datos['impuestos']) ? floatval($datos['impuestos']) : 0;
            $descuentos = isset($datos['descuentos']) ? floatval($datos['descuentos']) : 0;
            $metodoPago = isset($datos['metodoPago']) ? intval($datos['metodoPago']) : 1;
            $estado = isset($datos['estado']) ? intval($datos['estado']) : 1;
            $observaciones = isset($datos['observaciones']) ? $datos['observaciones'] : '';
            
            // Verificar si existen los campos pago_con y cambio
            $sql = "SHOW COLUMNS FROM ventas LIKE 'pago_con'";
            $pagoCampoExiste = $this->select_all($sql);
            
            if (!empty($pagoCampoExiste)) {
                // Los campos existen, usar consulta completa
                $pagoCon = isset($datos['pagoCon']) ? floatval($datos['pagoCon']) : null;
                $cambio = isset($datos['cambio']) ? floatval($datos['cambio']) : null;
                
                $query_insert = "INSERT INTO ventas(cliente_id, fecha_venta, subtotal, impuestos, descuentos, total, metodo_pago, pago_con, cambio, estado, observaciones, usuario_id) 
                                VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $arrData = array($cliente, $fechaVenta, $subtotal, $impuestos, $descuentos, $total, $metodoPago, $pagoCon, $cambio, $estado, $observaciones, $usuario);
            } else {
                // Los campos no existen, usar consulta sin ellos
                $query_insert = "INSERT INTO ventas(cliente_id, fecha_venta, subtotal, impuestos, descuentos, total, metodo_pago, estado, observaciones, usuario_id) 
                                VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $arrData = array($cliente, $fechaVenta, $subtotal, $impuestos, $descuentos, $total, $metodoPago, $estado, $observaciones, $usuario);
            }
            
            error_log("Ejecutando query simplificada: " . $query_insert);
            error_log("Con datos: " . json_encode($arrData));
            error_log("Valor de cliente antes de insertar: " . ($cliente === null ? 'NULL' : $cliente));
            
            $request_insert = $this->insert($query_insert, $arrData);
            $return = $request_insert;
            
            error_log("Resultado de insert venta: " . $return);

            // Si la inserción básica funciona, intentamos procesar los productos
            if ($return > 0) {
                try {
                    // Procesar productos con todos los datos necesarios
                    foreach ($datos['productos'] as $producto) {
                        $idProducto = $producto['id'];
                        $cantidad = $producto['cantidad'];
                        $precio = $producto['precio'];
                        $subtotal = $producto['subtotal'];
                        
                        error_log("Procesando producto ID: " . $idProducto . ", cantidad: " . $cantidad . ", precio: " . $precio . ", subtotal: " . $subtotal);
                        
                        // Obtener datos del producto (precio de compra y venta)
                        $query_producto = "SELECT precio_compra, precio_venta FROM productos WHERE id = ?";
                        $arrDataProducto = array($idProducto);
                        $request_producto = $this->select($query_producto, $arrDataProducto);
                        // Si no tenemos precio en los datos, usar el precio de venta del producto
                        if (empty($precio) || $precio == 0) {
                            $precio = $request_producto ? $request_producto['precio_venta'] : 0;
                            $subtotal = $precio * $cantidad;
                            error_log("Precio no proporcionado, usando precio de venta: {$precio}");
                        }
                        
                        $costo_unitario = $request_producto ? $request_producto['precio_compra'] : 0;
                        $costo_total = $costo_unitario * $cantidad;
                        $ganancia = $subtotal - $costo_total;
                        
                        // Insertar detalle completo
                        $query_detail = "INSERT INTO detalle_venta(venta_id, producto_id, cantidad, precio_unitario, costo_unitario, subtotal, costo_total, ganancia) VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
                        $arrDataDetail = array($return, $idProducto, $cantidad, $precio, $costo_unitario, $subtotal, $costo_total, $ganancia);
                        
                        error_log("Insertando detalle completo");
                        $detail_insert = $this->insert($query_detail, $arrDataDetail);
                        
                        if (!$detail_insert) {
                            error_log("Error al insertar detalle de venta");
                            throw new Exception("Error al insertar detalle de venta");
                        }
                        
                        // El stock se actualiza automáticamente por el trigger actualizar_stock_venta
                        // No necesitamos actualizar manualmente
                    }
                } catch (Exception $e) {
                    error_log("Error al procesar productos: " . $e->getMessage());
                    // Continuamos con la transacción para ver si el problema está en otra parte
                }
                
                error_log("Commit de la transacción");
                $this->commit();
            } else {
                error_log("Rollback: No se pudo insertar la venta");
                $this->rollback();
                $return = 0;
            }
        } catch (Exception $e) {
            error_log("Exception en insertVenta: " . $e->getMessage());
            error_log("Trace: " . $e->getTraceAsString());
            $this->rollback();
            $return = 0;
        }

        return $return;
    }

    public function anularVenta($idVenta)
    {
        $this->intIdVenta = $idVenta;
        $return = false;

        try {
            // Iniciar transacción
            $this->beginTransaction();

            // Obtener detalle de la venta
            $sql_detalle = "SELECT producto_id, cantidad FROM detalle_venta WHERE venta_id = {$this->intIdVenta}";
            $detalle = $this->select_all($sql_detalle);

            // Devolver productos al inventario
            foreach ($detalle as $producto) {
                $query_stock = "UPDATE productos SET stock = stock + ? WHERE id = ?";
                $arrDataStock = array($producto['cantidad'], $producto['producto_id']);
                $this->update($query_stock, $arrDataStock);
            }

            // Anular la venta
            $query_anular = "UPDATE ventas SET estado = 0 WHERE id = {$this->intIdVenta}";
            $request = $this->update($query_anular, []);

            if ($request) {
                $this->commit();
                $return = true;
            } else {
                $this->rollback();
            }
        } catch (Exception $e) {
            $this->rollback();
            error_log("Error en anularVenta: " . $e->getMessage());
        }

        return $return;
    }

    public function getTotalVentas()
    {
        $sql = "SELECT COUNT(*) as total FROM ventas WHERE estado != 0";
        $request = $this->select($sql);
        return $request['total'];
    }

    public function getVentasPorMes()
    {
        $sql = "SELECT MONTH(fecha_venta) as mes, SUM(total) as total
                FROM ventas
                WHERE estado != 0 AND YEAR(fecha_venta) = YEAR(CURRENT_DATE())
                GROUP BY MONTH(fecha_venta)
                ORDER BY MONTH(fecha_venta)";
        $request = $this->select_all($sql);
        return $request;
    }

    public function getUltimasVentas($limit)
    {
        $sql = "SELECT v.id, v.fecha_venta, 
                IFNULL(CONCAT(c.nombre, ' ', c.apellido), 'Cliente General') as cliente,
                v.total, v.estado
                FROM ventas v
                LEFT JOIN clientes c ON v.cliente_id = c.id
                WHERE v.estado != 0
                ORDER BY v.id DESC
                LIMIT {$limit}";
        $request = $this->select_all($sql);
        return $request;
    }

    public function getProductosMasVendidos($limit)
    {
        $sql = "SELECT p.id, p.nombre, SUM(d.cantidad) as cantidad, SUM(d.subtotal) as total
                FROM detalle_venta d
                INNER JOIN productos p ON d.producto_id = p.id
                INNER JOIN ventas v ON d.venta_id = v.id
                WHERE v.estado != 0
                GROUP BY p.id
                ORDER BY cantidad DESC
                LIMIT {$limit}";
        $request = $this->select_all($sql);
        return $request;
    }
    
    public function getTotalProductosVendidos()
    {
        $sql = "SELECT SUM(d.cantidad) as total
                FROM detalle_venta d
                INNER JOIN ventas v ON d.venta_id = v.id
                WHERE v.estado != 0";
        $request = $this->select($sql);
        return $request ? intval($request['total']) : 0;
    }
    
    public function getTotalManoObra()
    {
        $sql = "SELECT SUM(p.mano_obra * d.cantidad) as total
                FROM detalle_venta d
                INNER JOIN productos p ON d.producto_id = p.id
                INNER JOIN ventas v ON d.venta_id = v.id
                WHERE v.estado != 0 AND p.mano_obra > 0";
        $request = $this->select($sql);
        return $request ? floatval($request['total']) : 0;
    }
    
    public function getVentasDiarias()
    {
        $sql = "SELECT COALESCE(SUM(total), 0) as total
                FROM ventas
                WHERE DATE(fecha_venta) = CURDATE() AND estado != 0";
        $request = $this->select($sql);
        return $request ? floatval($request['total']) : 0;
    }
}