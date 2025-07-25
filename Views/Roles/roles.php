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
        </div>

        <div class="row">
            <!-- Lista de Roles -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
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
</script>