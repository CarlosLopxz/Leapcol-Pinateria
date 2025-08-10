<?php 
    headerAdmin($data); 
?>

<!-- Main Body-->
<div class="d2c_main px-0 px-md-2 py-4">
    <div class="container-fluid">
        <!-- Title -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-0 text-capitalize">Gestión de Clientes</h4>
                <p class="text-muted">Administra los clientes de la piñatería</p>
            </div>
            <div>
                <a href="#" class="btn btn-success me-2" id="btnExportar">
                    <i class="fas fa-file-excel me-2"></i>Exportar Clientes
                </a>
                <button type="button" class="btn btn-primary" onclick="openModal()">
                    <i class="fas fa-plus me-2"></i>Nuevo Cliente
                </button>
            </div>
        </div>

        <!-- Dashboard Cards -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Total Clientes</h6>
                                <h4 class="mb-0" id="totalClientes">0</h4>
                            </div>
                            <div class="bg-primary text-white rounded-circle p-3">
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
                                <h6 class="text-muted mb-1">Clientes Nuevos (Mes)</h6>
                                <h4 class="mb-0" id="clientesNuevosMes">0</h4>
                            </div>
                            <div class="bg-success text-white rounded-circle p-3">
                                <i class="fas fa-user-plus"></i>
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
                                <h6 class="text-muted mb-1">Ciudad Principal</h6>
                                <h4 class="mb-0" id="ciudadPrincipal">-</h4>
                            </div>
                            <div class="bg-info text-white rounded-circle p-3">
                                <i class="fas fa-map-marker-alt"></i>
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
                                <h6 class="text-muted mb-1">Ventas Totales</h6>
                                <h4 class="mb-0" id="ventasTotales">0</h4>
                            </div>
                            <div class="bg-warning text-white rounded-circle p-3">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row mb-4">
            <div class="col-md-6 mb-3">
                <div class="card h-100">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">Clientes por Ciudad</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="clientesPorCiudadChart" height="250"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card h-100">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">Últimos Clientes Registrados</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Teléfono</th>
                                        <th>Email</th>
                                        <th>Fecha</th>
                                    </tr>
                                </thead>
                                <tbody id="ultimosClientes">
                                    <!-- Se cargará dinámicamente -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Clientes Table -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped" id="tableClientes" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Documento</th>
                                <th>Teléfono</th>
                                <th>Email</th>
                                <th>Ciudad</th>
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

<!-- Modal para Nuevo/Editar Cliente -->
<div class="modal fade" id="modalFormCliente" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalTitle">Nuevo Cliente</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formCliente" name="formCliente" class="needs-validation" novalidate>
                    <input type="hidden" id="idCliente" name="idCliente" value="">
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nombre" class="form-label">Nombre *</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                            <div class="invalid-feedback">
                                El nombre es obligatorio
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="apellido" class="form-label">Apellido *</label>
                            <input type="text" class="form-control" id="apellido" name="apellido" required>
                            <div class="invalid-feedback">
                                El apellido es obligatorio
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="tipo_documento" class="form-label">Tipo de Documento</label>
                            <select class="form-select" id="tipo_documento" name="tipo_documento">
                                <option value="CC">Cédula de Ciudadanía</option>
                                <option value="NIT">NIT</option>
                                <option value="CE">Cédula de Extranjería</option>
                                <option value="PASAPORTE">Pasaporte</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="documento" class="form-label">Número de Documento</label>
                            <input type="text" class="form-control" id="documento" name="documento">
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="telefono" class="form-label">Teléfono *</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" required>
                            <div class="invalid-feedback">
                                El teléfono es obligatorio
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email">
                            <div class="invalid-feedback">
                                Ingrese un email válido
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="direccion" class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="direccion" name="direccion">
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="ciudad" class="form-label">Ciudad</label>
                            <input type="text" class="form-control" id="ciudad" name="ciudad">
                        </div>
                        <div class="col-md-6">
                            <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento">
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="estado" class="form-label">Estado</label>
                            <select class="form-select" id="estado" name="estado">
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" id="btnGuardar">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Ver Cliente -->
<div class="modal fade" id="modalVerCliente" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Detalles del Cliente</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6 class="fw-bold">Información Personal</h6>
                        <p><strong>Nombre:</strong> <span id="ver-nombre"></span></p>
                        <p><strong>Documento:</strong> <span id="ver-documento"></span></p>
                        <p><strong>Teléfono:</strong> <span id="ver-telefono"></span></p>
                        <p><strong>Email:</strong> <span id="ver-email"></span></p>
                        <p><strong>Fecha de Nacimiento:</strong> <span id="ver-fecha-nacimiento"></span></p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-bold">Dirección</h6>
                        <p><strong>Dirección:</strong> <span id="ver-direccion"></span></p>
                        <p><strong>Ciudad:</strong> <span id="ver-ciudad"></span></p>
                        <p><strong>Estado:</strong> <span id="ver-estado"></span></p>
                        <p><strong>Fecha de Registro:</strong> <span id="ver-fecha-registro"></span></p>
                    </div>
                </div>
                
                <ul class="nav nav-tabs" id="clienteTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="compras-tab" data-bs-toggle="tab" data-bs-target="#compras" type="button" role="tab" aria-controls="compras" aria-selected="true">Últimas Compras</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="ventas-tab" data-bs-toggle="tab" data-bs-target="#ventas" type="button" role="tab" aria-controls="ventas" aria-selected="false">Historial de Ventas</button>
                    </li>
                </ul>
                
                <div class="tab-content p-3" id="clienteTabsContent">
                    <div class="tab-pane fade show active" id="compras" role="tabpanel" aria-labelledby="compras-tab">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Factura</th>
                                        <th>Fecha</th>
                                        <th>Proveedor</th>
                                        <th>Total</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody id="tabla-compras">
                                    <!-- Se cargará dinámicamente -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="ventas" role="tabpanel" aria-labelledby="ventas-tab">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Fecha</th>
                                        <th>Total</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody id="tabla-ventas">
                                    <!-- Se cargará dinámicamente -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btnEditar">Editar</button>
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
    var tableClientes;
    
    // Variable para almacenar el ID del cliente actual
    var clienteActualId = 0;
    
    // Variables para los gráficos
    var clientesPorCiudadChart;
    
    document.addEventListener('DOMContentLoaded', function() {
        // Cargar datos del dashboard
        cargarDatosDashboard();
        
        // Inicializar DataTable
        tableClientes = $('#tableClientes').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
            },
            "ajax": {
                "url": "<?= BASE_URL ?>clientes/getClientes",
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
                {"data": "nombre_completo"},
                {"data": "documento"},
                {"data": "telefono"},
                {"data": "email"},
                {"data": "ciudad"},
                {
                    "data": "estado",
                    "render": function(data) {
                        return data == 1 ? 
                            '<span class="badge bg-success">Activo</span>' : 
                            '<span class="badge bg-danger">Inactivo</span>';
                    }
                },
                {
                    "data": "id",
                    "render": function(data, type, row) {
                        // Si es Cliente Chela, solo mostrar botón de ver
                        if(row.nombre_completo && row.nombre_completo.includes('Cliente Chela')) {
                            return `
                                <button class="btn btn-sm btn-info" onclick="verCliente(${data})" title="Ver detalles">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <span class="badge bg-warning">Cliente Sistema</span>
                            `;
                        }
                        
                        return `
                            <button class="btn btn-sm btn-info" onclick="verCliente(${data})" title="Ver detalles">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-primary" onclick="editarCliente(${data})" title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="eliminarCliente(${data})" title="Eliminar">
                                <i class="fas fa-trash"></i>
                            </button>
                        `;
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
                    title: 'Clientes Piñatería',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    }
                },
                {
                    extend: 'pdf',
                    text: '<i class="fas fa-file-pdf me-1"></i> PDF',
                    className: 'btn btn-danger',
                    title: 'Clientes Piñatería',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    }
                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print me-1"></i> Imprimir',
                    className: 'btn btn-info',
                    title: 'Clientes Piñatería',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    }
                }
            ]
        });
        
        // Configurar botón de exportar
        document.getElementById('btnExportar').addEventListener('click', function() {
            tableClientes.button('.buttons-excel').trigger();
        });
        
        // Configurar botón de editar en modal de ver
        document.getElementById('btnEditar').addEventListener('click', function() {
            let modalVer = bootstrap.Modal.getInstance(document.getElementById('modalVerCliente'));
            modalVer.hide();
            
            setTimeout(() => {
                editarCliente(clienteActualId);
            }, 500);
        });
        
        // Manejar envío del formulario
        document.getElementById('formCliente').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validar formulario
            if(!this.checkValidity()) {
                e.stopPropagation();
                this.classList.add('was-validated');
                return;
            }
            
            const btnGuardar = document.getElementById('btnGuardar');
            const formData = new FormData(this);
            
            // Mostrar modal de carga
            const loadingModal = document.getElementById('loadingModal');
            loadingModal.classList.remove('hide');
            loadingModal.classList.add('show');
            
            // Deshabilitar botón y mostrar spinner
            btnGuardar.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Guardando...';
            btnGuardar.disabled = true;
            
            // Enviar datos al servidor
            fetch('<?= BASE_URL ?>clientes/setCliente', {
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
                    // Éxito
                    Swal.fire({
                        icon: 'success',
                        title: 'Bien hecho!',
                        text: data.msg,
                        timer: 2000,
                        showConfirmButton: false
                    });
                    
                    // Cerrar modal
                    let modal = bootstrap.Modal.getInstance(document.getElementById('modalFormCliente'));
                    modal.hide();
                    
                    // Recargar tabla y datos del dashboard
                    tableClientes.ajax.reload();
                    cargarDatosDashboard();
                    
                    // Resetear formulario
                    document.getElementById('formCliente').reset();
                    document.getElementById('idCliente').value = '';
                } else {
                    // Error
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.msg
                    });
                }
                
                // Restaurar botón
                btnGuardar.innerHTML = 'Guardar';
                btnGuardar.disabled = false;
            })
            .catch(error => {
                console.error('Error:', error);
                
                // Ocultar modal de carga
                loadingModal.classList.remove('show');
                loadingModal.classList.add('hide');
                
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ocurrió un error al procesar la solicitud'
                });
                
                // Restaurar botón
                btnGuardar.innerHTML = 'Guardar';
                btnGuardar.disabled = false;
            });
        });
    });
    
    function cargarDatosDashboard() {
        fetch('<?= BASE_URL ?>clientes/getDashboardData')
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
                // Actualizar contadores
                document.getElementById('totalClientes').textContent = data.totalClientes || 0;
                document.getElementById('clientesNuevosMes').textContent = data.clientesNuevosMes || 0;
                document.getElementById('ventasTotales').textContent = 0; // Placeholder
                
                // Ciudad principal
                if(data.clientesPorCiudad && data.clientesPorCiudad.length > 0) {
                    document.getElementById('ciudadPrincipal').textContent = data.clientesPorCiudad[0].ciudad;
                }
                
                // Crear gráfico de clientes por ciudad
                crearGraficoClientesPorCiudad(data.clientesPorCiudad || []);
                
                // Mostrar últimos clientes
                mostrarUltimosClientes(data.ultimosClientes || []);
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
    
    function crearGraficoClientesPorCiudad(datos) {
        const ctx = document.getElementById('clientesPorCiudadChart').getContext('2d');
        
        // Limitar a las 5 principales ciudades
        const topCiudades = datos.slice(0, 5);
        
        // Preparar datos para el gráfico
        const labels = topCiudades.map(item => item.ciudad);
        const values = topCiudades.map(item => parseInt(item.total));
        
        // Colores para el gráfico
        const backgroundColors = [
            'rgba(54, 162, 235, 0.5)',
            'rgba(255, 99, 132, 0.5)',
            'rgba(255, 206, 86, 0.5)',
            'rgba(75, 192, 192, 0.5)',
            'rgba(153, 102, 255, 0.5)'
        ];
        
        const borderColors = [
            'rgba(54, 162, 235, 1)',
            'rgba(255, 99, 132, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)'
        ];
        
        // Crear gráfico
        if (clientesPorCiudadChart) {
            clientesPorCiudadChart.destroy();
        }
        
        clientesPorCiudadChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Número de Clientes',
                    data: values,
                    backgroundColor: backgroundColors,
                    borderColor: borderColors,
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
                            precision: 0
                        }
                    }
                }
            }
        });
    }
    
    function mostrarUltimosClientes(clientes) {
        const tbody = document.getElementById('ultimosClientes');
        tbody.innerHTML = '';
        
        if(clientes.length === 0) {
            const tr = document.createElement('tr');
            tr.innerHTML = '<td colspan="4" class="text-center">No hay clientes registrados</td>';
            tbody.appendChild(tr);
            return;
        }
        
        clientes.forEach(cliente => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${cliente.nombre_completo}</td>
                <td>${cliente.telefono}</td>
                <td>${cliente.email || '-'}</td>
                <td>${new Date(cliente.fecha_creacion).toLocaleDateString()}</td>
            `;
            tbody.appendChild(tr);
        });
    }
    
    function openModal() {
        document.getElementById('modalTitle').textContent = 'Nuevo Cliente';
        document.getElementById('formCliente').reset();
        document.getElementById('idCliente').value = '';
        
        let modal = new bootstrap.Modal(document.getElementById('modalFormCliente'), {
            backdrop: 'static',
            keyboard: false
        });
        modal.show();
    }
    
    function editarCliente(id) {
        // Mostrar modal de carga
        const loadingModal = document.getElementById('loadingModal');
        loadingModal.classList.remove('hide');
        loadingModal.classList.add('show');
        
        document.getElementById('modalTitle').textContent = 'Editar Cliente';
        document.getElementById('idCliente').value = id;
        
        // Cargar datos del cliente
        fetch(`<?= BASE_URL ?>clientes/getCliente/${id}`)
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
                // Llenar formulario
                document.getElementById('nombre').value = data.nombre;
                document.getElementById('apellido').value = data.apellido;
                document.getElementById('tipo_documento').value = data.tipo_documento;
                document.getElementById('documento').value = data.documento || '';
                document.getElementById('telefono').value = data.telefono;
                document.getElementById('email').value = data.email || '';
                document.getElementById('direccion').value = data.direccion || '';
                document.getElementById('ciudad').value = data.ciudad || '';
                document.getElementById('fecha_nacimiento').value = data.fecha_nacimiento || '';
                document.getElementById('estado').value = data.estado;
                
                // Ocultar modal de carga
                loadingModal.classList.remove('show');
                loadingModal.classList.add('hide');
                
                // Mostrar modal
                let modal = new bootstrap.Modal(document.getElementById('modalFormCliente'), {
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
                    text: 'No se pudo cargar la información del cliente'
                });
            });
    }
    
    function verCliente(id) {
        // Mostrar modal de carga
        const loadingModal = document.getElementById('loadingModal');
        loadingModal.classList.remove('hide');
        loadingModal.classList.add('show');
        
        clienteActualId = id;
        
        // Cargar datos del cliente
        fetch(`<?= BASE_URL ?>clientes/getCliente/${id}`)
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
                // Llenar datos del cliente
                document.getElementById('ver-nombre').textContent = `${data.nombre} ${data.apellido}`;
                document.getElementById('ver-documento').textContent = data.documento ? `${data.tipo_documento}: ${data.documento}` : '-';
                document.getElementById('ver-telefono').textContent = data.telefono || '-';
                document.getElementById('ver-email').textContent = data.email || '-';
                document.getElementById('ver-fecha-nacimiento').textContent = data.fecha_nacimiento || '-';
                document.getElementById('ver-direccion').textContent = data.direccion || '-';
                document.getElementById('ver-ciudad').textContent = data.ciudad || '-';
                
                // Estado
                let estadoText = data.estado == 1 ? 'Activo' : 'Inactivo';
                let estadoClass = data.estado == 1 ? 'bg-success' : 'bg-danger';
                document.getElementById('ver-estado').innerHTML = `<span class="badge ${estadoClass}">${estadoText}</span>`;
                
                document.getElementById('ver-fecha-registro').textContent = new Date(data.fecha_creacion).toLocaleDateString();
                
                // Cargar compras
                cargarComprasCliente(id);
                
                // Cargar ventas
                cargarVentasCliente(id);
                
                // Ocultar modal de carga
                loadingModal.classList.remove('show');
                loadingModal.classList.add('hide');
                
                // Mostrar modal
                let modal = new bootstrap.Modal(document.getElementById('modalVerCliente'), {
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
                    text: 'No se pudo cargar la información del cliente'
                });
            });
    }
    
    function cargarComprasCliente(id) {
        fetch(`<?= BASE_URL ?>clientes/getComprasCliente/${id}`)
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
                    return [];
                }
            })
            .then(data => {
                const tbody = document.getElementById('tabla-compras');
                tbody.innerHTML = '';
                
                if(data.length === 0) {
                    const tr = document.createElement('tr');
                    tr.innerHTML = '<td colspan="6" class="text-center">No hay compras registradas</td>';
                    tbody.appendChild(tr);
                    return;
                }
                
                data.forEach(compra => {
                    const tr = document.createElement('tr');
                    
                    // Estado
                    let estadoText = '';
                    let estadoClass = '';
                    if(compra.estado == 1) {
                        estadoText = 'Completada';
                        estadoClass = 'bg-success';
                    } else if(compra.estado == 2) {
                        estadoText = 'Pendiente';
                        estadoClass = 'bg-warning';
                    } else {
                        estadoText = 'Anulada';
                        estadoClass = 'bg-danger';
                    }
                    
                    tr.innerHTML = `
                        <td>${compra.id}</td>
                        <td>${compra.numero_factura || '-'}</td>
                        <td>${compra.fecha_compra}</td>
                        <td>${compra.proveedor}</td>
                        <td>${formatoPrecioCOP(compra.total)}</td>
                        <td><span class="badge ${estadoClass}">${estadoText}</span></td>
                    `;
                    tbody.appendChild(tr);
                });
            })
            .catch(error => {
                console.error('Error:', error);
                const tbody = document.getElementById('tabla-compras');
                tbody.innerHTML = '<tr><td colspan="6" class="text-center">Error al cargar las compras</td></tr>';
            });
    }
    
    function cargarVentasCliente(id) {
        fetch(`<?= BASE_URL ?>clientes/getVentasCliente/${id}`)
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
                    return [];
                }
            })
            .then(data => {
                const tbody = document.getElementById('tabla-ventas');
                tbody.innerHTML = '';
                
                if(data.length === 0) {
                    const tr = document.createElement('tr');
                    tr.innerHTML = '<td colspan="4" class="text-center">No hay ventas registradas</td>';
                    tbody.appendChild(tr);
                    return;
                }
                
                data.forEach(venta => {
                    const tr = document.createElement('tr');
                    
                    // Estado
                    let estadoText = '';
                    let estadoClass = '';
                    if(venta.estado == 1) {
                        estadoText = 'Completada';
                        estadoClass = 'bg-success';
                    } else if(venta.estado == 2) {
                        estadoText = 'Pendiente';
                        estadoClass = 'bg-warning';
                    } else {
                        estadoText = 'Anulada';
                        estadoClass = 'bg-danger';
                    }
                    
                    tr.innerHTML = `
                        <td>${venta.id}</td>
                        <td>${venta.fecha_venta}</td>
                        <td>${formatoPrecioCOP(venta.total)}</td>
                        <td><span class="badge ${estadoClass}">${estadoText}</span></td>
                    `;
                    tbody.appendChild(tr);
                });
            })
            .catch(error => {
                console.error('Error:', error);
                const tbody = document.getElementById('tabla-ventas');
                tbody.innerHTML = '<tr><td colspan="4" class="text-center">Error al cargar las ventas</td></tr>';
            });
    }
    
    function eliminarCliente(id) {
        Swal.fire({
            title: '¿Está seguro?',
            text: "Esta acción eliminará el cliente permanentemente",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                const formData = new FormData();
                formData.append('idCliente', id);
                
                fetch('<?= BASE_URL ?>clientes/deleteCliente', {
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
                            'Eliminado!',
                            data.msg,
                            'success'
                        );
                        
                        // Recargar tabla y datos del dashboard
                        tableClientes.ajax.reload();
                        cargarDatosDashboard();
                    } else {
                        Swal.fire(
                            'Error!',
                            data.msg,
                            'error'
                        );
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire(
                        'Error!',
                        'Ocurrió un error al procesar la solicitud',
                        'error'
                    );
                });
            }
        });
    }
</script>