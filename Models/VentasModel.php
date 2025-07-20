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
        $sql = "SELECT d.*, p.codigo, p.nombre
                FROM detalle_venta d
                INNER JOIN productos p ON d.producto_id = p.id
                WHERE d.venta_id = {$this->intIdVenta}";
        $request = $this->select_all($sql);
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
                WHERE estado = 1 AND stock > 0
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
            } else {
                // Si es cliente general (0), usar NULL para evitar violación de clave foránea
                $cliente = null;
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
            
            // Inserción mínima para probar
            $query_insert = "INSERT INTO ventas(cliente_id, fecha_venta, total, usuario_id) VALUES(?, ?, ?, ?)";
            $arrData = array($cliente, $fechaVenta, $total, $usuario);
            
            error_log("Ejecutando query simplificada: " . $query_insert);
            error_log("Con datos: " . json_encode($arrData));
            
            $request_insert = $this->insert($query_insert, $arrData);
            $return = $request_insert;
            
            error_log("Resultado de insert venta: " . $return);

            // Si la inserción básica funciona, intentamos procesar los productos
            if ($return > 0) {
                try {
                    // Procesar productos de forma simplificada
                    foreach ($datos['productos'] as $producto) {
                        $idProducto = $producto['id'];
                        $cantidad = $producto['cantidad'];
                        
                        error_log("Procesando producto ID: " . $idProducto . ", cantidad: " . $cantidad);
                        
                        // Insertar detalle simplificado
                        $query_detail = "INSERT INTO detalle_venta(venta_id, producto_id, cantidad) VALUES(?, ?, ?)";
                        $arrDataDetail = array($return, $idProducto, $cantidad);
                        
                        error_log("Insertando detalle simplificado");
                        $detail_insert = $this->insert($query_detail, $arrDataDetail);
                        
                        if (!$detail_insert) {
                            error_log("Error al insertar detalle de venta");
                            throw new Exception("Error al insertar detalle de venta");
                        }
                        
                        // Actualizar stock
                        $query_stock = "UPDATE productos SET stock = stock - ? WHERE id = ?";
                        $arrDataStock = array($cantidad, $idProducto);
                        $this->update($query_stock, $arrDataStock);
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
}