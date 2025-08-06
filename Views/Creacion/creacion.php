<?php headerAdmin($data); ?>

<div class="d2c_main px-0 px-md-2 py-4">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-0">Módulo de Creación</h4>
                <p class="text-muted">Caja e inventario independiente</p>
            </div>
        </div>

        <!-- Cards -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Gastado</h5>
                        <h3 id="totalGastado">$0</h3>
                        <p class="text-muted">Dinero invertido</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Productos</h5>
                        <h3 id="totalProductos">0</h3>
                        <p class="text-muted">En inventario</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Inventario -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Inventario</h5>
                <div class="table-responsive">
                    <table class="table table-striped" id="tableInventario">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php footerAdmin($data); ?>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
    function formatoPrecioCOP(precio) {
        return '$' + parseFloat(precio).toLocaleString('es-CO');
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        cargarCaja();
        
        $('#tableInventario').DataTable({
            "language": {"url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"},
            "ajax": {
                "url": "<?= BASE_URL ?>creacion/getInventarioCreacion",
                "dataSrc": function(json) { return json || []; }
            },
            "columns": [
                {"data": "codigo"},
                {"data": "nombre"},
                {"data": "cantidad"},
                {"data": "precio_venta", "render": function(data) { return formatoPrecioCOP(data); }},
                {"data": null, "render": function(data) { return formatoPrecioCOP(data.cantidad * data.precio_venta); }}
            ]
        });
    });
    
    function cargarCaja() {
        fetch('<?= BASE_URL ?>creacion/getCajaCreacion')
            .then(response => response.json())
            .then(data => {
                if(data) {
                    document.getElementById('totalGastado').textContent = formatoPrecioCOP(data.monto_actual || 0);
                }
            });
        
        fetch('<?= BASE_URL ?>creacion/getInventarioCreacion')
            .then(response => response.json())
            .then(data => {
                document.getElementById('totalProductos').textContent = data.length || 0;
            });
    }
</script>