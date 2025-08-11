<?php 
    headerAdmin($data); 
?>

<!-- Main Body-->
<div class="d2c_main px-0 px-md-2 py-4">
    <div class="container-fluid">
        <!-- Title -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-0 text-capitalize">Módulo de Creación</h4>
                <p class="text-muted">Inventario de productos comprados para creaciones</p>
            </div>
        </div>

        <!-- Resumen Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title">Total Gastado</h6>
                                <h4 id="totalGastado">$0</h4>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-shopping-cart fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title">Total Vendido</h6>
                                <h4 id="totalVendido">$0</h4>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-dollar-sign fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title">Gastado Hoy</h6>
                                <h4 id="gastadoHoy">$0</h4>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-calendar-day fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title">Vendido Hoy</h6>
                                <h4 id="vendidoHoy">$0</h4>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-chart-line fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Segunda fila de cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-secondary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title">Productos en Stock</h6>
                                <h4 id="totalProductos">0</h4>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-box fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs" id="creacionTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="inventario-tab" data-bs-toggle="tab" data-bs-target="#inventario" type="button" role="tab">
                            <i class="fas fa-box"></i> Inventario
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="movimientos-tab" data-bs-toggle="tab" data-bs-target="#movimientos" type="button" role="tab">
                            <i class="fas fa-exchange-alt"></i> Movimientos
                        </button>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="creacionTabsContent">
                    <!-- Tab Inventario -->
                    <div class="tab-pane fade show active" id="inventario" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped" id="tablaInventario" width="100%">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Producto</th>
                                        <th>Categoría</th>
                                        <th>Stock</th>
                                        <th>Costo Promedio</th>
                                        <th>Valor Total</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Tab Movimientos -->
                    <div class="tab-pane fade" id="movimientos" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped" id="tablaMovimientos" width="100%">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Tipo</th>
                                        <th>Concepto</th>
                                        <th>Monto</th>
                                        <th>Venta #</th>
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
<!-- End:Main Body -->



<?php footerAdmin($data); ?>

<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    var tablaInventario, tablaMovimientos;
    
    document.addEventListener('DOMContentLoaded', function() {
        // Cargar resumen completo
        cargarResumenCompleto();
        
        // Inicializar DataTable Inventario
        tablaInventario = $('#tablaInventario').DataTable({
            "language": {"url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"},
            "ajax": {
                "url": "<?= BASE_URL ?>creacion/getInventarioCreacion",
                "dataSrc": function(json) { 
                    cargarResumen(json);
                    return json || []; 
                }
            },
            "columns": [
                {"data": "codigo"},
                {"data": "nombre"},
                {"data": "categoria"},
                {"data": "stock_creacion"},
                {
                    "data": "costo_promedio",
                    "render": function(data) {
                        return '$' + parseFloat(data).toLocaleString('es-CO');
                    }
                },
                {
                    "data": null,
                    "render": function(data) {
                        const valor = data.stock_creacion * data.costo_promedio;
                        return '$' + valor.toLocaleString('es-CO');
                    }
                }
            ]
        });
        
        // Inicializar DataTable Movimientos
        tablaMovimientos = $('#tablaMovimientos').DataTable({
            "language": {"url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"},
            "ajax": {
                "url": "<?= BASE_URL ?>creacion/getMovimientosCaja",
                "dataSrc": function(json) { 
                    return json || []; 
                }
            },
            "order": [[0, "desc"]],
            "columns": [
                {
                    "data": "fecha",
                    "render": function(data) {
                        return new Date(data).toLocaleString('es-CO');
                    }
                },
                {
                    "data": "tipo",
                    "render": function(data) {
                        const badges = {
                            'gasto': '<span class="badge bg-danger">Gasto</span>',
                            'venta': '<span class="badge bg-success">Venta</span>',
                            'ingreso': '<span class="badge bg-info">Ingreso</span>',
                            'egreso': '<span class="badge bg-warning">Egreso</span>'
                        };
                        return badges[data] || data;
                    }
                },
                {"data": "concepto"},
                {
                    "data": "monto",
                    "render": function(data) {
                        return '$' + parseFloat(data).toLocaleString('es-CO');
                    }
                },
                {
                    "data": "venta_id",
                    "render": function(data) {
                        return data ? '#' + data : '-';
                    }
                }
            ]
        });
        
        // Recargar tabla de movimientos cuando se cambie de tab
        document.getElementById('movimientos-tab').addEventListener('shown.bs.tab', function() {
            tablaMovimientos.ajax.reload();
        });
    });
    
    function cargarResumen(data) {
        let totalProductos = data ? data.length : 0;
        document.getElementById('totalProductos').textContent = totalProductos;
    }
    
    function cargarResumenCompleto() {
        // Cargar totales generales
        fetch('<?= BASE_URL ?>creacion/getResumen')
            .then(response => response.json())
            .then(data => {
                if(data) {
                    document.getElementById('totalGastado').textContent = '$' + parseFloat(data.total_gastos || 0).toLocaleString('es-CO');
                    document.getElementById('totalVendido').textContent = '$' + parseFloat(data.total_ventas || 0).toLocaleString('es-CO');
                }
            })
            .catch(error => {
                console.error('Error al cargar resumen:', error);
            });
            
        // Cargar totales diarios
        fetch('<?= BASE_URL ?>creacion/getResumenDiario')
            .then(response => response.json())
            .then(data => {
                if(data) {
                    document.getElementById('gastadoHoy').textContent = '$' + parseFloat(data.gastos_diarios || 0).toLocaleString('es-CO');
                    document.getElementById('vendidoHoy').textContent = '$' + parseFloat(data.ventas_diarias || 0).toLocaleString('es-CO');
                }
            })
            .catch(error => {
                console.error('Error al cargar resumen diario:', error);
            });
    }
</script>