<?php 
    headerAdmin($data); 
?>

<!-- Main Body-->
<div class="d2c_main px-0 px-md-2 py-4">
    <div class="container-fluid">
        <!-- Title -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-0 text-capitalize">Gestión de Proveedores</h4>
                <p class="text-muted">Administra los proveedores de la piñatería</p>
            </div>
            <div>
                <a href="#" class="btn btn-success me-2" id="btnExportar">
                    <i class="fas fa-file-excel me-2"></i>Exportar Proveedores
                </a>
                <button type="button" class="btn btn-primary" onclick="openModal()">
                    <i class="fas fa-plus me-2"></i>Nuevo Proveedor
                </button>
            </div>
        </div>

        <!-- Proveedores Table -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped" id="tableProveedores" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Contacto</th>
                                <th>Teléfono</th>
                                <th>Email</th>
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

<!-- Modal para Nuevo/Editar Proveedor -->
<div class="modal fade" id="modalFormProveedor" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalTitle">Nuevo Proveedor</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formProveedor" name="formProveedor" class="needs-validation" novalidate>
                    <input type="hidden" id="idProveedor" name="idProveedor" value="">
                    
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre de la Empresa *</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                        <div class="invalid-feedback">
                            El nombre es obligatorio
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="contacto" class="form-label">Persona de Contacto</label>
                        <input type="text" class="form-control" id="contacto" name="contacto">
                    </div>
                    
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono *</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" required>
                        <div class="invalid-feedback">
                            El teléfono es obligatorio
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email">
                        <div class="invalid-feedback">
                            Ingrese un email válido
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <textarea class="form-control" id="direccion" name="direccion" rows="2"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select class="form-select" id="estado" name="estado">
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
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

<!-- Modal para Ver Proveedor -->
<div class="modal fade" id="modalVerProveedor" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Detalles del Proveedor</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6 class="fw-bold">Información de la Empresa</h6>
                        <p><strong>Nombre:</strong> <span id="ver-nombre"></span></p>
                        <p><strong>Contacto:</strong> <span id="ver-contacto"></span></p>
                        <p><strong>Teléfono:</strong> <span id="ver-telefono"></span></p>
                        <p><strong>Email:</strong> <span id="ver-email"></span></p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-bold">Dirección</h6>
                        <p><strong>Dirección:</strong> <span id="ver-direccion"></span></p>
                        <p><strong>Estado:</strong> <span id="ver-estado"></span></p>
                        <p><strong>Fecha de Registro:</strong> <span id="ver-fecha-registro"></span></p>
                    </div>
                </div>
                
                <h6 class="fw-bold">Historial de Compras</h6>
                <div class="table-responsive">
                    <table class="table table-sm table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Factura</th>
                                <th>Fecha</th>
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
    var tableProveedores;
    
    // Variable para almacenar el ID del proveedor actual
    var proveedorActualId = 0;
    
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar DataTable
        tableProveedores = $('#tableProveedores').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
            },
            "ajax": {
                "url": "<?= BASE_URL ?>proveedores/getProveedores",
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
                {"data": "nombre"},
                {"data": "contacto"},
                {"data": "telefono"},
                {"data": "email"},
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
                    "render": function(data) {
                        return `
                            <button class="btn btn-sm btn-info" onclick="verProveedor(${data})" title="Ver detalles">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-primary" onclick="editarProveedor(${data})" title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="eliminarProveedor(${data})" title="Eliminar">
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
                    title: 'Proveedores Piñatería',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    }
                },
                {
                    extend: 'pdf',
                    text: '<i class="fas fa-file-pdf me-1"></i> PDF',
                    className: 'btn btn-danger',
                    title: 'Proveedores Piñatería',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    }
                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print me-1"></i> Imprimir',
                    className: 'btn btn-info',
                    title: 'Proveedores Piñatería',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    }
                }
            ]
        });
        
        // Configurar botón de exportar
        document.getElementById('btnExportar').addEventListener('click', function() {
            tableProveedores.button('.buttons-excel').trigger();
        });
        
        // Configurar botón de editar en modal de ver
        document.getElementById('btnEditar').addEventListener('click', function() {
            let modalVer = bootstrap.Modal.getInstance(document.getElementById('modalVerProveedor'));
            modalVer.hide();
            
            setTimeout(() => {
                editarProveedor(proveedorActualId);
            }, 500);
        });
        
        // Manejar envío del formulario
        document.getElementById('formProveedor').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validar formulario
            if(!this.checkValidity()) {
                e.stopPropagation();
                this.classList.add('was-validated');
                return;
            }
            
            const btnGuardar = document.getElementById('btnGuardar');
            const formData = new FormData(this);
            
            // Deshabilitar botón y mostrar spinner
            btnGuardar.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Guardando...';
            btnGuardar.disabled = true;
            
            // Enviar datos al servidor
            fetch('<?= BASE_URL ?>proveedores/setProveedor', {
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
                    // Éxito
                    Swal.fire({
                        icon: 'success',
                        title: 'Bien hecho!',
                        text: data.msg,
                        timer: 2000,
                        showConfirmButton: false
                    });
                    
                    // Cerrar modal
                    let modal = bootstrap.Modal.getInstance(document.getElementById('modalFormProveedor'));
                    modal.hide();
                    
                    // Recargar tabla
                    tableProveedores.ajax.reload();
                    
                    // Resetear formulario
                    document.getElementById('formProveedor').reset();
                    document.getElementById('idProveedor').value = '';
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
    
    function openModal() {
        document.getElementById('modalTitle').textContent = 'Nuevo Proveedor';
        document.getElementById('formProveedor').reset();
        document.getElementById('idProveedor').value = '';
        
        let modal = new bootstrap.Modal(document.getElementById('modalFormProveedor'), {
            backdrop: 'static',
            keyboard: false
        });
        modal.show();
    }
    
    function editarProveedor(id) {
        // Mostrar modal de carga
        const loadingModal = document.getElementById('loadingModal');
        loadingModal.classList.remove('hide');
        loadingModal.classList.add('show');
        
        document.getElementById('modalTitle').textContent = 'Editar Proveedor';
        document.getElementById('idProveedor').value = id;
        
        // Cargar datos del proveedor
        fetch(`<?= BASE_URL ?>proveedores/getProveedor/${id}`)
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
                
                // Llenar formulario
                document.getElementById('nombre').value = data.nombre;
                document.getElementById('contacto').value = data.contacto || '';
                document.getElementById('telefono').value = data.telefono;
                document.getElementById('email').value = data.email || '';
                document.getElementById('direccion').value = data.direccion || '';
                document.getElementById('estado').value = data.estado;
                
                // Mostrar modal
                let modal = new bootstrap.Modal(document.getElementById('modalFormProveedor'), {
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
                    text: 'No se pudo cargar la información del proveedor'
                });
            });
    }
    
    function verProveedor(id) {
        // Mostrar modal de carga
        const loadingModal = document.getElementById('loadingModal');
        loadingModal.classList.remove('hide');
        loadingModal.classList.add('show');
        
        proveedorActualId = id;
        
        // Cargar datos del proveedor
        fetch(`<?= BASE_URL ?>proveedores/getProveedor/${id}`)
            .then(response => response.json())
            .then(data => {
                // Llenar datos del proveedor
                document.getElementById('ver-nombre').textContent = data.nombre;
                document.getElementById('ver-contacto').textContent = data.contacto || '-';
                document.getElementById('ver-telefono').textContent = data.telefono || '-';
                document.getElementById('ver-email').textContent = data.email || '-';
                document.getElementById('ver-direccion').textContent = data.direccion || '-';
                
                // Estado
                let estadoText = data.estado == 1 ? 'Activo' : 'Inactivo';
                let estadoClass = data.estado == 1 ? 'bg-success' : 'bg-danger';
                document.getElementById('ver-estado').innerHTML = `<span class="badge ${estadoClass}">${estadoText}</span>`;
                
                document.getElementById('ver-fecha-registro').textContent = new Date(data.fecha_creacion).toLocaleDateString();
                
                // Cargar compras
                cargarComprasProveedor(id);
                
                // Ocultar modal de carga
                loadingModal.classList.remove('show');
                loadingModal.classList.add('hide');
                
                // Mostrar modal
                let modal = new bootstrap.Modal(document.getElementById('modalVerProveedor'), {
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
                    text: 'No se pudo cargar la información del proveedor'
                });
            });
    }
    
    function cargarComprasProveedor(id) {
        fetch(`<?= BASE_URL ?>proveedores/getComprasProveedor/${id}`)
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
                    tr.innerHTML = '<td colspan="5" class="text-center">No hay compras registradas</td>';
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
                        <td>${formatoPrecioCOP(compra.total)}</td>
                        <td><span class="badge ${estadoClass}">${estadoText}</span></td>
                    `;
                    tbody.appendChild(tr);
                });
            })
            .catch(error => {
                console.error('Error:', error);
                const tbody = document.getElementById('tabla-compras');
                tbody.innerHTML = '<tr><td colspan="5" class="text-center">Error al cargar las compras</td></tr>';
            });
    }
    
    function eliminarProveedor(id) {
        Swal.fire({
            title: '¿Está seguro?',
            text: "Esta acción eliminará el proveedor permanentemente",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                const formData = new FormData();
                formData.append('idProveedor', id);
                
                fetch('<?= BASE_URL ?>proveedores/deleteProveedor', {
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
                        
                        // Recargar tabla
                        tableProveedores.ajax.reload();
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