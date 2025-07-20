<?php 
    headerAdmin($data); 
?>

<!-- Main Body-->
<div class="d2c_main px-0 px-md-2 py-4">
    <div class="container-fluid">
        <!-- Title -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-0 text-capitalize">Gestión de Ventas</h4>
                <p class="text-muted">Administra las ventas a clientes</p>
            </div>
            <div>
                <a href="<?= BASE_URL ?>ventas/pos" class="btn btn-primary">
                    <i class="fas fa-cash-register me-2"></i>Punto de Venta
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
                                <h6 class="text-muted mb-1">Total Ventas</h6>
                                <h4 class="mb-0" id="totalVentas">0</h4>
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
                                <h6 class="text-muted mb-1">Ventas del Mes</h6>
                                <h4 class="mb-0" id="ventasMes">$0</h4>
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
                                <h6 class="text-muted mb-1">Clientes</h6>
                                <h4 class="mb-0" id="totalClientes">0</h4>
                            </div>
                            <div class="bg-info text-white rounded-circle p-3">
                                <i class="fas fa-users"></i>
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
                                <h6 class="text-muted mb-1">Productos Vendidos</h6>
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

        <!-- Ventas Table -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped" id="tableVentas" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Fecha</th>
                                <th>Cliente</th>
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

<!-- Modal para Ver Venta -->
<div class="modal fade" id="modalVerVenta" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Detalles de la Venta</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6 class="fw-bold">Información de la Venta</h6>
                        <p><strong>ID:</strong> <span id="ver-id"></span></p>
                        <p><strong>Fecha:</strong> <span id="ver-fecha"></span></p>
                        <p><strong>Cliente:</strong> <span id="ver-cliente"></span></p>
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
                <button type="button" class="btn btn-info" id="btnImprimirTicket">
                    <i class="fas fa-print me-1"></i> Imprimir Ticket
                </button>
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

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Función para formatear precios en formato colombiano
    function formatoPrecioCOP(precio) {
        return '$' + parseFloat(precio).toLocaleString('es-CO', {
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        });
    }
    
    // Variable global para la tabla
    var tableVentas;
    
    // Variable para almacenar el ID de la venta actual
    var ventaActualId = 0;
    
    document.addEventListener('DOMContentLoaded', function() {
        // Cargar estadísticas para el dashboard
        cargarEstadisticas();
        
        // Inicializar DataTable
        tableVentas = $('#tableVentas').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
            },
            "ajax": {
                "url": "<?= BASE_URL ?>ventas/getVentas",
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
                {"data": "fecha_venta"},
                {"data": "cliente"},
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
                        } else {
                            return '<span class="badge bg-danger">Anulada</span>';
                        }
                    }
                },
                {
                    "data": "id",
                    "render": function(data, type, row) {
                        let buttons = `
                            <button class="btn btn-sm btn-info" onclick="verVenta(${data})" title="Ver detalles">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-secondary" onclick="imprimirTicket(${data})" title="Imprimir Ticket">
                                <i class="fas fa-print"></i>
                            </button>`;
                            
                        if(row.estado == 1) {
                            buttons += `
                                <button class="btn btn-sm btn-danger" onclick="anularVenta(${data})" title="Anular">
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
                    title: 'Ventas Piñatería',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    }
                },
                {
                    extend: 'pdf',
                    text: '<i class="fas fa-file-pdf me-1"></i> PDF',
                    className: 'btn btn-danger',
                    title: 'Ventas Piñatería',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    }
                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print me-1"></i> Imprimir',
                    className: 'btn btn-info',
                    title: 'Ventas Piñatería',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    }
                }
            ]
        });
        
        // Configurar botones del modal
        document.getElementById('btnImprimirTicket').addEventListener('click', function() {
            imprimirTicket(ventaActualId);
        });
        
        document.getElementById('btnAnular').addEventListener('click', function() {
            anularVenta(ventaActualId);
        });
    });
    
    function verVenta(id) {
        ventaActualId = id;
        
        // Cargar datos de la venta
        fetch(`<?= BASE_URL ?>ventas/getVenta/${id}`)
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
                // Llenar datos de la venta
                document.getElementById('ver-id').textContent = data.id;
                document.getElementById('ver-fecha').textContent = data.fecha_venta;
                document.getElementById('ver-cliente').textContent = data.cliente_nombre;
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
                    row.innerHTML = '<td colspan="5" class="text-center">No hay productos en esta venta</td>';
                    detalleContainer.appendChild(row);
                }
                
                // Mostrar/ocultar botones según estado
                document.getElementById('btnAnular').style.display = data.estado == 1 ? 'block' : 'none';
                
                // Mostrar modal
                const modal = new bootstrap.Modal(document.getElementById('modalVerVenta'));
                modal.show();
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo cargar la información de la venta'
                });
            });
    }
    
    function imprimirTicket(id) {
        // Abrir en una nueva ventana
        window.open(`<?= BASE_URL ?>ventas/imprimirTicket/${id}`, '_blank');
    }
    
    function cargarEstadisticas() {
        // Cargar total de ventas
        fetch('<?= BASE_URL ?>dashboard/getTotalVentas')
            .then(response => response.json())
            .then(data => {
                document.getElementById('totalVentas').textContent = data.total || 0;
            })
            .catch(error => {
                console.error('Error al cargar total de ventas:', error);
            });
        
        // Cargar ventas del mes
        fetch('<?= BASE_URL ?>dashboard/getVentasMes')
            .then(response => response.json())
            .then(data => {
                document.getElementById('ventasMes').textContent = formatoPrecioCOP(data.total || 0);
            })
            .catch(error => {
                console.error('Error al cargar ventas del mes:', error);
            });
        
        // Cargar total de clientes
        fetch('<?= BASE_URL ?>dashboard/getTotalClientes')
            .then(response => response.json())
            .then(data => {
                document.getElementById('totalClientes').textContent = data.total || 0;
            })
            .catch(error => {
                console.error('Error al cargar total de clientes:', error);
            });
        
        // Cargar total de productos vendidos
        fetch('<?= BASE_URL ?>dashboard/getTotalProductosVendidos')
            .then(response => response.json())
            .then(data => {
                document.getElementById('totalProductos').textContent = data.total || 0;
            })
            .catch(error => {
                console.error('Error al cargar total de productos vendidos:', error);
            });
    }
    
    function anularVenta(id) {
        Swal.fire({
            title: '¿Está seguro?',
            text: "Esta acción anulará la venta y devolverá los productos al inventario",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, anular',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                const formData = new FormData();
                formData.append('idVenta', id);
                
                fetch('<?= BASE_URL ?>ventas/anularVenta', {
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
                    if(data.status) {
                        Swal.fire(
                            'Anulada',
                            data.msg,
                            'success'
                        );
                        
                        // Cerrar modal si está abierto
                        const modalElement = document.getElementById('modalVerVenta');
                        if(modalElement) {
                            const modal = bootstrap.Modal.getInstance(modalElement);
                            if(modal) {
                                modal.hide();
                            }
                        }
                        
                        // Recargar tabla
                        tableVentas.ajax.reload();
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
                    Swal.fire(
                        'Error',
                        'Ocurrió un error al procesar la solicitud',
                        'error'
                    );
                });
            }
        });
    }
</script>