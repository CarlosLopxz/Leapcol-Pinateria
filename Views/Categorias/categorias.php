<?php 
    headerAdmin($data); 
?>

<!-- Main Body-->
<div class="d2c_main px-0 px-md-2 py-4">
    <div class="container-fluid">
        <!-- Title -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-0 text-capitalize">Gestión de Categorías</h4>
                <p class="text-muted">Administra las categorías de productos</p>
            </div>
            <div>
                <button type="button" class="btn btn-primary" onclick="openModal()">
                    <i class="fas fa-plus me-2"></i>Nueva Categoría
                </button>
            </div>
        </div>

        <!-- Categorías Table -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped" id="tableCategorias" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Estado</th>
                                <th>Fecha Creación</th>
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

<!-- Modal para Nueva/Editar Categoría -->
<div class="modal fade" id="modalFormCategoria" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalTitle">Nueva Categoría</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formCategoria" name="formCategoria" class="needs-validation" novalidate>
                    <input type="hidden" id="idCategoria" name="idCategoria" value="">
                    
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

<?php footerAdmin($data); ?>

<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Variable global para la tabla
    var tableCategorias;
    
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar DataTable
        tableCategorias = $('#tableCategorias').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
            },
            "ajax": {
                "url": "<?= BASE_URL ?>categorias/getCategorias",
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
                {"data": "nombre"},
                {"data": "descripcion"},
                {
                    "data": "estado",
                    "render": function(data) {
                        return data == 1 ? 
                            '<span class="badge bg-success">Activo</span>' : 
                            '<span class="badge bg-danger">Inactivo</span>';
                    }
                },
                {"data": "fecha_creacion"},
                {
                    "data": "id",
                    "render": function(data) {
                        return `
                            <button class="btn btn-sm btn-primary" onclick="editarCategoria(${data})" title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="eliminarCategoria(${data})" title="Eliminar">
                                <i class="fas fa-trash"></i>
                            </button>
                        `;
                    }
                }
            ],
            "responsive": true
        });
        
        // Manejar envío del formulario
        document.getElementById('formCategoria').addEventListener('submit', function(e) {
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
            fetch('<?= BASE_URL ?>categorias/setCategoria', {
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
                    let modal = bootstrap.Modal.getInstance(document.getElementById('modalFormCategoria'));
                    modal.hide();
                    
                    // Recargar tabla
                    tableCategorias.ajax.reload();
                    
                    // Resetear formulario
                    document.getElementById('formCategoria').reset();
                    document.getElementById('idCategoria').value = '';
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
                    text: 'Ocurrió un error al guardar la categoría. Por favor, inténtelo de nuevo.'
                });
                
                // Restaurar botón
                btnGuardar.innerHTML = 'Guardar';
                btnGuardar.disabled = false;
            });
        });
    });
    
    function openModal() {
        document.getElementById('modalTitle').textContent = 'Nueva Categoría';
        document.getElementById('formCategoria').reset();
        document.getElementById('idCategoria').value = '';
        
        let modal = new bootstrap.Modal(document.getElementById('modalFormCategoria'));
        modal.show();
    }
    
    function editarCategoria(id) {
        // Mostrar modal de carga
        const loadingModal = document.getElementById('loadingModal');
        loadingModal.classList.remove('hide');
        loadingModal.classList.add('show');
        
        document.getElementById('modalTitle').textContent = 'Editar Categoría';
        document.getElementById('idCategoria').value = id;
        
        // Cargar datos de la categoría desde la base de datos
        fetch(`<?= BASE_URL ?>categorias/getCategoria/${id}`)
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
                
                // Llenar el formulario con los datos de la categoría
                document.getElementById('nombre').value = data.nombre;
                document.getElementById('descripcion').value = data.descripcion || '';
                document.getElementById('estado').value = data.estado;
                
                // Ocultar modal de carga
                loadingModal.classList.remove('show');
                loadingModal.classList.add('hide');
                
                // Mostrar modal
                let modal = new bootstrap.Modal(document.getElementById('modalFormCategoria'));
                modal.show();
            })
            .catch(error => {
                console.error('Error:', error);
                
                // Ocultar modal de carga
                loadingModal.classList.remove('show');
                loadingModal.classList.add('hide');
                
                // Mostrar un mensaje de error más amigable
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo cargar la información de la categoría. Por favor, inténtelo de nuevo.'
                });
            });
    }
    
    function eliminarCategoria(id) {
        Swal.fire({
            title: '¿Está seguro?',
            text: "Esta acción no se puede revertir",
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
                
                // Enviar solicitud para eliminar la categoría
                const formData = new FormData();
                formData.append('idCategoria', id);
                
                fetch('<?= BASE_URL ?>categorias/delCategoria', {
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
                    // Ocultar modal de carga
                    loadingModal.classList.remove('show');
                    loadingModal.classList.add('hide');
                    
                    if(data.status) {
                        Swal.fire(
                            'Eliminado!',
                            data.msg,
                            'success'
                        );
                        // Recargar tabla
                        tableCategorias.ajax.reload();
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
                    
                    // Ocultar modal de carga
                    loadingModal.classList.remove('show');
                    loadingModal.classList.add('hide');
                    
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