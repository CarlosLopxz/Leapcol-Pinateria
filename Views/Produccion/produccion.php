<?php 
    headerAdmin($data); 
?>

<!-- Main Body-->
<div class="d2c_main px-0 px-md-2 py-4">
    <div class="container-fluid">
        <!-- Title -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-0 text-capitalize">Gestión de Producción</h4>
                <p class="text-muted">Crea productos utilizando recursos del inventario</p>
            </div>
            <div>
                <button class="btn btn-primary" id="btnNuevaProduccion">
                    <i class="fas fa-plus me-2"></i>Nueva Producción
                </button>
            </div>
        </div>

        <!-- Producciones Table -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped" id="tableProducciones" width="100%">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Producto Final</th>
                                <th>Cantidad</th>
                                <th>Fecha</th>
                                <th>Usuario</th>
                                <th>Estado</th>
                                <th>Acciones</th>
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

<!-- Modal para Nueva Producción -->
<div class="modal fade" id="modalProduccion" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Nueva Producción</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formProduccion">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nombre_producto" class="form-label">Nombre del Producto <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nombre_producto" name="nombre_producto" required>
                        </div>
                        <div class="col-md-3">
                            <label for="categoria_producto" class="form-label">Categoría <span class="text-danger">*</span></label>
                            <select class="form-select" id="categoria_producto" name="categoria_producto" required>
                                <option value="">Seleccionar</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="cantidad" class="form-label">Cantidad <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="cantidad" name="cantidad" min="1" required>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="descripcion_producto" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcion_producto" name="descripcion_producto" rows="2"></textarea>
                        </div>
                        <div class="col-md-4">
                            <label for="precio_venta" class="form-label">Precio de Venta <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="precio_venta" name="precio_venta" min="0" step="0.01" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="mano_obra" class="form-label">Mano de Obra</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="mano_obra" name="mano_obra" min="0" step="0.01" value="0">
                            </div>
                            <small class="text-muted">Precio Final: $<span id="precio_total">0</span></small>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Recursos Necesarios <span class="text-danger">*</span></label>
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <select class="form-select" id="recurso_select">
                                    <option value="">Seleccionar recurso</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="number" class="form-control" id="cantidad_recurso" placeholder="Cantidad" min="1">
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="btn btn-success" id="btnAgregarRecurso">
                                    <i class="fas fa-plus"></i> Agregar
                                </button>
                            </div>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-sm" id="tablaRecursos">
                                <thead>
                                    <tr>
                                        <th>Recurso</th>
                                        <th>Cantidad</th>
                                        <th>Stock Disponible</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="observaciones" class="form-label">Observaciones</label>
                        <textarea class="form-control" id="observaciones" name="observaciones" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btnProcesarProduccion">Procesar Producción</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Ver Detalle -->
<div class="modal fade" id="modalDetalle" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Detalle de Producción</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="tablaDetalle">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Recurso</th>
                                <th>Cantidad Utilizada</th>
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

<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    var tableProducciones;
    var productosRecursos = [];
    var recursosSeleccionados = [];
    
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar DataTable
        tableProducciones = $('#tableProducciones').DataTable({
            "language": {"url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"},
            "ajax": {
                "url": "<?= BASE_URL ?>produccion/getProducciones",
                "dataSrc": function(json) { return json || []; }
            },
            "columns": [
                {"data": "codigo"},
                {"data": "producto_final"},
                {"data": "cantidad_producir"},
                {
                    "data": "fecha_produccion",
                    "render": function(data) {
                        return new Date(data).toLocaleDateString('es-CO');
                    }
                },
                {"data": "usuario"},
                {
                    "data": "estado",
                    "render": function(data) {
                        if(data == 1) return '<span class="badge bg-success">Completada</span>';
                        if(data == 2) return '<span class="badge bg-warning">En proceso</span>';
                        return '<span class="badge bg-danger">Cancelada</span>';
                    }
                },
                {
                    "data": "id",
                    "render": function(data) {
                        return `<button class="btn btn-sm btn-info" onclick="verDetalle(${data})">
                                    <i class="fas fa-eye"></i> Ver
                                </button>`;
                    }
                }
            ],
            "order": [[0, "desc"]]
        });
        
        // Cargar categorías y recursos
        cargarCategorias();
        cargarRecursos();
        
        // Eventos
        document.getElementById('btnNuevaProduccion').addEventListener('click', abrirModalProduccion);
        document.getElementById('btnAgregarRecurso').addEventListener('click', agregarRecurso);
        document.getElementById('btnProcesarProduccion').addEventListener('click', procesarProduccion);
        document.getElementById('precio_venta').addEventListener('input', actualizarPrecioTotal);
        document.getElementById('mano_obra').addEventListener('input', actualizarPrecioTotal);
    });
    
    function cargarCategorias() {
        fetch('<?= BASE_URL ?>produccion/getCategorias')
            .then(response => response.json())
            .then(data => {
                const select = document.getElementById('categoria_producto');
                select.innerHTML = '<option value="">Seleccionar</option>';
                data.forEach(categoria => {
                    select.innerHTML += `<option value="${categoria.id}">${categoria.nombre}</option>`;
                });
            });
    }
    
    function cargarRecursos() {
        fetch('<?= BASE_URL ?>produccion/getProductosRecursos')
            .then(response => response.json())
            .then(data => {
                productosRecursos = data;
                const select = document.getElementById('recurso_select');
                select.innerHTML = '<option value="">Seleccionar recurso</option>';
                data.forEach(producto => {
                    select.innerHTML += `<option value="${producto.id}" data-stock="${producto.stock}">${producto.nombre} (Stock: ${producto.stock})</option>`;
                });
            });
    }
    
    function abrirModalProduccion() {
        document.getElementById('formProduccion').reset();
        recursosSeleccionados = [];
        actualizarTablaRecursos();
        const modal = new bootstrap.Modal(document.getElementById('modalProduccion'), {
            backdrop: 'static',
            keyboard: false
        });
        modal.show();
    }
    
    function agregarRecurso() {
        const recursoSelect = document.getElementById('recurso_select');
        const cantidadInput = document.getElementById('cantidad_recurso');
        
        if(!recursoSelect.value || !cantidadInput.value) {
            Swal.fire('Error', 'Seleccione un recurso y especifique la cantidad', 'error');
            return;
        }
        
        const recursoId = recursoSelect.value;
        const cantidad = parseInt(cantidadInput.value);
        
        const recurso = productosRecursos.find(p => p.id == recursoId);
        
        if(!recurso) {
            Swal.fire('Error', 'Recurso no encontrado', 'error');
            return;
        }
        
        if(cantidad > recurso.stock) {
            Swal.fire('Error', 'La cantidad supera el stock disponible', 'error');
            return;
        }
        
        // Verificar si ya existe
        const existeIndex = recursosSeleccionados.findIndex(r => r.id == recursoId);
        if(existeIndex >= 0) {
            recursosSeleccionados[existeIndex].cantidad = cantidad;
        } else {
            recursosSeleccionados.push({
                id: recursoId,
                nombre: recurso.nombre,
                cantidad: cantidad,
                stock: parseInt(recurso.stock)
            });
        }
        
        actualizarTablaRecursos();
        recursoSelect.value = '';
        cantidadInput.value = '';
    }
    
    function actualizarTablaRecursos() {
        const tbody = document.querySelector('#tablaRecursos tbody');
        tbody.innerHTML = '';
        
        recursosSeleccionados.forEach((recurso, index) => {
            const stockClass = recurso.cantidad > recurso.stock ? 'text-danger' : 'text-success';
            tbody.innerHTML += `
                <tr>
                    <td>${recurso.nombre}</td>
                    <td>${recurso.cantidad}</td>
                    <td class="${stockClass}">${recurso.stock}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-danger" onclick="eliminarRecurso(${index})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
        });
    }
    
    function eliminarRecurso(index) {
        recursosSeleccionados.splice(index, 1);
        actualizarTablaRecursos();
    }
    
    function procesarProduccion() {
        const form = document.getElementById('formProduccion');
        if(!form.checkValidity()) {
            form.classList.add('was-validated');
            return;
        }
        
        if(recursosSeleccionados.length === 0) {
            Swal.fire('Error', 'Debe agregar al menos un recurso', 'error');
            return;
        }
        
        const formData = new FormData(form);
        formData.append('recursos', JSON.stringify(recursosSeleccionados));
        
        // Mostrar modal de carga
        const loadingModal = document.getElementById('loadingModal');
        loadingModal.classList.remove('hide');
        loadingModal.classList.add('show');
        
        fetch('<?= BASE_URL ?>produccion/setProduccion', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            // Ocultar modal de carga
            loadingModal.classList.remove('show');
            loadingModal.classList.add('hide');
            
            if(data.status) {
                Swal.fire('Éxito', data.msg, 'success');
                const modal = bootstrap.Modal.getInstance(document.getElementById('modalProduccion'));
                modal.hide();
                tableProducciones.ajax.reload();
            } else {
                Swal.fire('Error', data.msg, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            
            // Ocultar modal de carga
            loadingModal.classList.remove('show');
            loadingModal.classList.add('hide');
            
            Swal.fire('Error', 'Ocurrió un error al procesar la producción', 'error');
        });
    }
    
    function verDetalle(id) {
        // Mostrar modal de carga
        const loadingModal = document.getElementById('loadingModal');
        loadingModal.classList.remove('hide');
        loadingModal.classList.add('show');
        
        fetch(`<?= BASE_URL ?>produccion/getDetalleProduccion/${id}`)
            .then(response => response.json())
            .then(data => {
                const tbody = document.querySelector('#tablaDetalle tbody');
                tbody.innerHTML = '';
                
                data.forEach(item => {
                    tbody.innerHTML += `
                        <tr>
                            <td>${item.codigo}</td>
                            <td>${item.producto_recurso}</td>
                            <td>${item.cantidad_utilizada}</td>
                        </tr>
                    `;
                });
                
                // Ocultar modal de carga
                loadingModal.classList.remove('show');
                loadingModal.classList.add('hide');
                
                const modal = new bootstrap.Modal(document.getElementById('modalDetalle'), {
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
                
                Swal.fire('Error', 'No se pudo cargar el detalle', 'error');
            });
    }
    
    function actualizarPrecioTotal() {
        const precioVenta = parseFloat(document.getElementById('precio_venta').value) || 0;
        const manoObra = parseFloat(document.getElementById('mano_obra').value) || 0;
        const precioTotal = precioVenta + manoObra;
        
        document.getElementById('precio_total').textContent = precioTotal.toLocaleString('es-CO');
    }
</script>