<?php
require_once "Libraries/Core/AuthController.php";

// Verificar si Composer está instalado y cargar autoload
if (file_exists('vendor/autoload.php')) {
    require_once 'vendor/autoload.php';
}

class Ventas extends AuthController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['page_tag'] = "Ventas - " . NOMBRE_EMPRESA;
        $data['page_title'] = "Gestión de Ventas";
        $data['page_name'] = "ventas";
        $this->views->getView($this, "ventas", $data);
    }
    
    public function pos()
    {
        $data['page_tag'] = "Punto de Venta - " . NOMBRE_EMPRESA;
        $data['page_title'] = "Punto de Venta";
        $data['page_name'] = "pos";
        $this->views->getView($this, "pos", $data);
    }
    
    public function getVentas()
    {
        try {
            header('Content-Type: application/json; charset=utf-8');
            $arrData = $this->model->getVentas();
            if (empty($arrData)) {
                $arrData = [];
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            error_log("Error en getVentas: " . $e->getMessage());
            echo json_encode([], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function getVenta($idVenta)
    {
        try {
            header('Content-Type: application/json; charset=utf-8');
            $idVenta = intval($idVenta);
            if($idVenta > 0) {
                $arrData = $this->model->getVenta($idVenta);
                if($arrData) {
                    $arrData['detalle'] = $this->model->getDetalleVenta($idVenta);
                    echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
                } else {
                    echo json_encode(['error' => 'Venta no encontrada'], JSON_UNESCAPED_UNICODE);
                }
            } else {
                echo json_encode(['error' => 'ID de venta inválido'], JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $e) {
            error_log("Error en getVenta: " . $e->getMessage());
            echo json_encode(['error' => 'Error al obtener la venta'], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function getClientes()
    {
        try {
            header('Content-Type: application/json; charset=utf-8');
            $arrData = $this->model->getClientes();
            if (empty($arrData)) {
                $arrData = [];
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            error_log("Error en getClientes: " . $e->getMessage());
            echo json_encode([], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function getProductos()
    {
        try {
            header('Content-Type: application/json; charset=utf-8');
            $arrData = $this->model->getProductosActivos();
            if (empty($arrData)) {
                $arrData = [];
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            error_log("Error en getProductos: " . $e->getMessage());
            echo json_encode([], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function setVenta()
    {
        try {
            // Asegurar que se envía el header antes de cualquier salida
            header('Content-Type: application/json; charset=utf-8');
            error_log("Iniciando setVenta");
            
            if($_POST) {
                error_log("POST data recibida: " . json_encode($_POST));
                
                // Validación de campos obligatorios
                if(empty($_POST['productos']) || empty($_POST['total'])) {
                    $arrResponse = ['status' => false, 'msg' => 'Debe agregar al menos un producto'];
                    error_log("Error: Campos obligatorios faltantes");
                } else {
                    // Datos de la venta
                    $idVenta = intval($_POST['idVenta']);
                    $cliente = intval($_POST['cliente']);
                    
                    // Si es cliente general (0), usar NULL para evitar violación de clave foránea
                    if ($cliente === 0) {
                        $cliente = null;
                        error_log("Cliente general seleccionado, usando NULL para cliente_id");
                    }
                    
                    $fechaVenta = date('Y-m-d H:i:s');
                    $subtotal = floatval($_POST['subtotal']);
                    $impuestos = floatval($_POST['impuestos']);
                    $descuentos = floatval($_POST['descuentos']);
                    $total = floatval($_POST['total']);
                    $metodoPago = intval($_POST['metodo_pago']);
                    $estado = 1; // Completada
                    $observaciones = strClean($_POST['observaciones']);
                    
                    // Verificar si existe la sesión y el usuario
                    if (!isset($_SESSION['userData']) || !isset($_SESSION['userData']['idusuario'])) {
                        error_log("Error: No hay sesión de usuario activa, usando ID 1");
                        $usuario = 1; // Usar ID 1 como fallback
                    } else {
                        $usuario = $_SESSION['userData']['idusuario'];
                    }
                    error_log("Usuario ID: " . $usuario);
                    
                    // Productos
                    $productos = json_decode($_POST['productos'], true);
                    error_log("Productos decodificados: " . json_encode($productos));
                    
                    if(empty($productos)) {
                        $arrResponse = ['status' => false, 'msg' => 'Debe agregar al menos un producto'];
                        error_log("Error: No hay productos en el JSON");
                    } else {
                        $datos = [
                            'idVenta' => $idVenta,
                            'cliente' => $cliente,
                            'fechaVenta' => $fechaVenta,
                            'subtotal' => $subtotal,
                            'impuestos' => $impuestos,
                            'descuentos' => $descuentos,
                            'total' => $total,
                            'metodoPago' => $metodoPago,
                            'estado' => $estado,
                            'observaciones' => $observaciones,
                            'usuario' => $usuario,
                            'productos' => $productos
                        ];
                        
                        error_log("Llamando a insertVenta con datos: " . json_encode($datos));
                        
                        // Verificar stock suficiente antes de procesar la venta
                        $stockSuficiente = true;
                        $productoSinStock = '';
                        
                        foreach ($productos as $producto) {
                            $idProducto = $producto['id'];
                            $cantidad = $producto['cantidad'];
                            
                            // Verificar stock actual
                            $stockActual = $this->model->verificarStock($idProducto);
                            if ($stockActual < $cantidad) {
                                $stockSuficiente = false;
                                $productoSinStock = $this->model->getNombreProducto($idProducto);
                                break;
                            }
                        }
                        
                        if (!$stockSuficiente) {
                            $arrResponse = [
                                'status' => false, 
                                'msg' => 'Stock insuficiente para el producto: ' . $productoSinStock
                            ];
                        } else {
                            // Nueva venta
                            error_log("Antes de llamar a insertVenta");
                            $result = $this->model->insertVenta($datos);
                            error_log("Resultado de insertVenta: " . $result);
                            
                            if($result > 0) {
                                $arrResponse = [
                                    'status' => true, 
                                    'msg' => 'Venta registrada correctamente', 
                                    'idVenta' => $result
                                ];
                            } else {
                                // Intentar obtener más información sobre el error
                                $errorMsg = 'Error al registrar la venta';
                                
                                // Verificar si hay errores en el log
                                $lastError = error_get_last();
                                if ($lastError) {
                                    error_log("Último error PHP: " . json_encode($lastError));
                                }
                                
                                $arrResponse = [
                                    'status' => false, 
                                    'msg' => $errorMsg,
                                    'debug' => true
                                ];
                            }
                        }
                    }
                }
                error_log("Respuesta final: " . json_encode($arrResponse));
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            } else {
                // Si no hay datos POST, devolver error
                error_log("Error: No se recibieron datos POST");
                echo json_encode(['status' => false, 'msg' => 'No se recibieron datos'], JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $e) {
            error_log("Error en setVenta: " . $e->getMessage());
            error_log("Trace: " . $e->getTraceAsString());
            // Asegurar que no se ha enviado ninguna salida antes
            if (!headers_sent()) {
                header('Content-Type: application/json; charset=utf-8');
            }
            
            // Mensaje de error más amigable para el usuario
            $errorMsg = 'Error al procesar la venta';
            
            // Si es un error específico, mostrar mensaje más detallado
            if (strpos($e->getMessage(), 'Stock insuficiente') !== false) {
                $errorMsg = 'Stock insuficiente para uno o más productos';
            } elseif (strpos($e->getMessage(), 'precio de compra') !== false) {
                $errorMsg = 'Error en los datos de productos. Contacte al administrador';
            } elseif (strpos($e->getMessage(), 'conexión') !== false) {
                $errorMsg = 'Error de conexión a la base de datos. Intente nuevamente';
            }
            
            echo json_encode(['status' => false, 'msg' => $errorMsg], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function anularVenta()
    {
        try {
            header('Content-Type: application/json; charset=utf-8');
            
            if($_POST) {
                $idVenta = intval($_POST['idVenta']);
                if($idVenta > 0) {
                    $result = $this->model->anularVenta($idVenta);
                    if($result) {
                        $arrResponse = ['status' => true, 'msg' => 'Venta anulada correctamente'];
                    } else {
                        $arrResponse = ['status' => false, 'msg' => 'Error al anular la venta'];
                    }
                } else {
                    $arrResponse = ['status' => false, 'msg' => 'ID de venta inválido'];
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $e) {
            error_log("Error en anularVenta: " . $e->getMessage());
            echo json_encode(['status' => false, 'msg' => 'Error al procesar la solicitud'], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function imprimirTicket($idVenta)
    {
        try {
            $idVenta = intval($idVenta);
            if($idVenta <= 0) {
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode(['status' => false, 'msg' => 'ID de venta inválido'], JSON_UNESCAPED_UNICODE);
                die();
            }
            
            // Obtener datos de la venta
            $venta = $this->model->getVenta($idVenta);
            if(!$venta) {
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode(['status' => false, 'msg' => 'Venta no encontrada'], JSON_UNESCAPED_UNICODE);
                die();
            }
            
            // Obtener detalle de la venta
            $detalle = $this->model->getDetalleVenta($idVenta);
            
            // Depurar los datos que llegan
            error_log("Datos de detalle de venta: " . json_encode($detalle));
            
            // Si no hay datos de precio, obtenerlos directamente
            if (!empty($detalle)) {
                foreach ($detalle as &$item) {
                    if (empty($item['precio_unitario']) || $item['precio_unitario'] == 0) {
                        // Obtener precio directamente de la tabla productos
                        $sql = "SELECT precio_venta FROM productos WHERE id = {$item['producto_id']}";
                        $producto = $this->model->select($sql);
                        if ($producto) {
                            $item['precio_unitario'] = $producto['precio_venta'];
                            $item['subtotal'] = $item['precio_unitario'] * $item['cantidad'];
                            error_log("Precio obtenido directamente: {$item['precio_unitario']}");
                        }
                    }
                }
            }
            
            // Verificar si TCPDF está disponible
            if (!class_exists('TCPDF')) {
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode(['status' => false, 'msg' => 'La librería TCPDF no está disponible. Ejecute "composer install" en el servidor.'], JSON_UNESCAPED_UNICODE);
                die();
            }
            
            // Crear nuevo documento PDF (tamaño de ticket más compacto)
            $pdf = new TCPDF('P', 'mm', array(80, 180), true, 'UTF-8', false);
            
            // Configurar documento
            $pdf->SetCreator(NOMBRE_EMPRESA);
            $pdf->SetAuthor(NOMBRE_EMPRESA);
            $pdf->SetTitle('Ticket #' . $venta['id']);
            $pdf->SetSubject('Ticket de Venta');
            
            // Eliminar cabecera y pie de página predeterminados
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            
            // Establecer márgenes más pequeños
            $pdf->SetMargins(3, 3, 3);
            $pdf->SetAutoPageBreak(true, 3);
            
            // Añadir página
            $pdf->AddPage();
            
            // Información de la empresa con formato mejorado
            $pdf->SetFont('helvetica', 'B', 12);
            $pdf->Cell(0, 5, NOMBRE_EMPRESA, 0, 1, 'C');
            
            $pdf->SetFont('helvetica', '', 7);
            $pdf->Cell(0, 3, DIRECCION, 0, 1, 'C');
            $pdf->Cell(0, 3, 'Tel: ' . TELEFONO, 0, 1, 'C');
            $pdf->Cell(0, 3, 'Email: ' . EMAIL, 0, 1, 'C');
            $pdf->Cell(0, 3, 'NIT: 900.123.456-7', 0, 1, 'C');
            
            // Línea separadora con estilo
            $pdf->Ln(1);
            $style = array('width' => 0.2, 'dash' => '3,2', 'color' => array(0, 0, 0));
            $pdf->Line(3, $pdf->GetY(), 77, $pdf->GetY(), $style);
            $pdf->Ln(2);
            
            // Información del ticket (más compacta)
            $pdf->SetFont('helvetica', 'B', 8);
            $pdf->Cell(0, 4, 'TICKET DE VENTA', 0, 1, 'C');
            
            $pdf->SetFont('helvetica', 'B', 7);
            $pdf->Cell(15, 4, 'TICKET #:', 0, 0);
            $pdf->SetFont('helvetica', '', 7);
            $pdf->Cell(20, 4, $venta['id'], 0, 0);
            
            $pdf->SetFont('helvetica', 'B', 7);
            $pdf->Cell(15, 4, 'FECHA:', 0, 0, 'R');
            $pdf->SetFont('helvetica', '', 7);
            $pdf->Cell(0, 4, date('d/m/Y H:i', strtotime($venta['fecha_venta'])), 0, 1);
            
            // Información del cliente (más compacta)
            $pdf->SetFillColor(240, 240, 240);
            $pdf->SetFont('helvetica', 'B', 7);
            $pdf->Cell(0, 4, 'DATOS DEL CLIENTE', 0, 1, 'L', true);
            
            $pdf->SetFont('helvetica', 'B', 7);
            $pdf->Cell(12, 3, 'Cliente:', 0, 0);
            $pdf->SetFont('helvetica', '', 7);
            $pdf->Cell(0, 3, ($venta['cliente_nombre'] ? $venta['cliente_nombre'] : 'Cliente General'), 0, 1);
            
            $pdf->SetFont('helvetica', 'B', 7);
            $pdf->Cell(12, 3, 'Atendió:', 0, 0);
            $pdf->SetFont('helvetica', '', 7);
            $pdf->Cell(0, 3, $venta['usuario_nombre'], 0, 1);
            
            // Línea separadora
            $pdf->Ln(1);
            $pdf->Line(3, $pdf->GetY(), 77, $pdf->GetY(), $style);
            $pdf->Ln(1);
            
            // Cabecera de productos con fondo
            $pdf->SetFillColor(220, 220, 220);
            $pdf->SetFont('helvetica', 'B', 7);
            $pdf->Cell(28, 5, 'PRODUCTO', 0, 0, 'L', true);
            $pdf->Cell(8, 5, 'CANT', 0, 0, 'C', true);
            $pdf->Cell(18, 5, 'PRECIO', 0, 0, 'R', true);
            $pdf->Cell(18, 5, 'TOTAL', 0, 1, 'R', true);
            
            // Detalle de productos
            $pdf->SetFont('helvetica', '', 7);
            $fill = false;
            
            if(!empty($detalle)) {
                foreach($detalle as $producto) {
                    // Calcular altura necesaria para el nombre del producto
                    $nombreProducto = $producto['nombre'];
                    if (strlen($nombreProducto) > 22) {
                        // Si el nombre es largo, cortarlo para la primera línea
                        $nombreCorto = substr($nombreProducto, 0, 22) . '...';
                    } else {
                        $nombreCorto = $nombreProducto;
                    }
                    
                    // Aumentar ligeramente la altura de la celda para asegurar que se vea todo el texto
                    $pdf->Cell(28, 4, $nombreCorto, 0, 0, 'L', $fill);
                    $pdf->Cell(8, 4, $producto['cantidad'], 0, 0, 'C', $fill);
                    
                    // Obtener precio directamente si no está disponible
                    if (empty($producto['precio_unitario']) || $producto['precio_unitario'] == 0) {
                        // Consultar el precio directamente de la tabla productos
                        $sql = "SELECT precio_venta FROM productos WHERE id = {$producto['producto_id']}";
                        $stmt = $this->model->conexion->prepare($sql);
                        $stmt->execute();
                        $result = $stmt->fetch(PDO::FETCH_ASSOC);
                        
                        if ($result) {
                            $producto['precio_unitario'] = $result['precio_venta'];
                        } else {
                            $producto['precio_unitario'] = 0;
                        }
                    }
                    
                    // Calcular subtotal si no está disponible
                    if (empty($producto['subtotal']) || $producto['subtotal'] == 0) {
                        $producto['subtotal'] = $producto['precio_unitario'] * $producto['cantidad'];
                    }
                    
                    // Formatear precios con menos decimales
                    $precioFormateado = '$' . number_format($producto['precio_unitario'], 0, ',', '.');
                    $subtotalFormateado = '$' . number_format($producto['subtotal'], 0, ',', '.');
                    
                    $pdf->Cell(18, 4, $precioFormateado, 0, 0, 'R', $fill);
                    $pdf->Cell(18, 4, $subtotalFormateado, 0, 1, 'R', $fill);
                    
                    // Alternar color de fondo
                    $fill = !$fill;
                }
            }
            
            // Línea separadora
            $pdf->Ln(1);
            $pdf->Line(3, $pdf->GetY(), 77, $pdf->GetY());
            $pdf->Ln(1);
            
            // Totales con fondo
            $pdf->SetFillColor(240, 240, 240);
            $pdf->SetFont('helvetica', 'B', 7);
            $pdf->Cell(45, 4, 'Subtotal:', 0, 0, 'R');
            $pdf->Cell(25, 4, '$' . number_format($venta['subtotal'], 0, ',', '.'), 0, 1, 'R');
            
            if($venta['impuestos'] > 0) {
                $pdf->Cell(45, 4, 'IVA (19%):', 0, 0, 'R');
                $pdf->Cell(25, 4, '$' . number_format($venta['impuestos'], 0, ',', '.'), 0, 1, 'R');
            }
            
            if($venta['descuentos'] > 0) {
                $pdf->Cell(45, 4, 'Descuento:', 0, 0, 'R');
                $pdf->Cell(25, 4, '$' . number_format($venta['descuentos'], 0, ',', '.'), 0, 1, 'R');
            }
            
            // Total con fondo destacado
            $pdf->SetFillColor(200, 200, 200);
            $pdf->SetFont('helvetica', 'B', 9);
            $pdf->Cell(45, 5, 'TOTAL:', 0, 0, 'R', true);
            $pdf->Cell(25, 5, '$' . number_format($venta['total'], 0, ',', '.'), 0, 1, 'R', true);
            
            // Método de pago
            $metodoPago = '';
            switch($venta['metodo_pago']) {
                case 1: $metodoPago = 'Efectivo'; break;
                case 2: $metodoPago = 'Tarjeta de Crédito'; break;
                case 3: $metodoPago = 'Tarjeta de Débito'; break;
                case 4: $metodoPago = 'Transferencia'; break;
                default: $metodoPago = 'Otro'; break;
            }
            
            $pdf->SetFont('helvetica', 'B', 7);
            $pdf->Cell(20, 4, 'Método de pago:', 0, 0);
            $pdf->SetFont('helvetica', '', 7);
            $pdf->Cell(0, 4, $metodoPago, 0, 1);
            
            // Línea separadora con estilo
            $pdf->Ln(2);
            $pdf->Line(5, $pdf->GetY(), 75, $pdf->GetY(), $style);
            $pdf->Ln(2);
            
            // Información adicional
            if (!empty($venta['observaciones'])) {
                $pdf->SetFont('helvetica', 'B', 8);
                $pdf->Cell(0, 4, 'Observaciones:', 0, 1);
                $pdf->SetFont('helvetica', '', 8);
                $pdf->MultiCell(0, 4, $venta['observaciones'], 0, 'L');
                $pdf->Ln(2);
            }
            
            // Código QR con el número de ticket (más pequeño)
            $style = array(
                'border' => false,
                'padding' => 0,
                'fgcolor' => array(0, 0, 0),
                'bgcolor' => false
            );
            $pdf->write2DBarcode('Ticket #' . $venta['id'] . ' - ' . NOMBRE_EMPRESA . ' - ' . $venta['fecha_venta'], 'QRCODE,L', 28, $pdf->GetY(), 24, 24, $style);
            $pdf->Ln(26);
            
            // Pie del ticket
            $pdf->SetFont('helvetica', 'B', 9);
            $pdf->Cell(0, 5, '¡GRACIAS POR SU COMPRA!', 0, 1, 'C');
            $pdf->SetFont('helvetica', 'I', 7);
            $pdf->Cell(0, 3, 'Conserve este ticket como comprobante de su compra', 0, 1, 'C');
            $pdf->Cell(0, 3, 'www.pinateria.com', 0, 1, 'C');
            
            // Línea separadora final
            $pdf->Ln(1);
            $style = array('width' => 0.1, 'dash' => '2,2', 'color' => array(0, 0, 0));
            $pdf->Line(3, $pdf->GetY(), 77, $pdf->GetY(), $style);
            $pdf->Ln(2);
            
            // Logo como marca de software de servicio
            $logoPath = 'assets/images/logo/logo.png';
            if (file_exists($logoPath)) {
                // Mostrar logo pequeño en blanco y negro al final
                $pdf->Image($logoPath, 30, $pdf->GetY(), 20, 0, 'PNG', '', 'T', false, 300, 'C', false, false, 0, false, false, false);
                $pdf->Ln(8);
                $pdf->SetFont('helvetica', '', 6);
                $pdf->Cell(0, 3, 'Software de facturación por Leapcol', 0, 1, 'C');
            }
            
            // Nombre del archivo
            $nombreArchivo = 'Ticket_' . $venta['id'] . '_' . date('YmdHis') . '.pdf';
            
            // Salida del PDF
            $pdf->Output($nombreArchivo, 'I');
            
        } catch (Exception $e) {
            error_log("Error en imprimirTicket: " . $e->getMessage());
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['status' => false, 'msg' => 'Error al generar el ticket: ' . $e->getMessage()], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function facturaDigital($idVenta)
    {
        ob_clean(); // Limpiar buffer de salida
        
        $idVenta = intval($idVenta);
        $venta = $this->model->getVenta($idVenta);
        $detalle = $this->model->getDetalleVenta($idVenta);
        
        if (!$venta || !class_exists('TCPDF')) {
            die('Error: No se puede generar la factura');
        }
        
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(15, 15, 15);
        $pdf->AddPage();
        
        // Título
        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->Cell(0, 10, 'FACTURA ELECTRÓNICA', 0, 1, 'C');
        $pdf->Ln(5);
        
        // Empresa
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(0, 6, NOMBRE_EMPRESA, 0, 1);
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(0, 5, 'NIT: 900.123.456-7', 0, 1);
        $pdf->Cell(0, 5, DIRECCION, 0, 1);
        $pdf->Ln(5);
        
        // Datos factura
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(40, 6, 'Factura N°:', 0, 0);
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(60, 6, $venta['id'], 0, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(30, 6, 'Fecha:', 0, 0);
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(0, 6, date('d/m/Y', strtotime($venta['fecha_venta'])), 0, 1);
        
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(40, 6, 'Cliente:', 0, 0);
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(0, 6, ($venta['cliente_nombre'] ?: 'Cliente General'), 0, 1);
        $pdf->Ln(10);
        
        // Tabla productos
        $pdf->SetFont('helvetica', 'B', 9);
        $pdf->Cell(80, 8, 'PRODUCTO', 1, 0, 'C');
        $pdf->Cell(20, 8, 'CANT', 1, 0, 'C');
        $pdf->Cell(30, 8, 'PRECIO', 1, 0, 'C');
        $pdf->Cell(30, 8, 'TOTAL', 1, 1, 'C');
        
        $pdf->SetFont('helvetica', '', 9);
        foreach($detalle as $item) {
            $precio = $item['precio_unitario'] ?: 0;
            $subtotal = $precio * $item['cantidad'];
            
            $pdf->Cell(80, 6, $item['nombre'], 1, 0);
            $pdf->Cell(20, 6, $item['cantidad'], 1, 0, 'C');
            $pdf->Cell(30, 6, '$' . number_format($precio, 0), 1, 0, 'R');
            $pdf->Cell(30, 6, '$' . number_format($subtotal, 0), 1, 1, 'R');
        }
        
        $pdf->Ln(5);
        
        // Totales
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(130, 6, 'SUBTOTAL:', 0, 0, 'R');
        $pdf->Cell(30, 6, '$' . number_format($venta['subtotal'], 0), 1, 1, 'R');
        
        if($venta['impuestos'] > 0) {
            $pdf->Cell(130, 6, 'IVA:', 0, 0, 'R');
            $pdf->Cell(30, 6, '$' . number_format($venta['impuestos'], 0), 1, 1, 'R');
        }
        
        $pdf->Cell(130, 8, 'TOTAL:', 0, 0, 'R');
        $pdf->Cell(30, 8, '$' . number_format($venta['total'], 0), 1, 1, 'R');
        
        $nombreArchivo = 'factura_' . $venta['id'] . '.pdf';
        $pdf->Output($nombreArchivo, 'D');
        die();
    }
}