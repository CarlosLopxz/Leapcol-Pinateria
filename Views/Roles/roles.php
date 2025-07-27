<?php 
    headerAdmin($data); 
?>

<!-- Main Body-->
<div class="d2c_main px-0 px-md-2 py-4">
    <div class="container-fluid">
        <!-- Title -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-0 text-capitalize">Gestión de Roles y Permisos</h4>
                <p class="text-muted">Configura qué módulos puede ver cada rol</p>
            </div>
            <div>
                <button class="btn btn-primary" id="btnNuevoRol">
                    <i class="fas fa-plus me-2"></i>Nuevo Rol
                </button>
            </div>
        </div>

        <div class="row">
            <!-- Lista de Roles -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Roles del Sistema</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group" id="listaRoles">
                            <!-- Se cargarán dinámicamente -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Permisos del Rol -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Permisos para: <span id="rolSeleccionado">Seleccione un rol</span></h5>
                    </div>
                    <div class="card-body">
                        <form id="formPermisos">
                            <input type="hidden" id="rolId" name="rolId" value="">
                            
                            <div class="row" id="modulosContainer">
                                <div class="col-12 text-center text-muted">
                                    <p>Seleccione un rol para configurar sus permisos</p>
                                </div>
                            </div>
                            
                            <div class="mt-3" id="botonesContainer" style="display: none;">
                                <button type="button" class="btn btn-primary" id="btnGuardarPermisos">
                                    <i class="fas fa-save me-2"></i>Guardar Permisos
                                </button>
                                <button type="button" class="btn btn-secondary" id="btnSeleccionarTodos">
                                    <i class="fas fa-check-square me-2"></i>Seleccionar Todos
                                </button>
                                <button type="button" class="btn btn-outline-secondary" id="btnDeseleccionarTodos">
                                    <i class="fas fa-square me-2"></i>Deseleccionar Todos
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End:Main Body -->

<!-- Modal Rol -->
<div class="modal fade" id="modalRol" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tituloModalRol">Nuevo Rol</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formRol">
                    <input type="hidden" id="idRol" name="idrol" value="">
                    
                    <div class="mb-3">
                        <label for="nombreRol" class="form-label">Nombre del Rol <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nombreRol" name="nombrerol" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="descripcionRol" class="form-label">Descripción</label>
                        <textarea class="form-control" id="descripcionRol" name="descripcion" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnGuardarRol">Guardar</button>
            </div>
        </div>
    </div>
</div>

<?php footerAdmin($data); ?>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    let roles = [];
    let modulos = [];
    let rolActual = null;
    
    document.addEventListener('DOMContentLoaded', function() {
        cargarRoles();
        cargarModulos();
        
        // Eventos
        document.getElementById('btnGuardarPermisos').addEventListener('click', guardarPermisos);
        document.getElementById('btnSeleccionarTodos').addEventListener('click', seleccionarTodos);
        document.getElementById('btnDeseleccionarTodos').addEventListener('click', deseleccionarTodos);
        document.getElementById('btnNuevoRol').addEventListener('click', nuevoRol);
        document.getElementById('btnGuardarRol').addEventListener('click', guardarRol);
    });
    
    function cargarRoles() {
        fetch('<?= BASE_URL ?>roles/getRoles')
            .then(response => response.json())
            .then(data => {
                roles = data;
                const lista = document.getElementById('listaRoles');
                lista.innerHTML = '';
                
                data.forEach(rol => {
                    const item = document.createElement('a');
                    item.href = '#';
                    item.className = 'list-group-item list-group-item-action';
                    item.innerHTML = `
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">${rol.nombrerol}</h6>
                            <button class="btn btn-sm btn-outline-primary" onclick="editarRol(${rol.idrol})" title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                        </div>
                        <p class="mb-1">${rol.descripcion || 'Sin descripción'}</p>
                    `;
                    item.addEventListener('click', (e) => {
                        e.preventDefault();
                        seleccionarRol(rol);
                    });
                    lista.appendChild(item);
                });
            });
    }
    
    function cargarModulos() {
        fetch('<?= BASE_URL ?>roles/getModulos')
            .then(response => response.json())
            .then(data => {
                modulos = data;
            });
    }
    
    function seleccionarRol(rol) {
        rolActual = rol;
        document.getElementById('rolId').value = rol.idrol;
        document.getElementById('rolSeleccionado').textContent = rol.nombrerol;
        
        // Marcar rol activo
        document.querySelectorAll('#listaRoles .list-group-item').forEach(item => {
            item.classList.remove('active');
        });
        event.target.closest('.list-group-item').classList.add('active');
        
        // Cargar permisos del rol
        cargarPermisos(rol.idrol);
        
        // Mostrar botones
        document.getElementById('botonesContainer').style.display = 'block';
    }
    
    function cargarPermisos(rolId) {
        fetch(`<?= BASE_URL ?>roles/getPermisos/${rolId}`)
            .then(response => response.json())
            .then(permisos => {
                mostrarModulos(permisos);
            });
    }
    
    function mostrarModulos(permisosActivos) {
        const container = document.getElementById('modulosContainer');
        container.innerHTML = '';
        
        modulos.forEach(modulo => {
            const col = document.createElement('div');
            col.className = 'col-md-6 mb-3';
            
            const isChecked = permisosActivos.includes(modulo.id);
            
            col.innerHTML = `
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="modulos[]" value="${modulo.id}" id="modulo_${modulo.id}" ${isChecked ? 'checked' : ''}>
                    <label class="form-check-label" for="modulo_${modulo.id}">
                        <i class="${modulo.icono} me-2"></i>${modulo.nombre}
                        <small class="text-muted d-block">${modulo.descripcion}</small>
                    </label>
                </div>
            `;
            
            container.appendChild(col);
        });
    }
    
    function guardarPermisos() {
        if (!rolActual) {
            Swal.fire('Error', 'Seleccione un rol primero', 'error');
            return;
        }
        
        const formData = new FormData(document.getElementById('formPermisos'));
        
        Swal.fire({
            title: 'Guardando',
            text: 'Actualizando permisos...',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });
        
        fetch('<?= BASE_URL ?>roles/setPermisos', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            Swal.close();
            if(data.status) {
                Swal.fire('Éxito', data.msg, 'success');
            } else {
                Swal.fire('Error', data.msg, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error', 'Ocurrió un error al guardar los permisos', 'error');
        });
    }
    
    function seleccionarTodos() {
        document.querySelectorAll('input[name="modulos[]"]').forEach(checkbox => {
            checkbox.checked = true;
        });
    }
    
    function deseleccionarTodos() {
        document.querySelectorAll('input[name="modulos[]"]').forEach(checkbox => {
            checkbox.checked = false;
        });
    }
    
    function nuevoRol() {
        document.getElementById('formRol').reset();
        document.getElementById('idRol').value = '';
        document.getElementById('tituloModalRol').textContent = 'Nuevo Rol';
        
        const modal = new bootstrap.Modal(document.getElementById('modalRol'));
        modal.show();
    }
    
    function editarRol(rolId) {
        fetch(`<?= BASE_URL ?>roles/getRol/${rolId}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('idRol').value = data.idrol;
                document.getElementById('nombreRol').value = data.nombrerol;
                document.getElementById('descripcionRol').value = data.descripcion || '';
                document.getElementById('tituloModalRol').textContent = 'Editar Rol';
                
                const modal = new bootstrap.Modal(document.getElementById('modalRol'));
                modal.show();
            });
    }
    
    function guardarRol() {
        const form = document.getElementById('formRol');
        if(!form.checkValidity()) {
            form.classList.add('was-validated');
            return;
        }
        
        const formData = new FormData(form);
        
        Swal.fire({
            title: 'Guardando',
            text: 'Por favor espere...',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });
        
        fetch('<?= BASE_URL ?>roles/setRol', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            Swal.close();
            if(data.status) {
                Swal.fire('Éxito', data.msg, 'success');
                const modal = bootstrap.Modal.getInstance(document.getElementById('modalRol'));
                modal.hide();
                cargarRoles();
            } else {
                Swal.fire('Error', data.msg, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error', 'Ocurrió un error al guardar el rol', 'error');
        });
    }
</script>