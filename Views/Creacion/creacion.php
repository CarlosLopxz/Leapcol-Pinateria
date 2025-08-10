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
            <div class="col-md-4">
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
            <div class="col-md-4">
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
            <div class="col-md-4">
                <div class="card bg-info text-white">
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

        <!-- Inventario -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Inventario de Creación</h5>
            </div>
            <div class="card-body">
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
    var tablaInventario;
    
    document.addEventListener('DOMContentLoaded', function() {
        // Cargar resumen completo
        cargarResumenCompleto();
        
        // Inicializar DataTable
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
    });
    
    function cargarResumen(data) {
        let totalProductos = data ? data.length : 0;
        document.getElementById('totalProductos').textContent = totalProductos;
    }
    
    function cargarResumenCompleto() {
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
    }
</script>