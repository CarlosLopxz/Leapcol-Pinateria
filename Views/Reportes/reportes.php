<?php 
    headerAdmin($data); 
?>

<!-- Main Body-->
<div class="d2c_main px-0 px-md-2 py-4">
    <div class="container-fluid">
        <!-- Title -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-0 text-capitalize">Centro de Reportes</h4>
                <p class="text-muted">Análisis y reportes del sistema</p>
            </div>
        </div>

        <!-- Filtros -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <label for="fechaInicio" class="form-label">Fecha Inicio</label>
                        <input type="date" class="form-control" id="fechaInicio" value="<?= date('Y-m-01') ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="fechaFin" class="form-label">Fecha Fin</label>
                        <input type="date" class="form-control" id="fechaFin" value="<?= date('Y-m-t') ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="tipoReporte" class="form-label">Tipo de Reporte</label>
                        <select class="form-select" id="tipoReporte">
                            <option value="ventas">Ventas</option>
                            <option value="productos">Productos</option>
                            <option value="produccion">Producción</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button class="btn btn-primary me-2" id="btnActualizar">
                            <i class="fas fa-sync me-2"></i>Actualizar
                        </button>
                        <button class="btn btn-danger" id="btnGenerarPDF">
                            <i class="fas fa-file-pdf me-2"></i>PDF
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs de Reportes -->
        <ul class="nav nav-tabs" id="reportesTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="ventas-tab" data-bs-toggle="tab" data-bs-target="#ventas" type="button">
                    <i class="fas fa-shopping-cart me-2"></i>Ventas
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="productos-tab" data-bs-toggle="tab" data-bs-target="#productos" type="button">
                    <i class="fas fa-box me-2"></i>Productos
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="produccion-tab" data-bs-toggle="tab" data-bs-target="#produccion" type="button">
                    <i class="fas fa-cogs me-2"></i>Producción
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="inventario-tab" data-bs-toggle="tab" data-bs-target="#inventario" type="button">
                    <i class="fas fa-warehouse me-2"></i>Inventario
                </button>
            </li>
        </ul>

        <div class="tab-content" id="reportesTabContent">
            <!-- Tab Ventas -->
            <div class="tab-pane fade show active" id="ventas" role="tabpanel">
                <div class="row mt-4">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Ventas por Día</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="chartVentasDiarias" height="100"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Ventas por Categoría</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="chartVentasCategoria" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="mb-0">Detalle de Ventas</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="tablaVentas">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Cliente</th>
                                        <th>Total</th>
                                        <th>Método Pago</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Productos -->
            <div class="tab-pane fade" id="productos" role="tabpanel">
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Productos Más Vendidos</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="chartProductosVendidos" height="100"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Producción -->
            <div class="tab-pane fade" id="produccion" role="tabpanel">
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Producciones por Período</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="tablaProducciones">
                                        <thead>
                                            <tr>
                                                <th>Código</th>
                                                <th>Producto</th>
                                                <th>Cantidad</th>
                                                <th>Fecha</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Inventario -->
            <div class="tab-pane fade" id="inventario" role="tabpanel">
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Productos con Stock Bajo</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="tablaStockBajo">
                                        <thead>
                                            <tr>
                                                <th>Código</th>
                                                <th>Producto</th>
                                                <th>Stock Actual</th>
                                                <th>Stock Mínimo</th>
                                                <th>Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End:Main Body -->

<?php footerAdmin($data); ?>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    let chartVentasDiarias, chartVentasCategoria, chartProductosVendidos;
    
    document.addEventListener('DOMContentLoaded', function() {
        // Eventos
        document.getElementById('btnActualizar').addEventListener('click', actualizarReportes);
        document.getElementById('btnGenerarPDF').addEventListener('click', generarPDF);
        
        // Cargar reportes iniciales
        actualizarReportes();
    });
    
    function actualizarReportes() {
        const fechaInicio = document.getElementById('fechaInicio').value;
        const fechaFin = document.getElementById('fechaFin').value;
        
        cargarReporteVentas(fechaInicio, fechaFin);
        cargarReporteProductos();
        cargarReporteProduccion(fechaInicio, fechaFin);
        cargarReporteInventario();
    }
    
    function cargarReporteVentas(fechaInicio, fechaFin) {
        // Cargar ventas por período
        fetch(`<?= BASE_URL ?>reportes/getVentasPorPeriodo?fechaInicio=${fechaInicio}&fechaFin=${fechaFin}`)
            .then(response => response.json())
            .then(data => {
                actualizarTablaVentas(data);
                cargarGraficoVentasDiarias(fechaInicio, fechaFin);
            });
        
        // Cargar ventas por categoría
        fetch(`<?= BASE_URL ?>reportes/getVentasPorCategoria?fechaInicio=${fechaInicio}&fechaFin=${fechaFin}`)
            .then(response => response.json())
            .then(data => {
                actualizarGraficoCategoria(data);
            });
    }
    
    function cargarGraficoVentasDiarias(fechaInicio, fechaFin) {
        // Simular datos diarios (implementar endpoint si es necesario)
        const ctx = document.getElementById('chartVentasDiarias').getContext('2d');
        
        if (chartVentasDiarias) {
            chartVentasDiarias.destroy();
        }
        
        chartVentasDiarias = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'],
                datasets: [{
                    label: 'Ventas',
                    data: [12, 19, 3, 5, 2, 3, 9],
                    borderColor: '#007bff',
                    backgroundColor: 'rgba(0, 123, 255, 0.1)',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '$' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    }
    
    function actualizarGraficoCategoria(data) {
        const ctx = document.getElementById('chartVentasCategoria').getContext('2d');
        
        if (chartVentasCategoria) {
            chartVentasCategoria.destroy();
        }
        
        const labels = data.map(item => item.categoria);
        const valores = data.map(item => parseFloat(item.total));
        
        chartVentasCategoria = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: valores,
                    backgroundColor: [
                        '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
                        '#9966FF', '#FF9F40', '#FF6384', '#C9CBCF'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }
    
    function actualizarTablaVentas(data) {
        const tbody = document.querySelector('#tablaVentas tbody');
        tbody.innerHTML = '';
        
        data.forEach(venta => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${new Date(venta.fecha_venta).toLocaleDateString()}</td>
                <td>${venta.cliente}</td>
                <td>$${parseFloat(venta.total).toLocaleString()}</td>
                <td>${getMetodoPago(venta.metodo_pago)}</td>
            `;
            tbody.appendChild(tr);
        });
    }
    
    function cargarReporteProductos() {
        fetch('<?= BASE_URL ?>reportes/getProductosMasVendidos?limite=10')
            .then(response => response.json())
            .then(data => {
                actualizarGraficoProductos(data);
            });
    }
    
    function actualizarGraficoProductos(data) {
        const ctx = document.getElementById('chartProductosVendidos').getContext('2d');
        
        if (chartProductosVendidos) {
            chartProductosVendidos.destroy();
        }
        
        const labels = data.map(item => item.nombre);
        const valores = data.map(item => parseInt(item.total_vendido));
        
        chartProductosVendidos = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Cantidad Vendida',
                    data: valores,
                    backgroundColor: '#28a745',
                    borderColor: '#1e7e34',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }
    
    function cargarReporteProduccion(fechaInicio, fechaFin) {
        fetch(`<?= BASE_URL ?>reportes/getProduccionesPorPeriodo?fechaInicio=${fechaInicio}&fechaFin=${fechaFin}`)
            .then(response => response.json())
            .then(data => {
                actualizarTablaProducciones(data);
            });
    }
    
    function actualizarTablaProducciones(data) {
        const tbody = document.querySelector('#tablaProducciones tbody');
        tbody.innerHTML = '';
        
        data.forEach(produccion => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${produccion.codigo}</td>
                <td>${produccion.producto_final}</td>
                <td>${produccion.cantidad_producir}</td>
                <td>${new Date(produccion.fecha_produccion).toLocaleDateString()}</td>
            `;
            tbody.appendChild(tr);
        });
    }
    
    function cargarReporteInventario() {
        fetch('<?= BASE_URL ?>reportes/getStockBajo')
            .then(response => response.json())
            .then(data => {
                actualizarTablaStockBajo(data);
            });
    }
    
    function actualizarTablaStockBajo(data) {
        const tbody = document.querySelector('#tablaStockBajo tbody');
        tbody.innerHTML = '';
        
        data.forEach(producto => {
            const estado = producto.stock <= 0 ? 'Sin Stock' : 'Stock Bajo';
            const clase = producto.stock <= 0 ? 'danger' : 'warning';
            
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${producto.codigo}</td>
                <td>${producto.nombre}</td>
                <td>${producto.stock}</td>
                <td>${producto.stock_minimo}</td>
                <td><span class="badge bg-${clase}">${estado}</span></td>
            `;
            tbody.appendChild(tr);
        });
    }
    
    function generarPDF() {
        const tipo = document.getElementById('tipoReporte').value;
        const fechaInicio = document.getElementById('fechaInicio').value;
        const fechaFin = document.getElementById('fechaFin').value;
        
        const url = `<?= BASE_URL ?>reportes/generarPDF?tipo=${tipo}&fechaInicio=${fechaInicio}&fechaFin=${fechaFin}`;
        window.open(url, '_blank');
    }
    
    function getMetodoPago(metodo) {
        switch(parseInt(metodo)) {
            case 1: return 'Efectivo';
            case 2: return 'Tarjeta Crédito';
            case 3: return 'Tarjeta Débito';
            case 4: return 'Transferencia';
            default: return 'Otro';
        }
    }
</script>