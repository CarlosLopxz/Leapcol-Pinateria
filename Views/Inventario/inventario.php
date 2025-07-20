<?php 
    headerAdmin($data); 
?>

<!-- Main Body-->
<div class="d2c_main px-0 px-md-2 py-4">
    <div class="container-fluid">
        <!-- Title -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-0 text-capitalize">Gestión de Inventario</h4>
                <p class="text-muted">Administra los productos del inventario</p>
            </div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalFormProducto">
                <i class="fas fa-plus me-2"></i>Nuevo Producto
            </button>
        </div>

        <!-- Inventario Table -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped" id="tableInventario" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Código</th>
                                <th>Nombre</th>
                                <th>Categoría</th>
                                <th>Stock</th>
                                <th>Precio</th>
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

<!-- Modal para Ver Producto -->
<div class="modal fade" id="modalVerProducto" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Detalles del Producto</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6 class="fw-bold">Información Básica</h6>
                        <p><strong>Código:</strong> <span id="ver-codigo"></span></p>
                        <p><strong>Nombre:</strong> <span id="ver-nombre"></span></p>
                        <p><strong>Descripción:</strong> <span id="ver-descripcion"></span></p>
                        <p><strong>Categoría:</strong> <span id="ver-categoria"></span></p>
                        <p><strong>Subcategoría:</strong> <span id="ver-subcategoria"></span></p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-bold">Detalles</h6>
                        <p><strong>Unidad de Medida:</strong> <span id="ver-unidad-medida"></span></p>
                        <p><strong>Tamaño/Peso:</strong> <span id="ver-tamanio"></span></p>
                        <p><strong>Presentación:</strong> <span id="ver-presentacion"></span></p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6 class="fw-bold">Ubicación</h6>
                        <p><strong>Almacén:</strong> <span id="ver-almacen"></span></p>
                        <p><strong>Ubicación:</strong> <span id="ver-ubicacion"></span></p>
                        <p><strong>Condiciones:</strong> <span id="ver-condiciones"></span></p>
                        <p><strong>Observaciones:</strong> <span id="ver-observaciones"></span></p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-bold">Stock</h6>
                        <p><strong>Stock Actual:</strong> <span id="ver-stock-actual"></span></p>
                        <p><strong>Stock Mínimo:</strong> <span id="ver-stock-minimo"></span></p>
                        <p><strong>Stock Máximo:</strong> <span id="ver-stock-maximo"></span></p>
                        <p><strong>Estado:</strong> <span id="ver-estado"></span></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="fw-bold">Precios</h6>
                        <p><strong>Precio de Compra:</strong> <span id="ver-precio-compra"></span></p>
                        <p><strong>Precio de Venta:</strong> <span id="ver-precio-venta"></span></p>
                        <p><strong>Costos Adicionales:</strong> <span id="ver-costos-adicionales"></span></p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-bold">Fechas</h6>
                        <p><strong>Fecha de Creación:</strong> <span id="ver-fecha-creacion"></span></p>
                        <p><strong>Última Actualización:</strong> <span id="ver-fecha-actualizacion"></span></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="editarProductoDesdeVer()">Editar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Nuevo/Editar Producto -->
<div class="modal fade" id="modalFormProducto" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalTitle">Nuevo Producto</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formProducto" name="formProducto" class="needs-validation" novalidate>
                    <input type="hidden" id="idProducto" name="idProducto" value="">
                    
                    <ul class="nav nav-tabs" id="productTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic" type="button" role="tab" aria-controls="basic" aria-selected="true">Información Básica</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button" role="tab" aria-controls="details" aria-selected="false">Detalles</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="location-tab" data-bs-toggle="tab" data-bs-target="#location" type="button" role="tab" aria-controls="location" aria-selected="false">Ubicación</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="stock-tab" data-bs-toggle="tab" data-bs-target="#stock" type="button" role="tab" aria-controls="stock" aria-selected="false">Stock</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pricing-tab" data-bs-toggle="tab" data-bs-target="#pricing" type="button" role="tab" aria-controls="pricing" aria-selected="false">Precios</button>
                        </li>
                    </ul>
                    
                    <div class="tab-content p-3" id="productTabsContent">
                        <!-- Información Básica -->
                        <div class="tab-pane fade show active" id="basic" role="tabpanel" aria-labelledby="basic-tab">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="codigo" class="form-label">Código/SKU</label>
                                    <input type="text" class="form-control" id="codigo" name="codigo" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="nombre" class="form-label">Nombre del Producto</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="categoria" class="form-label">Categoría</label>
                                    <select class="form-select" id="categoria" name="categoria" required>
                                        <option value="">Seleccionar...</option>
                                        <option value="1">Piñatas</option>
                                        <option value="2">Dulces</option>
                                        <option value="3">Decoración</option>
                                        <option value="4">Accesorios</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="subcategoria" class="form-label">Subcategoría</label>
                                    <select class="form-select" id="subcategoria" name="subcategoria">
                                        <option value="">Seleccionar...</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Detalles de Presentación -->
                        <div class="tab-pane fade" id="details" role="tabpanel" aria-labelledby="details-tab">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="unidad_medida" class="form-label">Unidad de Medida</label>
                                    <select class="form-select" id="unidad_medida" name="unidad_medida">
                                        <option value="unidad">Unidad</option>
                                        <option value="kg">Kilogramo</option>
                                        <option value="g">Gramo</option>
                                        <option value="l">Litro</option>
                                        <option value="ml">Mililitro</option>
                                        <option value="m">Metro</option>
                                        <option value="cm">Centímetro</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="tamanio" class="form-label">Tamaño/Peso</label>
                                    <input type="text" class="form-control" id="tamanio" name="tamanio">
                                </div>
                                <div class="col-md-4">
                                    <label for="presentacion" class="form-label">Presentación</label>
                                    <select class="form-select" id="presentacion" name="presentacion">
                                        <option value="">Seleccionar...</option>
                                        <option value="caja">Caja</option>
                                        <option value="bolsa">Bolsa</option>
                                        <option value="botella">Botella</option>
                                        <option value="paquete">Paquete</option>
                                        <option value="individual">Individual</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Ubicación -->
                        <div class="tab-pane fade" id="location" role="tabpanel" aria-labelledby="location-tab">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="almacen" class="form-label">Almacén</label>
                                    <select class="form-select" id="almacen" name="almacen">
                                        <option value="1">Principal</option>
                                        <option value="2">Bodega</option>
                                        <option value="3">Tienda</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="ubicacion" class="form-label">Ubicación</label>
                                    <input type="text" class="form-control" id="ubicacion" name="ubicacion" placeholder="Ej: A-12-3">
                                </div>
                                <div class="col-md-4">
                                    <label for="condiciones" class="form-label">Condiciones</label>
                                    <input type="text" class="form-control" id="condiciones" name="condiciones" placeholder="Ej: Temperatura ambiente">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="observaciones_ubicacion" class="form-label">Observaciones</label>
                                <textarea class="form-control" id="observaciones_ubicacion" name="observaciones_ubicacion" rows="2"></textarea>
                            </div>
                        </div>
                        
                        <!-- Stock -->
                        <div class="tab-pane fade" id="stock" role="tabpanel" aria-labelledby="stock-tab">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="stock_actual" class="form-label">Stock Actual</label>
                                    <input type="number" class="form-control" id="stock_actual" name="stock_actual" min="0" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="stock_minimo" class="form-label">Stock Mínimo</label>
                                    <input type="number" class="form-control" id="stock_minimo" name="stock_minimo" min="0">
                                </div>
                                <div class="col-md-4">
                                    <label for="stock_maximo" class="form-label">Stock Máximo</label>
                                    <input type="number" class="form-control" id="stock_maximo" name="stock_maximo" min="0">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="estado" class="form-label">Estado</label>
                                <select class="form-select" id="estado" name="estado">
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Precios -->
                        <div class="tab-pane fade" id="pricing" role="tabpanel" aria-labelledby="pricing-tab">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="precio_compra" class="form-label">Precio de Compra</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" class="form-control" id="precio_compra" name="precio_compra" step="0.01" min="0" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="precio_venta" class="form-label">Precio de Venta</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" class="form-control" id="precio_venta" name="precio_venta" step="0.01" min="0" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="costos_adicionales" class="form-label">Costos Adicionales</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" class="form-control" id="costos_adicionales" name="costos_adicionales" step="0.01" min="0">
                                    </div>
                                </div>
                            </div>
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

<?php footerAdmin($data); ?>

<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Variable global para la tabla
    var tableInventario;
    
    // Función para formatear precios en formato colombiano
function formatoPrecioCOP(precio) {
    return '$' + parseFloat(precio).toLocaleString('es-CO', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
}

document.addEventListener('DOMContentLoaded', function() {
        // Cargar subcategorías cuando cambia la categoría
        document.getElementById('categoria').addEventListener('change', function() {
            const categoriaId = this.value;
            const subcategoriaSelect = document.getElementById('subcategoria');
            
            // Limpiar opciones actuales
            subcategoriaSelect.innerHTML = '<option value="">Seleccionar...</option>';
            
            if(categoriaId !== '') {
                // Cargar subcategorías desde el servidor
                fetch(`<?= BASE_URL ?>inventario/getSubcategorias/${categoriaId}`)
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
                        // Añadir opciones al select
                        data.forEach(subcategoria => {
                            const option = document.createElement('option');
                            option.value = subcategoria.id;
                            option.textContent = subcategoria.nombre;
                            subcategoriaSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }
        });
        
        // Inicializar DataTable
        tableInventario = $('#tableInventario').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
            },
            "ajax": {
                "url": "<?= BASE_URL ?>inventario/getProductos",
                "dataSrc": function(json) {
                    // Si hay un error o no hay datos, devolver un array vacío
                    return json || [];
                },
                "error": function(xhr, error, thrown) {
                    console.error('Error en la carga de datos:', error);
                    return [];
                }
            },
            "columns": [
                {"data": "id"},
                {"data": "codigo"},
                {"data": "nombre"},
                {"data": "categoria"},
                {"data": "stock_actual"},
                {
                    "data": "precio_venta",
                    "render": function(data) {
                        return formatoPrecioCOP(data);
                    }
                },
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
                            <button class="btn btn-sm btn-info" onclick="verProducto(${data})" title="Ver detalles">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-primary" onclick="editarProducto(${data})" title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="eliminarProducto(${data})" title="Eliminar">
                                <i class="fas fa-trash"></i>
                            </button>
                        `;
                    }
                }
            ],
            "responsive": true,
            "dom": 'Bfrtip',
            "buttons": [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
        
        // Manejar envío del formulario
        document.getElementById('formProducto').addEventListener('submit', function(e) {
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
            fetch('<?= BASE_URL ?>inventario/setProducto', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                // Verificar si la respuesta es exitosa
                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor: ' + response.status);
                }
                return response.text();
            })
            .then(text => {
                // Intentar parsear el texto como JSON
                try {
                    return JSON.parse(text);
                } catch (e) {
                    console.error('Error al parsear JSON:', e);
                    console.log('Respuesta recibida:', text);
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
                    let modal = bootstrap.Modal.getInstance(document.getElementById('modalFormProducto'));
                    modal.hide();
                    
                    // Recargar tabla
                    tableInventario.ajax.reload();
                    
                    // Resetear formulario
                    document.getElementById('formProducto').reset();
                    document.getElementById('idProducto').value = '';
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
                    text: 'Ocurrió un error al guardar el producto. Por favor, inténtelo de nuevo.'
                });
                
                // Restaurar botón
                btnGuardar.innerHTML = 'Guardar';
                btnGuardar.disabled = false;
            });
        });
    });
    
    // Variable para almacenar el ID del producto actual
    var productoActualId = 0;
    
    // Funciones para ver, editar y eliminar
    function verProducto(id) {
        productoActualId = id;
        
        // Cargar datos del producto desde la base de datos
        fetch(`<?= BASE_URL ?>inventario/getProducto/${id}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor: ' + response.status);
                }
                return response.text();
            })
            .then(text => {
                try {
                    return JSON.parse(text);
                } catch (e) {
                    console.error('Error al parsear JSON:', e);
                    console.log('Respuesta recibida:', text);
                    throw new Error('Error al procesar la respuesta del servidor');
                }
            })
            .then(data => {
                // Llenar el modal con los datos del producto
                document.getElementById('ver-codigo').textContent = data.codigo;
                document.getElementById('ver-nombre').textContent = data.nombre;
                document.getElementById('ver-descripcion').textContent = data.descripcion || '-';
                document.getElementById('ver-categoria').textContent = data.categoria_nombre;
                document.getElementById('ver-subcategoria').textContent = data.subcategoria_nombre || '-';
                document.getElementById('ver-unidad-medida').textContent = data.unidad_medida;
                document.getElementById('ver-tamanio').textContent = data.tamanio || '-';
                document.getElementById('ver-presentacion').textContent = data.presentacion || '-';
                document.getElementById('ver-almacen').textContent = data.almacen_nombre;
                document.getElementById('ver-ubicacion').textContent = data.ubicacion || '-';
                document.getElementById('ver-condiciones').textContent = data.condiciones || '-';
                document.getElementById('ver-observaciones').textContent = data.observaciones || '-';
                document.getElementById('ver-stock-actual').textContent = data.stock_actual;
                document.getElementById('ver-stock-minimo').textContent = data.stock_minimo || '-';
                document.getElementById('ver-stock-maximo').textContent = data.stock_maximo || '-';
                document.getElementById('ver-estado').textContent = data.estado == 1 ? 'Activo' : 'Inactivo';
                document.getElementById('ver-precio-compra').textContent = formatoPrecioCOP(data.precio_compra);
                document.getElementById('ver-precio-venta').textContent = formatoPrecioCOP(data.precio_venta);
                document.getElementById('ver-costos-adicionales').textContent = data.costos_adicionales ? formatoPrecioCOP(data.costos_adicionales) : formatoPrecioCOP(0);
                document.getElementById('ver-fecha-creacion').textContent = data.fecha_creacion;
                document.getElementById('ver-fecha-actualizacion').textContent = data.fecha_actualizacion || '-';
                
                // Mostrar modal
                let modal = new bootstrap.Modal(document.getElementById('modalVerProducto'));
                modal.show();
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo cargar la información del producto. Por favor, inténtelo de nuevo.'
                });
            });
    }
    
    function editarProductoDesdeVer() {
        // Cerrar modal de ver
        let modalVer = bootstrap.Modal.getInstance(document.getElementById('modalVerProducto'));
        modalVer.hide();
        
        // Abrir modal de editar con el ID actual
        setTimeout(() => {
            editarProducto(productoActualId);
        }, 500);
    }
    
    function editarProducto(id) {
        document.getElementById('modalTitle').textContent = 'Editar Producto';
        document.getElementById('idProducto').value = id;
        
        // Cargar datos del producto desde la base de datos
        fetch(`<?= BASE_URL ?>inventario/getProducto/${id}`)
            .then(response => {
                // Verificar si la respuesta es exitosa
                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor: ' + response.status);
                }
                return response.text();
            })
            .then(text => {
                // Intentar parsear el texto como JSON
                try {
                    return JSON.parse(text);
                } catch (e) {
                    console.error('Error al parsear JSON:', e);
                    console.log('Respuesta recibida:', text);
                    throw new Error('Error al procesar la respuesta del servidor');
                }
            })
            .then(data => {
                // Verificar que data no sea null o undefined
                if (!data) {
                    throw new Error('No se recibieron datos del servidor');
                }
                
                // Llenar el formulario con los datos del producto
                document.getElementById('codigo').value = data.codigo;
                document.getElementById('nombre').value = data.nombre;
                document.getElementById('descripcion').value = data.descripcion || '';
                document.getElementById('categoria').value = data.categoria_id;
                
                // Cargar subcategorías de la categoría seleccionada
                const categoriaId = data.categoria_id;
                const subcategoriaId = data.subcategoria_id || '';
                const subcategoriaSelect = document.getElementById('subcategoria');
                
                // Limpiar opciones actuales
                subcategoriaSelect.innerHTML = '<option value="">Seleccionar...</option>';
                
                if(categoriaId !== '') {
                    // Cargar subcategorías desde el servidor
                    fetch(`<?= BASE_URL ?>inventario/getSubcategorias/${categoriaId}`)
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
                            // Añadir opciones al select
                            data.forEach(subcategoria => {
                                const option = document.createElement('option');
                                option.value = subcategoria.id;
                                option.textContent = subcategoria.nombre;
                                subcategoriaSelect.appendChild(option);
                            });
                            
                            // Seleccionar la subcategoría del producto
                            if(subcategoriaId) {
                                subcategoriaSelect.value = subcategoriaId;
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                }
                document.getElementById('unidad_medida').value = data.unidad_medida;
                document.getElementById('tamanio').value = data.tamanio || '';
                document.getElementById('presentacion').value = data.presentacion || '';
                
                // Asegurarse de que almacen_id sea un valor válido
                const almacenId = data.almacen_id ? data.almacen_id : 1;
                document.getElementById('almacen').value = almacenId;
                
                document.getElementById('ubicacion').value = data.ubicacion || '';
                document.getElementById('condiciones').value = data.condiciones || '';
                document.getElementById('observaciones_ubicacion').value = data.observaciones || '';
                document.getElementById('stock_actual').value = data.stock_actual;
                document.getElementById('stock_minimo').value = data.stock_minimo || '';
                document.getElementById('stock_maximo').value = data.stock_maximo || '';
                document.getElementById('precio_compra').value = data.precio_compra;
                document.getElementById('precio_venta').value = data.precio_venta;
                document.getElementById('costos_adicionales').value = data.costos_adicionales || '';
                document.getElementById('estado').value = data.estado;
                
                // Mostrar modal
                let modal = new bootstrap.Modal(document.getElementById('modalFormProducto'));
                modal.show();
            })
            .catch(error => {
                console.error('Error:', error);
                // Mostrar un mensaje de error más amigable
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo cargar la información del producto. Por favor, inténtelo de nuevo.'
                });
            });
    }
    
    function eliminarProducto(id) {
        Swal.fire({
            title: '¿Está seguro?',
            text: "El producto será marcado como inactivo",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Enviar solicitud para eliminar el producto
                const formData = new FormData();
                formData.append('idProducto', id);
                
                fetch('<?= BASE_URL ?>inventario/deleteProducto', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    // Verificar si la respuesta es exitosa
                    if (!response.ok) {
                        throw new Error('Error en la respuesta del servidor: ' + response.status);
                    }
                    return response.text();
                })
                .then(text => {
                    // Intentar parsear el texto como JSON
                    try {
                        return JSON.parse(text);
                    } catch (e) {
                        console.error('Error al parsear JSON:', e);
                        console.log('Respuesta recibida:', text);
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
                        if (typeof tableInventario !== 'undefined' && tableInventario.ajax) {
                            tableInventario.ajax.reload();
                        } else {
                            // Si la tabla no está disponible, recargar la página
                            setTimeout(function() {
                                window.location.reload();
                            }, 1500);
                        }
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