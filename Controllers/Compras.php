<?php
require_once "Libraries/Core/AuthController.php";

// Verificar si Composer está instalado y cargar autoload
if (file_exists('vendor/autoload.php')) {
    require_once 'vendor/autoload.php';
}

class Compras extends AuthController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['page_tag'] = "Compras - " . NOMBRE_EMPRESA;
        $data['page_title'] = "Gestión de Compras";
        $data['page_name'] = "compras";
        $this->views->getView($this, "compras", $data);
    }
    
    public function nueva()
    {
        $data['page_tag'] = "Nueva Compra - " . NOMBRE_EMPRESA;
        $data['page_title'] = "Registrar Nueva Compra";
        $data['page_name'] = "nueva_compra";
        $this->views->getView($this, "nueva", $data);
    }
    
    public function getCompras()
    {
        try {
            // Establecer el encabezado de contenido como JSON
            header('Content-Type: application/json; charset=utf-8');
            
            $arrData = $this->model->getCompras();
            if (empty($arrData)) {
                $arrData = [];
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            error_log("Error en getCompras: " . $e->getMessage());
            echo json_encode([], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function getCompra($idCompra)
    {
        try {
            // Establecer el encabezado de contenido como JSON
            header('Content-Type: application/json; charset=utf-8');
            
            $idCompra = intval($idCompra);
            if($idCompra > 0) {
                $arrData = $this->model->getCompra($idCompra);
                if($arrData) {
                    $arrData['detalle'] = $this->model->getDetalleCompra($idCompra);
                    echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
                } else {
                    echo json_encode(['error' => 'Compra no encontrada'], JSON_UNESCAPED_UNICODE);
                }
            } else {
                echo json_encode(['error' => 'ID de compra inválido'], JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $e) {
            error_log("Error en getCompra: " . $e->getMessage());
            echo json_encode(['error' => 'Error al obtener la compra'], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function getProveedores()
    {
        try {
            // Establecer el encabezado de contenido como JSON
            header('Content-Type: application/json; charset=utf-8');
            
            $arrData = $this->model->getProveedores();
            if (empty($arrData)) {
                $arrData = [];
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            error_log("Error en getProveedores: " . $e->getMessage());
            echo json_encode([], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function getProductos()
    {
        try {
            // Establecer el encabezado de contenido como JSON
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
    
    public function setCompra()
    {
        try {
            // Establecer el encabezado de contenido como JSON
            header('Content-Type: application/json; charset=utf-8');
            
            if($_POST) {
                // Validación de campos obligatorios
                if(empty($_POST['proveedor']) || empty($_POST['fecha_compra']) || 
                   empty($_POST['productos']) || empty($_POST['total'])) {
                    $arrResponse = ['status' => false, 'msg' => 'Todos los campos marcados con * son obligatorios'];
                } else {
                    // Datos de la compra
                    $idCompra = intval($_POST['idCompra']);
                    $proveedor = intval($_POST['proveedor']);
                    $numeroFactura = strClean($_POST['numero_factura']);
                    $fechaCompra = strClean($_POST['fecha_compra']);
                    $subtotal = floatval($_POST['subtotal']);
                    $impuestos = floatval($_POST['impuestos']);
                    $descuentos = floatval($_POST['descuentos']);
                    $total = floatval($_POST['total']);
                    $estado = intval($_POST['estado']);
                    $observaciones = strClean($_POST['observaciones']);
                    $usuario = $_SESSION['userData']['idusuario'];
                    
                    // Productos
                    $productos = json_decode($_POST['productos'], true);
                    
                    if(empty($productos)) {
                        $arrResponse = ['status' => false, 'msg' => 'Debe agregar al menos un producto'];
                    } else {
                        $datos = [
                            'idCompra' => $idCompra,
                            'proveedor' => $proveedor,
                            'numeroFactura' => $numeroFactura,
                            'fechaCompra' => $fechaCompra,
                            'subtotal' => $subtotal,
                            'impuestos' => $impuestos,
                            'descuentos' => $descuentos,
                            'total' => $total,
                            'estado' => $estado,
                            'observaciones' => $observaciones,
                            'usuario' => $usuario,
                            'productos' => $productos
                        ];
                        
                        if($idCompra == 0) {
                            // Nueva compra
                            $result = $this->model->insertCompra($datos);
                            $arrResponse = ['status' => true, 'msg' => 'Compra registrada correctamente', 'idCompra' => $result];
                        } else {
                            // Actualizar compra
                            $result = $this->model->updateCompra($datos);
                            $arrResponse = ['status' => true, 'msg' => 'Compra actualizada correctamente'];
                        }
                    }
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $e) {
            error_log("Error en setCompra: " . $e->getMessage());
            echo json_encode(['status' => false, 'msg' => 'Error al procesar la solicitud'], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function anularCompra()
    {
        try {
            // Establecer el encabezado de contenido como JSON
            header('Content-Type: application/json; charset=utf-8');
            
            if($_POST) {
                $idCompra = intval($_POST['idCompra']);
                if($idCompra > 0) {
                    $result = $this->model->anularCompra($idCompra);
                    if($result) {
                        $arrResponse = ['status' => true, 'msg' => 'Compra anulada correctamente'];
                    } else {
                        $arrResponse = ['status' => false, 'msg' => 'Error al anular la compra'];
                    }
                } else {
                    $arrResponse = ['status' => false, 'msg' => 'ID de compra inválido'];
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $e) {
            error_log("Error en anularCompra: " . $e->getMessage());
            echo json_encode(['status' => false, 'msg' => 'Error al procesar la solicitud'], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function getDashboardData()
    {
        try {
            // Establecer el encabezado de contenido como JSON
            header('Content-Type: application/json; charset=utf-8');
            
            $data = [
                'totalCompras' => $this->model->getTotalCompras(),
                'comprasMes' => $this->model->getComprasPorMes(),
                'ultimasCompras' => $this->model->getUltimasCompras(5),
                'comprasPorProveedor' => $this->model->getComprasPorProveedor(),
                'productosMasComprados' => $this->model->getProductosMasComprados(5)
            ];
            
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            error_log("Error en getDashboardData: " . $e->getMessage());
            echo json_encode(['error' => 'Error al obtener datos del dashboard'], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function generarPDF($idCompra)
    {
        try {
            $idCompra = intval($idCompra);
            if($idCompra <= 0) {
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode(['status' => false, 'msg' => 'ID de compra inválido'], JSON_UNESCAPED_UNICODE);
                die();
            }
            
            // Obtener datos de la compra
            $compra = $this->model->getCompra($idCompra);
            if(!$compra) {
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode(['status' => false, 'msg' => 'Compra no encontrada'], JSON_UNESCAPED_UNICODE);
                die();
            }
            
            // Obtener detalle de la compra
            $detalle = $this->model->getDetalleCompra($idCompra);
            
            // Verificar si TCPDF está disponible
            if (!class_exists('\TCPDF')) {
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode(['status' => false, 'msg' => 'La librería TCPDF no está disponible. Ejecute "composer install" en el servidor.'], JSON_UNESCAPED_UNICODE);
                die();
            }
            
            // Crear nuevo documento PDF
            $pdf = new \TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
            
            // Configurar documento
            $pdf->SetCreator(NOMBRE_EMPRESA);
            $pdf->SetAuthor(NOMBRE_EMPRESA);
            $pdf->SetTitle('Compra #' . $compra['id']);
            $pdf->SetSubject('Factura de Compra');
            
            // Eliminar cabecera y pie de página predeterminados
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(true);
            
            // Establecer márgenes
            $pdf->SetMargins(15, 15, 15);
            
            // Añadir página
            $pdf->AddPage();
            
            // Logo y encabezado
            if(file_exists('assets/images/logo.png')) {
                $pdf->Image('assets/images/logo.png', 15, 15, 30, '', 'PNG');
            }
            
            $pdf->SetFont('helvetica', 'B', 18);
            $pdf->Cell(0, 10, NOMBRE_EMPRESA, 0, 1, 'R');
            
            $pdf->SetFont('helvetica', '', 10);
            $pdf->Cell(0, 5, 'FACTURA DE COMPRA', 0, 1, 'R');
            $pdf->Cell(0, 5, 'Número: ' . ($compra['numero_factura'] ? $compra['numero_factura'] : 'N/A'), 0, 1, 'R');
            $pdf->Cell(0, 5, 'Fecha: ' . $compra['fecha_compra'], 0, 1, 'R');
            
            // Línea separadora
            $pdf->Ln(5);
            $pdf->Cell(0, 0, '', 'T', 1);
            $pdf->Ln(5);
            
            // Información del proveedor y compra
            $pdf->SetFont('helvetica', 'B', 12);
            $pdf->Cell(0, 10, 'Información de la Compra', 0, 1);
            
            $pdf->SetFont('helvetica', 'B', 10);
            $pdf->Cell(30, 6, 'Proveedor:', 0, 0);
            $pdf->SetFont('helvetica', '', 10);
            $pdf->Cell(100, 6, $compra['proveedor_nombre'], 0, 1);
            
            $pdf->SetFont('helvetica', 'B', 10);
            $pdf->Cell(30, 6, 'Estado:', 0, 0);
            $pdf->SetFont('helvetica', '', 10);
            
            $estado = '';
            if($compra['estado'] == 1) {
                $estado = 'Completada';
            } else if($compra['estado'] == 2) {
                $estado = 'Pendiente';
            } else {
                $estado = 'Anulada';
            }
            $pdf->Cell(100, 6, $estado, 0, 1);
            
            $pdf->SetFont('helvetica', 'B', 10);
            $pdf->Cell(30, 6, 'Usuario:', 0, 0);
            $pdf->SetFont('helvetica', '', 10);
            $pdf->Cell(100, 6, $compra['usuario_nombre'], 0, 1);
            
            if(!empty($compra['observaciones'])) {
                $pdf->SetFont('helvetica', 'B', 10);
                $pdf->Cell(30, 6, 'Observaciones:', 0, 0);
                $pdf->SetFont('helvetica', '', 10);
                $pdf->MultiCell(0, 6, $compra['observaciones'], 0, 'L');
            }
            
            $pdf->Ln(5);
            
            // Tabla de productos
            $pdf->SetFont('helvetica', 'B', 12);
            $pdf->Cell(0, 10, 'Detalle de Productos', 0, 1);
            
            // Cabecera de la tabla
            $pdf->SetFillColor(240, 240, 240);
            $pdf->SetFont('helvetica', 'B', 10);
            $pdf->Cell(25, 7, 'Código', 1, 0, 'C', true);
            $pdf->Cell(70, 7, 'Producto', 1, 0, 'C', true);
            $pdf->Cell(25, 7, 'Cantidad', 1, 0, 'C', true);
            $pdf->Cell(30, 7, 'Precio Unit.', 1, 0, 'C', true);
            $pdf->Cell(30, 7, 'Subtotal', 1, 1, 'C', true);
            
            // Contenido de la tabla
            $pdf->SetFont('helvetica', '', 10);
            
            if(!empty($detalle)) {
                foreach($detalle as $producto) {
                    $pdf->Cell(25, 7, $producto['codigo'], 1, 0, 'C');
                    $pdf->Cell(70, 7, $producto['nombre'], 1, 0, 'L');
                    $pdf->Cell(25, 7, $producto['cantidad'], 1, 0, 'C');
                    $pdf->Cell(30, 7, '$' . number_format($producto['precio_unitario'], 2, '.', ','), 1, 0, 'R');
                    $pdf->Cell(30, 7, '$' . number_format($producto['subtotal'], 2, '.', ','), 1, 1, 'R');
                }
            } else {
                $pdf->Cell(180, 7, 'No hay productos en esta compra', 1, 1, 'C');
            }
            
            // Totales
            $pdf->Ln(5);
            $pdf->SetFont('helvetica', 'B', 10);
            $pdf->Cell(145, 7, 'Subtotal:', 0, 0, 'R');
            $pdf->SetFont('helvetica', '', 10);
            $pdf->Cell(35, 7, '$' . number_format($compra['subtotal'], 2, '.', ','), 0, 1, 'R');
            
            $pdf->SetFont('helvetica', 'B', 10);
            $pdf->Cell(145, 7, 'Impuestos:', 0, 0, 'R');
            $pdf->SetFont('helvetica', '', 10);
            $pdf->Cell(35, 7, '$' . number_format($compra['impuestos'], 2, '.', ','), 0, 1, 'R');
            
            $pdf->SetFont('helvetica', 'B', 10);
            $pdf->Cell(145, 7, 'Descuentos:', 0, 0, 'R');
            $pdf->SetFont('helvetica', '', 10);
            $pdf->Cell(35, 7, '$' . number_format($compra['descuentos'], 2, '.', ','), 0, 1, 'R');
            
            $pdf->SetFont('helvetica', 'B', 12);
            $pdf->Cell(145, 10, 'TOTAL:', 0, 0, 'R');
            $pdf->Cell(35, 10, '$' . number_format($compra['total'], 2, '.', ','), 0, 1, 'R');
            
            // Pie de página
            $pdf->SetY(-25);
            $pdf->SetFont('helvetica', 'I', 8);
            $pdf->Cell(0, 10, 'Este documento es un comprobante de compra generado por el sistema.', 0, 1, 'C');
            
            // Nombre del archivo
            $nombreArchivo = 'Compra_' . $compra['id'] . '_' . date('YmdHis') . '.pdf';
            
            // Salida del PDF
            $pdf->Output($nombreArchivo, 'D');
            
        } catch (Exception $e) {
            error_log("Error en generarPDF: " . $e->getMessage());
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['status' => false, 'msg' => 'Error al generar el PDF: ' . $e->getMessage()], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}