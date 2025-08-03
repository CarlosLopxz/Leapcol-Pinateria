<?php 
    headerAdmin($data); 
?>

<!-- Main Body-->
<div class="d2c_main px-0 px-md-2 py-4">
    <div class="container-fluid">
        <!-- Title -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-0 text-capitalize">Gestión de Compras</h4>
                <p class="text-muted">Administra las compras a proveedores</p>
            </div>
            <div>
                <a href="<?= BASE_URL ?>compras/nueva" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Nueva Compra
                </a>
            </div>
        </div>

        <!-- Dashboard Cards -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Total Compras</h6>
                                <h4 class="mb-0" id="totalCompras">0</h4>
                            </div>
                            <div class="bg-primary text-white rounded-circle p-3">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Compras del Mes</h6>
                                <h4 class="mb-0" id="comprasMes">$0</h4>
                            </div>
                            <div class="bg-success text-white rounded-circle p-3">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Proveedores</h6>
                                <h4 class="mb-0" id="totalProveedores">0</h4>
                            </div>
                            <div class="bg-info text-white rounded-circle p-3">
                                <i class="fas fa-truck"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Productos Comprados</h6>
                                <h4 class="mb-0" id="totalProductos">0</h4>
                            </div>
                            <div class="bg-warning text-white rounded-circle p-3">
                                <i class="fas fa-box"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row mb-4">
            <div class="col-md-8 mb-3">
                <div class="card h-100">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">Compras por Mes</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="comprasPorMesChart" height="250"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">Compras por Proveedor</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="comprasPorProveedorChart" height="250"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Compras Table -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped" id="tableCompras" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Factura</th>
                                <th>Fecha</th>
                                <th>Proveedor</th>
                                <th>Total</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Los datos se cargarán dinámicamente con DataTables -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End:Main Body -->

<!-- Modal para Ver Compra -->
<div class="modal fade" id="modalVerCompra" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Detalles de la Compra</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6 class="fw-bold">Información de la Compra</h6>
                        <p><strong>ID:</strong> <span id="ver-id"></span></p>
                        <p><strong>Factura:</strong> <span id="ver-factura"></span></p>
                        <p><strong>Fecha:</strong> <span id="ver-fecha"></span></p>
                        <p><strong>Proveedor:</strong> <span id="ver-proveedor"></span></p>
                        <p><strong>Usuario:</strong> <span id="ver-usuario"></span></p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-bold">Totales</h6>
                        <p><strong>Subtotal:</strong> <span id="ver-subtotal"></span></p>
                        <p><strong>Impuestos:</strong> <span id="ver-impuestos"></span></p>
                        <p><strong>Descuentos:</strong> <span id="ver-descuentos"></span></p>
                        <p><strong>Total:</strong> <span id="ver-total"></span></p>
                        <p><strong>Estado:</strong> <span id="ver-estado"></span></p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <h6 class="fw-bold">Observaciones</h6>
                        <p id="ver-observaciones"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <h6 class="fw-bold">Productos</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Precio</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody id="ver-detalle">
                                    <!-- Se cargará dinámicamente -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-info" id="btnDescargarPDF">
                    <i class="fas fa-file-pdf me-1"></i> Descargar PDF
                </button>
                <button type="button" class="btn btn-primary" id="btnEditar">Editar</button>
                <button type="button" class="btn btn-danger" id="btnAnular">Anular</button>
            </div>
        </div>
    </div>
</div>

<?php footerAdmin($data); ?>

<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<!-- DataTables Buttons -->
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Función para formatear precios en formato colombiano
    function formatoPrecioCOP(precio) {
        return '$' + parseFloat(precio).toLocaleString('es-CO', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }
    
    // Variable global para la tabla
    var tableCompras;
    
    // Variable para almacenar el ID de la compra actual
    var compraActualId = 0;
    
    // Variables para los gráficos
    var comprasPorMesChart;
    var comprasPorProveedorChart;
    
    document.addEventListener('DOMContentLoaded', function() {
        // Cargar datos del dashboard
        cargarDatosDashboard();
        
        // Inicializar DataTable
        tableCompras = $('#tableCompras').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
            },
            "ajax": {
                "url": "<?= BASE_URL ?>compras/getCompras",
                "dataSrc": function(json) {
                    return json || [];
                },
                "error": function(xhr, error, thrown) {
                    console.error('Error en la carga de datos:', error);
                    return [];
                }
            },
            "columns": [
                {"data": "id"},
                {"data": "numero_factura"},
                {"data": "fecha_compra"},
                {"data": "proveedor"},
                {
                    "data": "total",
                    "render": function(data) {
                        return formatoPrecioCOP(data);
                    }
                },
                {
                    "data": "estado",
                    "render": function(data) {
                        if(data == 1) {
                            return '<span class="badge bg-success">Completada</span>';
                        } else if(data == 2) {
                            return '<span class="badge bg-warning">Pendiente</span>';
                        } else {
                            return '<span class="badge bg-danger">Anulada</span>';
                        }
                    }
                },
                {
                    "data": "id",
                    "render": function(data, type, row) {
                        let buttons = `
                            <button class="btn btn-sm btn-info" onclick="verCompra(${data})" title="Ver detalles">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-secondary" onclick="descargarCompraPDF(${data})" title="Descargar PDF">
                                <i class="fas fa-file-pdf"></i>
                            </button>`;
                            
                        if(row.estado != 0) {
                            buttons += `
                                <a href="<?= BASE_URL ?>compras/nueva/${data}" class="btn btn-sm btn-primary" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-sm btn-danger" onclick="anularCompra(${data})" title="Anular">
                                    <i class="fas fa-ban"></i>
                                </button>`;
                        }
                        
                        return buttons;
                    }
                }
            ],
            "responsive": true,
            "dom": '<"d-flex justify-content-between align-items-center mb-3"<"d-flex align-items-center"l><"d-flex"B>>rtip',
            "buttons": [
                {
                    extend: 'excel',
                    text: '<i class="fas fa-file-excel me-1"></i> Excel',
                    className: 'btn btn-success',
                    title: 'Compras Piñatería',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    }
                },
                {
                    extend: 'pdf',
                    text: '<i class="fas fa-file-pdf me-1"></i> PDF',
                    className: 'btn btn-danger',
                    title: 'Compras Piñatería',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    }
                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print me-1"></i> Imprimir',
                    className: 'btn btn-info',
                    title: 'Compras Piñatería',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    }
                }
            ]
        });
        
        // Configurar botones del modal
        document.getElementById('btnEditar').addEventListener('click', function() {
            window.location.href = `<?= BASE_URL ?>compras/nueva/${compraActualId}`;
        });
        
        document.getElementById('btnAnular').addEventListener('click', function() {
            anularCompra(compraActualId);
        });
        
        document.getElementById('btnDescargarPDF').addEventListener('click', function() {
            descargarCompraPDF(compraActualId);
        });
    });
    
    function cargarDatosDashboard() {
        fetch('<?= BASE_URL ?>compras/getDashboardData')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor');
                }
                return response.text();
            })
            .then(text => {
                try {
                    return JSON.parse(text);
                } catch (e) {
                    console.error('Error al parsear JSON:', e);
                    return {};
                }
            })
            .then(data => {
                // Verificar si data es un objeto válido
                if (!data || typeof data !== 'object') {
                    console.error('Datos de dashboard inválidos:', data);
                    data = {};
                }
                
                // Actualizar contadores
                document.getElementById('totalCompras').textContent = data.totalCompras || 0;
                
                // Calcular total de compras del mes actual
                const mesActual = new Date().getMonth() + 1;
                const comprasMesActual = data.comprasMes && Array.isArray(data.comprasMes) ? 
                    data.comprasMes.find(item => parseInt(item.mes) === mesActual) : null;
                document.getElementById('comprasMes').textContent = formatoPrecioCOP(comprasMesActual ? comprasMesActual.total : 0);
                
                // Contar proveedores únicos
                const proveedoresUnicos = new Set(
                    data.comprasPorProveedor && Array.isArray(data.comprasPorProveedor) ? 
                    data.comprasPorProveedor.map(item => item.proveedor) : []
                );
                document.getElementById('totalProveedores').textContent = proveedoresUnicos.size;
                
                // Contar productos comprados
                const totalProductos = data.productosMasComprados && Array.isArray(data.productosMasComprados) ? 
                    data.productosMasComprados.reduce((sum, item) => sum + parseInt(item.cantidad), 0) : 0;
                document.getElementById('totalProductos').textContent = totalProductos;
                
                // Crear gráfico de compras por mes
                crearGraficoComprasPorMes(data.comprasPorMes);
                
                // Crear gráfico de compras por proveedor
                crearGraficoComprasPorProveedor(data.comprasPorProveedor);
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
    
    function crearGraficoComprasPorMes(datos) {
        const ctx = document.getElementById('comprasPorMesChart').getContext('2d');
        
        // Definir nombres de meses
        const nombresMeses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        
        // Preparar datos para el gráfico
        const labels = [];
        const values = [];
        
        // Inicializar con ceros para todos los meses
        for (let i = 0; i < 12; i++) {
            labels.push(nombresMeses[i]);
            values.push(0);
        }
        
        // Llenar con datos reales si existen
        if (datos && Array.isArray(datos)) {
            datos.forEach(item => {
                const mes = parseInt(item.mes) - 1; // Ajustar índice (0-11)
                values[mes] = parseFloat(item.total);
            });
        }
        
        // Crear gráfico
        if (comprasPorMesChart) {
            comprasPorMesChart.destroy();
        }
        
        comprasPorMesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total de Compras',
                    data: values,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
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
                                return '$' + value.toLocaleString('es-CO');
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Total: ' + formatoPrecioCOP(context.raw);
                            }
                        }
                    }
                }
            }
        });
    }
    
    function crearGraficoComprasPorProveedor(datos) {
        const ctx = document.getElementById('comprasPorProveedorChart').getContext('2d');
        
        // Verificar si hay datos
        if (!datos || !Array.isArray(datos)) {
            datos = [];
        }
        
        // Limitar a los 5 principales proveedores
        const topProveedores = datos.slice(0, 5);
        
        // Preparar datos para el gráfico
        const labels = topProveedores.map(item => item.proveedor);
        const values = topProveedores.map(item => parseFloat(item.total));
        
        // Colores para el gráfico
        const backgroundColors = [
            'rgba(255, 99, 132, 0.5)',
            'rgba(54, 162, 235, 0.5)',
            'rgba(255, 206, 86, 0.5)',
            'rgba(75, 192, 192, 0.5)',
            'rgba(153, 102, 255, 0.5)'
        ];
        
        const borderColors = [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)'
        ];
        
        // Crear gráfico
        if (comprasPorProveedorChart) {
            comprasPorProveedorChart.destroy();
        }
        
        comprasPorProveedorChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: values,
                    backgroundColor: backgroundColors,
                    borderColor: borderColors,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.label + ': ' + formatoPrecioCOP(context.raw);
                            }
                        }
                    }
                }
            }
        });
    }
    
    function verCompra(id) {
        // Mostrar modal de carga
        const loadingModal = document.getElementById('loadingModal');
        loadingModal.classList.remove('hide');
        loadingModal.classList.add('show');
        
        compraActualId = id;
        
        // Cargar datos de la compra
        fetch(`<?= BASE_URL ?>compras/getCompra/${id}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor');
                }
                return response.text();
            })
            .then(text => {
                try {
                    return JSON.parse(text);
                } catch (e) {
                    console.error('Error al parsear JSON:', e);
                    throw new Error('Error al procesar la respuesta del servidor');
                }
            })
            .then(data => {
                // Llenar datos de la compra
                document.getElementById('ver-id').textContent = data.id;
                document.getElementById('ver-factura').textContent = data.numero_factura || '-';
                document.getElementById('ver-fecha').textContent = data.fecha_compra;
                document.getElementById('ver-proveedor').textContent = data.proveedor_nombre;
                document.getElementById('ver-usuario').textContent = data.usuario_nombre;
                document.getElementById('ver-subtotal').textContent = formatoPrecioCOP(data.subtotal);
                document.getElementById('ver-impuestos').textContent = formatoPrecioCOP(data.impuestos);
                document.getElementById('ver-descuentos').textContent = formatoPrecioCOP(data.descuentos);
                document.getElementById('ver-total').textContent = formatoPrecioCOP(data.total);
                
                // Estado
                let estadoText = '';
                let estadoClass = '';
                if(data.estado == 1) {
                    estadoText = 'Completada';
                    estadoClass = 'bg-success';
                } else if(data.estado == 2) {
                    estadoText = 'Pendiente';
                    estadoClass = 'bg-warning';
                } else {
                    estadoText = 'Anulada';
                    estadoClass = 'bg-danger';
                }
                document.getElementById('ver-estado').innerHTML = `<span class="badge ${estadoClass}">${estadoText}</span>`;
                
                // Observaciones
                document.getElementById('ver-observaciones').textContent = data.observaciones || '-';
                
                // Detalle de productos
                const detalleContainer = document.getElementById('ver-detalle');
                detalleContainer.innerHTML = '';
                
                if(data.detalle && data.detalle.length > 0) {
                    data.detalle.forEach(item => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${item.codigo}</td>
                            <td>${item.nombre}</td>
                            <td>${item.cantidad}</td>
                            <td>${formatoPrecioCOP(item.precio_unitario)}</td>
                            <td>${formatoPrecioCOP(item.subtotal)}</td>
                        `;
                        detalleContainer.appendChild(row);
                    });
                } else {
                    const row = document.createElement('tr');
                    row.innerHTML = '<td colspan="5" class="text-center">No hay productos en esta compra</td>';
                    detalleContainer.appendChild(row);
                }
                
                // Mostrar/ocultar botones según estado
                document.getElementById('btnEditar').style.display = data.estado != 0 ? 'block' : 'none';
                document.getElementById('btnAnular').style.display = data.estado != 0 ? 'block' : 'none';
                
                // Ocultar modal de carga
                loadingModal.classList.remove('show');
                loadingModal.classList.add('hide');
                
                // Mostrar modal
                const modal = new bootstrap.Modal(document.getElementById('modalVerCompra'), {
                    backdrop: 'static',
                    keyboard: false
                });
                modal.show();
            })
            .catch(error => {
                console.error('Error:', error);
                
                // Ocultar modal de carga
                loadingModal.classList.remove('show');
                loadingModal.classList.add('hide');
                
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo cargar la información de la compra'
                });
            });
    }
    
    function anularCompra(id) {
        Swal.fire({
            title: '¿Está seguro?',
            text: "Esta acción anulará la compra y revertirá el stock de los productos",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, anular',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Mostrar modal de carga
                const loadingModal = document.getElementById('loadingModal');
                loadingModal.classList.remove('hide');
                loadingModal.classList.add('show');
                
                const formData = new FormData();
                formData.append('idCompra', id);
                
                fetch('<?= BASE_URL ?>compras/anularCompra', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error en la respuesta del servidor');
                    }
                    return response.text();
                })
                .then(text => {
                    try {
                        return JSON.parse(text);
                    } catch (e) {
                        console.error('Error al parsear JSON:', e);
                        throw new Error('Error al procesar la respuesta del servidor');
                    }
                })
                .then(data => {
                    // Ocultar modal de carga
                    loadingModal.classList.remove('show');
                    loadingModal.classList.add('hide');
                    
                    if(data.status) {
                        Swal.fire(
                            'Anulada',
                            data.msg,
                            'success'
                        );
                        
                        // Cerrar modal si está abierto
                        const modalElement = document.getElementById('modalVerCompra');
                        if(modalElement) {
                            const modal = bootstrap.Modal.getInstance(modalElement);
                            if(modal) {
                                modal.hide();
                            }
                        }
                        
                        // Recargar tabla y datos del dashboard
                        tableCompras.ajax.reload();
                        cargarDatosDashboard();
                    } else {
                        Swal.fire(
                            'Error',
                            data.msg,
                            'error'
                        );
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    
                    // Ocultar modal de carga
                    loadingModal.classList.remove('show');
                    loadingModal.classList.add('hide');
                    
                    Swal.fire(
                        'Error',
                        'Ocurrió un error al procesar la solicitud',
                        'error'
                    );
                });
            }
        });
    }
    
    function descargarCompraPDF(id) {
        // Mostrar modal de carga
        const loadingModal = document.getElementById('loadingModal');
        loadingModal.classList.remove('hide');
        loadingModal.classList.add('show');
        
        // Crear un iframe oculto para la descarga
        const iframe = document.createElement('iframe');
        iframe.style.display = 'none';
        iframe.src = `<?= BASE_URL ?>compras/generarPDF/${id}`;
        document.body.appendChild(iframe);
        
        // Manejar la carga del iframe
        iframe.onload = function() {
            // Ocultar modal de carga
            loadingModal.classList.remove('show');
            loadingModal.classList.add('hide');
            
            // Verificar si hay un error
            try {
                const iframeContent = iframe.contentDocument || iframe.contentWindow.document;
                const errorContent = iframeContent.body.textContent;
                
                // Si hay contenido JSON con error, mostrarlo
                if (errorContent && errorContent.includes('"status":false')) {
                    try {
                        const errorData = JSON.parse(errorContent);
                        Swal.fire('Error', errorData.msg || 'No se pudo generar el PDF', 'error');
                    } catch (e) {
                        // Si no es JSON, probablemente es el PDF descargándose
                    }
                } else {
                    // Éxito - el PDF se está descargando
                    Swal.fire({
                        icon: 'success',
                        title: 'PDF Generado',
                        text: 'El PDF se está descargando',
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            } catch (e) {
                // Error de acceso al iframe - probablemente debido a políticas de seguridad
                // Esto es normal cuando se descarga un archivo
            }
            
            // Eliminar el iframe después de un tiempo
            setTimeout(() => {
                document.body.removeChild(iframe);
            }, 5000);
        };
        
        // Manejar errores
        iframe.onerror = function() {
            // Ocultar modal de carga
            loadingModal.classList.remove('show');
            loadingModal.classList.add('hide');
            
            Swal.fire('Error', 'No se pudo generar el PDF', 'error');
            document.body.removeChild(iframe);
        };
    }
</script>