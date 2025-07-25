<?php
require_once "Libraries/Core/AuthController.php";

class Reportes extends AuthController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['page_tag'] = "Reportes - " . NOMBRE_EMPRESA;
        $data['page_title'] = "Centro de Reportes";
        $data['page_name'] = "reportes";
        $this->views->getView($this, "reportes", $data);
    }
    
    // Reportes de Ventas
    public function getVentasPorPeriodo()
    {
        try {
            header('Content-Type: application/json; charset=utf-8');
            $fechaInicio = $_GET['fechaInicio'] ?? date('Y-m-01');
            $fechaFin = $_GET['fechaFin'] ?? date('Y-m-t');
            $arrData = $this->model->getVentasPorPeriodo($fechaInicio, $fechaFin);
            echo json_encode($arrData ?: [], JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            error_log("Error en getVentasPorPeriodo: " . $e->getMessage());
            echo json_encode([], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function getProductosMasVendidos()
    {
        try {
            header('Content-Type: application/json; charset=utf-8');
            $limite = $_GET['limite'] ?? 10;
            $arrData = $this->model->getProductosMasVendidos($limite);
            echo json_encode($arrData ?: [], JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            error_log("Error en getProductosMasVendidos: " . $e->getMessage());
            echo json_encode([], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function getVentasPorCategoria()
    {
        try {
            header('Content-Type: application/json; charset=utf-8');
            $fechaInicio = $_GET['fechaInicio'] ?? date('Y-m-01');
            $fechaFin = $_GET['fechaFin'] ?? date('Y-m-t');
            $arrData = $this->model->getVentasPorCategoria($fechaInicio, $fechaFin);
            echo json_encode($arrData ?: [], JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            error_log("Error en getVentasPorCategoria: " . $e->getMessage());
            echo json_encode([], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    // Reportes de Producción
    public function getProduccionesPorPeriodo()
    {
        try {
            header('Content-Type: application/json; charset=utf-8');
            $fechaInicio = $_GET['fechaInicio'] ?? date('Y-m-01');
            $fechaFin = $_GET['fechaFin'] ?? date('Y-m-t');
            $arrData = $this->model->getProduccionesPorPeriodo($fechaInicio, $fechaFin);
            echo json_encode($arrData ?: [], JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            error_log("Error en getProduccionesPorPeriodo: " . $e->getMessage());
            echo json_encode([], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    // Reportes de Inventario
    public function getStockBajo()
    {
        try {
            header('Content-Type: application/json; charset=utf-8');
            $arrData = $this->model->getStockBajo();
            echo json_encode($arrData ?: [], JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            error_log("Error en getStockBajo: " . $e->getMessage());
            echo json_encode([], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    // Generar PDF
    public function generarPDF()
    {
        try {
            ob_clean();
            
            // Cargar TCPDF
            if (file_exists('vendor/autoload.php')) {
                require_once 'vendor/autoload.php';
            }
            
            $tipo = $_GET['tipo'] ?? 'ventas';
            $fechaInicio = $_GET['fechaInicio'] ?? date('Y-m-01');
            $fechaFin = $_GET['fechaFin'] ?? date('Y-m-t');
            
            if (!class_exists('TCPDF')) {
                // Crear reporte simple en HTML
                $this->generarReporteHTML($tipo, $fechaInicio, $fechaFin);
                return;
            }
            
            $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            $pdf->SetMargins(15, 15, 15);
            $pdf->AddPage();
            
            // Título
            $pdf->SetFont('helvetica', 'B', 16);
            $pdf->Cell(0, 10, 'REPORTE DE ' . strtoupper($tipo), 0, 1, 'C');
            $pdf->Ln(5);
            
            // Empresa
            $pdf->SetFont('helvetica', 'B', 12);
            $pdf->Cell(0, 6, NOMBRE_EMPRESA, 0, 1, 'C');
            $pdf->SetFont('helvetica', '', 10);
            $pdf->Cell(0, 5, 'Período: ' . date('d/m/Y', strtotime($fechaInicio)) . ' - ' . date('d/m/Y', strtotime($fechaFin)), 0, 1, 'C');
            $pdf->Ln(10);
            
            // Contenido según tipo
            switch($tipo) {
                case 'ventas':
                    $this->generarReporteVentas($pdf, $fechaInicio, $fechaFin);
                    break;
                case 'productos':
                    $this->generarReporteProductos($pdf);
                    break;
                case 'produccion':
                    $this->generarReporteProduccion($pdf, $fechaInicio, $fechaFin);
                    break;
            }
            
            $nombreArchivo = 'reporte_' . $tipo . '_' . date('Ymd') . '.pdf';
            $pdf->Output($nombreArchivo, 'D');
            die();
            
        } catch (Exception $e) {
            error_log("Error en generarPDF: " . $e->getMessage());
            die('Error al generar PDF');
        }
    }
    
    private function generarReporteVentas($pdf, $fechaInicio, $fechaFin)
    {
        $ventas = $this->model->getVentasPorPeriodo($fechaInicio, $fechaFin);
        
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(30, 8, 'FECHA', 1, 0, 'C');
        $pdf->Cell(60, 8, 'CLIENTE', 1, 0, 'C');
        $pdf->Cell(40, 8, 'TOTAL', 1, 0, 'C');
        $pdf->Cell(50, 8, 'MÉTODO PAGO', 1, 1, 'C');
        
        $pdf->SetFont('helvetica', '', 9);
        $total = 0;
        foreach($ventas as $venta) {
            $pdf->Cell(30, 6, date('d/m/Y', strtotime($venta['fecha_venta'])), 1, 0);
            $pdf->Cell(60, 6, $venta['cliente'] ?: 'Cliente General', 1, 0);
            $pdf->Cell(40, 6, '$' . number_format($venta['total'], 0), 1, 0, 'R');
            $pdf->Cell(50, 6, $this->getMetodoPago($venta['metodo_pago']), 1, 1);
            $total += $venta['total'];
        }
        
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(130, 8, 'TOTAL GENERAL:', 1, 0, 'R');
        $pdf->Cell(50, 8, '$' . number_format($total, 0), 1, 1, 'R');
    }
    
    private function generarReporteProductos($pdf)
    {
        $productos = $this->model->getStockBajo();
        
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(40, 8, 'CÓDIGO', 1, 0, 'C');
        $pdf->Cell(80, 8, 'PRODUCTO', 1, 0, 'C');
        $pdf->Cell(30, 8, 'STOCK', 1, 0, 'C');
        $pdf->Cell(30, 8, 'MÍNIMO', 1, 1, 'C');
        
        $pdf->SetFont('helvetica', '', 9);
        foreach($productos as $producto) {
            $pdf->Cell(40, 6, $producto['codigo'], 1, 0);
            $pdf->Cell(80, 6, $producto['nombre'], 1, 0);
            $pdf->Cell(30, 6, $producto['stock'], 1, 0, 'C');
            $pdf->Cell(30, 6, $producto['stock_minimo'], 1, 1, 'C');
        }
    }
    
    private function generarReporteProduccion($pdf, $fechaInicio, $fechaFin)
    {
        $producciones = $this->model->getProduccionesPorPeriodo($fechaInicio, $fechaFin);
        
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(30, 8, 'CÓDIGO', 1, 0, 'C');
        $pdf->Cell(80, 8, 'PRODUCTO', 1, 0, 'C');
        $pdf->Cell(30, 8, 'CANTIDAD', 1, 0, 'C');
        $pdf->Cell(40, 8, 'FECHA', 1, 1, 'C');
        
        $pdf->SetFont('helvetica', '', 9);
        foreach($producciones as $produccion) {
            $pdf->Cell(30, 6, $produccion['codigo'], 1, 0);
            $pdf->Cell(80, 6, $produccion['producto_final'], 1, 0);
            $pdf->Cell(30, 6, $produccion['cantidad_producir'], 1, 0, 'C');
            $pdf->Cell(40, 6, date('d/m/Y', strtotime($produccion['fecha_produccion'])), 1, 1);
        }
    }
    
    private function getMetodoPago($metodo)
    {
        switch($metodo) {
            case 1: return 'Efectivo';
            case 2: return 'Tarjeta Crédito';
            case 3: return 'Tarjeta Débito';
            case 4: return 'Transferencia';
            default: return 'Otro';
        }
    }
    
    private function generarReporteHTML($tipo, $fechaInicio, $fechaFin)
    {
        header('Content-Type: text/html; charset=utf-8');
        
        echo "<!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <title>Reporte de " . ucfirst($tipo) . "</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                .header { text-align: center; margin-bottom: 30px; }
                table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                th { background-color: #f2f2f2; }
                .total { font-weight: bold; background-color: #e9ecef; }
                @media print { .no-print { display: none; } }
            </style>
        </head>
        <body>
            <div class='header'>
                <h1>REPORTE DE " . strtoupper($tipo) . "</h1>
                <h2>" . NOMBRE_EMPRESA . "</h2>
                <p>Período: " . date('d/m/Y', strtotime($fechaInicio)) . " - " . date('d/m/Y', strtotime($fechaFin)) . "</p>
                <button class='no-print' onclick='window.print()'>Imprimir</button>
            </div>";
        
        switch($tipo) {
            case 'ventas':
                $this->generarTablaVentasHTML($fechaInicio, $fechaFin);
                break;
            case 'productos':
                $this->generarTablaProductosHTML();
                break;
            case 'produccion':
                $this->generarTablaProduccionHTML($fechaInicio, $fechaFin);
                break;
        }
        
        echo "</body></html>";
        die();
    }
    
    private function generarTablaVentasHTML($fechaInicio, $fechaFin)
    {
        $ventas = $this->model->getVentasPorPeriodo($fechaInicio, $fechaFin);
        
        echo "<table>
            <tr>
                <th>Fecha</th>
                <th>Cliente</th>
                <th>Total</th>
                <th>Método Pago</th>
            </tr>";
        
        $total = 0;
        foreach($ventas as $venta) {
            echo "<tr>
                <td>" . date('d/m/Y', strtotime($venta['fecha_venta'])) . "</td>
                <td>" . ($venta['cliente'] ?: 'Cliente General') . "</td>
                <td>$" . number_format($venta['total'], 0) . "</td>
                <td>" . $this->getMetodoPago($venta['metodo_pago']) . "</td>
            </tr>";
            $total += $venta['total'];
        }
        
        echo "<tr class='total'>
            <td colspan='2'>TOTAL GENERAL:</td>
            <td>$" . number_format($total, 0) . "</td>
            <td></td>
        </tr></table>";
    }
    
    private function generarTablaProductosHTML()
    {
        $productos = $this->model->getStockBajo();
        
        echo "<table>
            <tr>
                <th>Código</th>
                <th>Producto</th>
                <th>Stock</th>
                <th>Mínimo</th>
            </tr>";
        
        foreach($productos as $producto) {
            echo "<tr>
                <td>" . $producto['codigo'] . "</td>
                <td>" . $producto['nombre'] . "</td>
                <td>" . $producto['stock'] . "</td>
                <td>" . $producto['stock_minimo'] . "</td>
            </tr>";
        }
        
        echo "</table>";
    }
    
    private function generarTablaProduccionHTML($fechaInicio, $fechaFin)
    {
        $producciones = $this->model->getProduccionesPorPeriodo($fechaInicio, $fechaFin);
        
        echo "<table>
            <tr>
                <th>Código</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Fecha</th>
            </tr>";
        
        foreach($producciones as $produccion) {
            echo "<tr>
                <td>" . $produccion['codigo'] . "</td>
                <td>" . $produccion['producto_final'] . "</td>
                <td>" . $produccion['cantidad_producir'] . "</td>
                <td>" . date('d/m/Y', strtotime($produccion['fecha_produccion'])) . "</td>
            </tr>";
        }
        
        echo "</table>";
    }
    
    private function generarReporteVentasCompleto($fechaInicio, $fechaFin)
    {
        $ventas = $this->model->getVentasPorPeriodo($fechaInicio, $fechaFin);
        $ventasCategoria = $this->model->getVentasPorCategoria($fechaInicio, $fechaFin);
        $productosVendidos = $this->model->getProductosMasVendidos(5);
        
        // Gráficos
        echo "<div class='chart-row'>
            <div class='chart-col'>
                <h3 class='section-title'>📊 Ventas por Categoría</h3>
                <div class='chart-container'>
                    <canvas id='chartCategoria'></canvas>
                </div>
            </div>
            <div class='chart-col'>
                <h3 class='section-title'>📈 Productos Más Vendidos</h3>
                <div class='chart-container'>
                    <canvas id='chartProductos'></canvas>
                </div>
            </div>
        </div>";
        
        // Tabla de ventas
        echo "<h3 class='section-title'>📋 Detalle de Ventas</h3>";
        echo "<table>
            <tr>
                <th>Fecha</th>
                <th>Cliente</th>
                <th>Total</th>
                <th>Método Pago</th>
            </tr>";
        
        $total = 0;
        foreach($ventas as $venta) {
            echo "<tr>
                <td>" . date('d/m/Y', strtotime($venta['fecha_venta'])) . "</td>
                <td>" . ($venta['cliente'] ?: 'Cliente General') . "</td>
                <td>$" . number_format($venta['total'], 0) . "</td>
                <td>" . $this->getMetodoPago($venta['metodo_pago']) . "</td>
            </tr>";
            $total += $venta['total'];
        }
        
        echo "<tr class='total'>
            <td colspan='2'>TOTAL GENERAL:</td>
            <td>$" . number_format($total, 0) . "</td>
            <td></td>
        </tr></table>";
        
        // JavaScript para gráficos
        $this->generarScriptVentas($ventasCategoria, $productosVendidos);
    }
    
    private function generarReporteProductosCompleto()
    {
        $stockBajo = $this->model->getStockBajo();
        $productosVendidos = $this->model->getProductosMasVendidos(10);
        
        // Gráfico de productos más vendidos
        echo "<h3 class='section-title'>📊 Productos Más Vendidos</h3>
        <div class='chart-container'>
            <canvas id='chartProductosVendidos'></canvas>
        </div>";
        
        // Tabla de stock bajo
        echo "<h3 class='section-title'>⚠️ Productos con Stock Bajo</h3>";
        echo "<table>
            <tr>
                <th>Código</th>
                <th>Producto</th>
                <th>Stock Actual</th>
                <th>Stock Mínimo</th>
                <th>Estado</th>
            </tr>";
        
        foreach($stockBajo as $producto) {
            $estado = $producto['stock'] <= 0 ? '🔴 Sin Stock' : '🟡 Stock Bajo';
            echo "<tr>
                <td>" . $producto['codigo'] . "</td>
                <td>" . $producto['nombre'] . "</td>
                <td>" . $producto['stock'] . "</td>
                <td>" . $producto['stock_minimo'] . "</td>
                <td>" . $estado . "</td>
            </tr>";
        }
        
        echo "</table>";
        
        $this->generarScriptProductos($productosVendidos);
    }
    
    private function generarReporteProduccionCompleto($fechaInicio, $fechaFin)
    {
        $producciones = $this->model->getProduccionesPorPeriodo($fechaInicio, $fechaFin);
        $recursosUtilizados = $this->model->getRecursosMasUtilizados(8);
        
        // Gráfico de recursos más utilizados
        echo "<h3 class='section-title'>🔧 Recursos Más Utilizados</h3>
        <div class='chart-container'>
            <canvas id='chartRecursos'></canvas>
        </div>";
        
        // Tabla de producciones
        echo "<h3 class='section-title'>🏭 Detalle de Producciones</h3>";
        echo "<table>
            <tr>
                <th>Código</th>
                <th>Producto Final</th>
                <th>Cantidad</th>
                <th>Fecha</th>
            </tr>";
        
        $totalProducido = 0;
        foreach($producciones as $produccion) {
            echo "<tr>
                <td>" . $produccion['codigo'] . "</td>
                <td>" . $produccion['producto_final'] . "</td>
                <td>" . $produccion['cantidad_producir'] . "</td>
                <td>" . date('d/m/Y', strtotime($produccion['fecha_produccion'])) . "</td>
            </tr>";
            $totalProducido += $produccion['cantidad_producir'];
        }
        
        echo "<tr class='total'>
            <td colspan='2'>TOTAL PRODUCIDO:</td>
            <td>" . $totalProducido . " unidades</td>
            <td></td>
        </tr></table>";
        
        $this->generarScriptProduccion($recursosUtilizados);
    }
    
    private function generarScriptVentas($ventasCategoria, $productosVendidos)
    {
        echo "<script>
        const ctxCategoria = document.getElementById('chartCategoria').getContext('2d');
        new Chart(ctxCategoria, {
            type: 'doughnut',
            data: {
                labels: [" . implode(',', array_map(function($item) { return "'" . $item['categoria'] . "'"; }, $ventasCategoria)) . "],
                datasets: [{
                    data: [" . implode(',', array_map(function($item) { return $item['total']; }, $ventasCategoria)) . "],
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40']
                }]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });
        
        const ctxProductos = document.getElementById('chartProductos').getContext('2d');
        new Chart(ctxProductos, {
            type: 'bar',
            data: {
                labels: [" . implode(',', array_map(function($item) { return "'" . substr($item['nombre'], 0, 15) . "'"; }, $productosVendidos)) . "],
                datasets: [{
                    label: 'Vendidos',
                    data: [" . implode(',', array_map(function($item) { return $item['total_vendido']; }, $productosVendidos)) . "],
                    backgroundColor: '#28a745'
                }]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });
        </script>";
    }
    
    private function generarScriptProductos($productosVendidos)
    {
        echo "<script>
        const ctx = document.getElementById('chartProductosVendidos').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [" . implode(',', array_map(function($item) { return "'" . substr($item['nombre'], 0, 20) . "'"; }, $productosVendidos)) . "],
                datasets: [{
                    label: 'Cantidad Vendida',
                    data: [" . implode(',', array_map(function($item) { return $item['total_vendido']; }, $productosVendidos)) . "],
                    backgroundColor: '#007bff'
                }]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });
        </script>";
    }
    
    private function generarScriptProduccion($recursosUtilizados)
    {
        echo "<script>
        const ctx = document.getElementById('chartRecursos').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: [" . implode(',', array_map(function($item) { return "'" . $item['nombre'] . "'"; }, $recursosUtilizados)) . "],
                datasets: [{
                    data: [" . implode(',', array_map(function($item) { return $item['total_utilizado']; }, $recursosUtilizados)) . "],
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40', '#FF6384', '#36A2EB']
                }]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });
        </script>";
    }
}