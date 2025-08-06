<?php 
    headerAdmin($data); 
?>

<!-- Main Body-->
<div class="d2c_main px-0 px-md-2 py-4">
    <div class="container-fluid">
        <!-- Title -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-0 text-capitalize">Gestión de Productos</h4>
                <p class="text-muted">Administra los productos del inventario</p>
            </div>
            <div>
                <button class="btn btn-primary" id="btnNuevoProducto">
                    <i class="fas fa-plus me-2"></i>Nuevo Producto
                </button>
            </div>
        </div>

        <!-- Productos Table -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped" id="tableProductos" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Código</th>
                                <th>Nombre</th>
                                <th>Categoría</th>
                                <th>Precio Total</th>
                                <th>Mano de Obra</th>
                                <th>Stock</th>
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

<!-- Modal para Producto -->
<div class="modal fade" id="modalProducto" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="tituloModal">Nuevo Producto</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formProducto" name="formProducto" class="needs-validation" novalidate>
                    <input type="hidden" id="idProducto" name="idProducto" value="">
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="codigo" class="form-label">Código <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="codigo" name="codigo" required>
                            <div class="invalid-feedback">
                                El código es obligatorio
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="categoria" class="form-label">Categoría <span class="text-danger">*</span></label>
                            <select class="form-select" id="categoria" name="categoria" required>
                                <option value="">Seleccionar</option>
                                <!-- Se cargarán dinámicamente -->
                            </select>
                            <div class="invalid-feedback">
                                La categoría es obligatoria
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                        <div class="invalid-feedback">
                            El nombre es obligatorio
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="precio_compra" class="form-label">Precio de Compra <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="precio_compra" name="precio_compra" min="0" required>
                            </div>
                            <div class="invalid-feedback">
                                El precio de compra es obligatorio
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="precio_venta" class="form-label">Precio de Venta <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="precio_venta" name="precio_venta" min="0" required>
                            </div>
                            <div class="invalid-feedback">
                                El precio de venta es obligatorio
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="stock" class="form-label">Stock</label>
                            <input type="number" class="form-control" id="stock" name="stock" min="0" value="0">
                        </div>
                        <div class="col-md-6">
                            <label for="stock_minimo" class="form-label">Stock Mínimo</label>
                            <input type="number" class="form-control" id="stock_minimo" name="stock_minimo" min="0" value="5">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="imagen" class="form-label">Imagen</label>
                        <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
                        <div id="imagenPreview" class="mt-2"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select class="form-select" id="estado" name="estado">
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btnGuardar">Guardar</button>
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
    // Función para formatear precios en formato colombiano
    function formatoPrecioCOP(precio) {
        return '$' + parseFloat(precio).toLocaleString('es-CO', {
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        });
    }
    
    // Variable global para la tabla
    var tableProductos;
    
    document.addEventListener('DOMContentLoaded', function() {
        // Cargar categorías
        cargarCategorias();
        
        // Inicializar DataTable
        tableProductos = $('#tableProductos').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
            },
            "ajax": {
                "url": "<?= BASE_URL ?>productos/getProductos",
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
                {"data": "codigo"},
                {"data": "nombre"},
                {"data": "categoria"},
                {
                    "data": "precio_venta",
                    "render": function(data) {
                        return formatoPrecioCOP(data);
                    }
                },
                {
                    "data": "mano_obra",
                    "render": function(data) {
                        return data > 0 ? formatoPrecioCOP(data) : '-';
                    }
                },
                {
                    "data": "stock",
                    "render": function(data, type, row) {
                        let clase = 'bg-success';
                        if(parseInt(data) <= parseInt(row.stock_minimo)) {
                            clase = 'bg-danger';
                        }
                        return `<span class="badge ${clase}">${data}</span>`;
                    }
                },
                {
                    "data": "estado",
                    "render": function(data) {
                        if(data == 1) {
                            return '<span class="badge bg-success">Activo</span>';
                        } else {
                            return '<span class="badge bg-danger">Inactivo</span>';
                        }
                    }
                },
                {
                    "data": "id",
                    "render": function(data, type, row) {
                        return `
                            <button class="btn btn-sm btn-info" onclick="verProducto(${data})" title="Ver">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-primary" onclick="editarProducto(${data})" title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="eliminarProducto(${data})" title="Eliminar">
                                <i class="fas fa-trash"></i>
                            </button>`;
                    }
                }
            ],
            "responsive": true,
            "order": [[0, "desc"]]
        });
        
        // Evento para nuevo producto
        document.getElementById('btnNuevoProducto').addEventListener('click', function() {
            document.getElementById('formProducto').reset();
            document.getElementById('idProducto').value = '';
            document.getElementById('tituloModal').textContent = 'Nuevo Producto';
            document.getElementById('imagenPreview').innerHTML = '';
            
            // Habilitar todos los campos
            const inputs = document.querySelectorAll('#formProducto input, #formProducto select, #formProducto textarea');
            inputs.forEach(input => input.disabled = false);
            
            // Mostrar botón guardar
            document.getElementById('btnGuardar').style.display = 'block';
            
            const modal = new bootstrap.Modal(document.getElementById('modalProducto'), {
                backdrop: 'static',
                keyboard: false
            });
            modal.show();
        });
        
        // Evento para guardar producto
        document.getElementById('btnGuardar').addEventListener('click', guardarProducto);
        
        // Evento para previsualizar imagen
        document.getElementById('imagen').addEventListener('change', function() {
            const preview = document.getElementById('imagenPreview');
            preview.innerHTML = '';
            
            if(this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.maxHeight = '100px';
                    img.className = 'img-thumbnail';
                    preview.appendChild(img);
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
    
    function verProducto(id) {
        // Mostrar modal de carga
        const loadingModal = document.getElementById('loadingModal');
        loadingModal.classList.remove('hide');
        loadingModal.classList.add('show');
        
        // Cargar datos del producto
        fetch(`<?= BASE_URL ?>productos/getProducto/${id}`)
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
                // Llenar formulario en modo solo lectura
                document.getElementById('idProducto').value = data.id;
                document.getElementById('codigo').value = data.codigo;
                document.getElementById('nombre').value = data.nombre;
                document.getElementById('descripcion').value = data.descripcion;
                document.getElementById('precio_compra').value = data.precio_compra;
                document.getElementById('precio_venta').value = data.precio_venta;
                document.getElementById('stock').value = data.stock;
                document.getElementById('stock_minimo').value = data.stock_minimo;
                document.getElementById('categoria').value = data.categoria_id;
                document.getElementById('estado').value = data.estado;
                
                // Deshabilitar todos los campos
                const inputs = document.querySelectorAll('#formProducto input, #formProducto select, #formProducto textarea');
                inputs.forEach(input => input.disabled = true);
                
                // Mostrar imagen si existe
                document.getElementById('imagenPreview').innerHTML = '';
                if(data.imagen) {
                    const img = document.createElement('img');
                    img.src = `<?= BASE_URL ?>assets/images/productos/${data.imagen}`;
                    img.style.maxHeight = '100px';
                    img.className = 'img-thumbnail';
                    document.getElementById('imagenPreview').appendChild(img);
                }
                
                // Cambiar título y ocultar botón guardar
                document.getElementById('tituloModal').textContent = 'Ver Producto';
                document.getElementById('btnGuardar').style.display = 'none';
                
                // Ocultar modal de carga
                loadingModal.classList.remove('show');
                loadingModal.classList.add('hide');
                
                // Mostrar modal
                const modal = new bootstrap.Modal(document.getElementById('modalProducto'), {
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
                    text: 'No se pudo cargar la información del producto'
                });
            });
    }
    
    function cargarCategorias() {
        fetch('<?= BASE_URL ?>productos/getCategorias')
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
                const selectCategoria = document.getElementById('categoria');
                
                // Mantener la opción de seleccionar
                const optionSeleccionar = selectCategoria.options[0];
                selectCategoria.innerHTML = '';
                selectCategoria.appendChild(optionSeleccionar);
                
                // Agregar categorías
                data.forEach(categoria => {
                    const option = document.createElement('option');
                    option.value = categoria.id;
                    option.textContent = categoria.nombre;
                    selectCategoria.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
    
    function editarProducto(id) {
        // Mostrar modal de carga
        const loadingModal = document.getElementById('loadingModal');
        loadingModal.classList.remove('hide');
        loadingModal.classList.add('show');
        
        // Limpiar formulario
        document.getElementById('formProducto').reset();
        document.getElementById('imagenPreview').innerHTML = '';
        
        // Cambiar título del modal
        document.getElementById('tituloModal').textContent = 'Editar Producto';
        
        // Habilitar todos los campos
        const inputs = document.querySelectorAll('#formProducto input, #formProducto select, #formProducto textarea');
        inputs.forEach(input => input.disabled = false);
        
        // Mostrar botón guardar
        document.getElementById('btnGuardar').style.display = 'block';
        
        // Cargar datos del producto
        fetch(`<?= BASE_URL ?>productos/getProducto/${id}`)
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
                document.getElementById('idProducto').value = data.id;
                document.getElementById('codigo').value = data.codigo;
                document.getElementById('nombre').value = data.nombre;
                document.getElementById('descripcion').value = data.descripcion;
                document.getElementById('precio_compra').value = data.precio_compra;
                document.getElementById('precio_venta').value = data.precio_venta;
                document.getElementById('stock').value = data.stock;
                document.getElementById('stock_minimo').value = data.stock_minimo;
                document.getElementById('categoria').value = data.categoria_id;
                document.getElementById('estado').value = data.estado;
                
                // Mostrar imagen si existe
                if(data.imagen) {
                    const img = document.createElement('img');
                    img.src = `<?= BASE_URL ?>assets/images/productos/${data.imagen}`;
                    img.style.maxHeight = '100px';
                    img.className = 'img-thumbnail';
                    document.getElementById('imagenPreview').appendChild(img);
                }
                
                // Ocultar modal de carga
                loadingModal.classList.remove('show');
                loadingModal.classList.add('hide');
                
                // Mostrar modal
                const modal = new bootstrap.Modal(document.getElementById('modalProducto'), {
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
                    text: 'No se pudo cargar la información del producto'
                });
            });
    }
    
    function guardarProducto() {
        // Validar formulario
        const form = document.getElementById('formProducto');
        if(!form.checkValidity()) {
            form.classList.add('was-validated');
            return;
        }
        
        // Crear FormData
        const formData = new FormData(form);
        
        // Mostrar indicador de carga
        Swal.fire({
            title: 'Guardando',
            text: 'Por favor espere...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        // Enviar datos al servidor
        fetch('<?= BASE_URL ?>productos/setProducto', {
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
            // Cerrar indicador de carga
            Swal.close();
            
            if(data.status) {
                // Mostrar mensaje de éxito
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: data.msg,
                    timer: 2000,
                    showConfirmButton: false
                });
                
                // Cerrar modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('modalProducto'));
                modal.hide();
                
                // Recargar tabla
                tableProductos.ajax.reload();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.msg
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Ocurrió un error al procesar la solicitud'
            });
        });
    }
    
    function eliminarProducto(id) {
        Swal.fire({
            title: '¿Está seguro?',
            text: "Esta acción eliminará el producto",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Mostrar modal de carga
                const loadingModal = document.getElementById('loadingModal');
                loadingModal.classList.remove('hide');
                loadingModal.classList.add('show');
                
                const formData = new FormData();
                formData.append('idProducto', id);
                
                fetch('<?= BASE_URL ?>productos/delProducto', {
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
                            'Eliminado',
                            data.msg,
                            'success'
                        );
                        
                        // Recargar tabla
                        tableProductos.ajax.reload();
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
</script>