<?php 
    headerAdmin($data); 
?>

<!-- Main Body-->
<div class="d2c_main px-0 px-md-2 py-4">
    <div class="container-fluid">
        <!-- Title -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-0 text-capitalize">Gestión de Usuarios</h4>
                <p class="text-muted">Administra los usuarios del sistema</p>
            </div>
            <div>
                <button class="btn btn-primary" id="btnNuevoUsuario">
                    <i class="fas fa-plus me-2"></i>Nuevo Usuario
                </button>
            </div>
        </div>

        <!-- Usuarios Table -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped" id="tableUsuarios" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Usuario</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th>status</th>
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

<!-- Modal para Usuario -->
<div class="modal fade" id="modalUsuario" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="tituloModal">Nuevo Usuario</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formUsuario">
                    <input type="hidden" id="idUsuario" name="idUsuario" value="">
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nombre" class="form-label">Nombre <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="col-md-6">
                            <label for="apellido" class="form-label">Apellido <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="apellido" name="apellido" required>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="usuario" class="form-label">Usuario <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="usuario" name="usuario" required>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="password" class="form-label">Contraseña <span class="text-danger" id="passRequired">*</span></label>
                            <input type="password" class="form-control" id="password" name="password">
                            <small class="text-muted" id="passHelp">Dejar vacío para mantener la actual</small>
                        </div>
                        <div class="col-md-6">
                            <label for="rolid" class="form-label">Rol <span class="text-danger">*</span></label>
                            <select class="form-select" id="rolid" name="rolid" required>
                                <option value="">Seleccionar rol</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="status" class="form-label">status</label>
                        <select class="form-select" id="status" name="status">
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
    var tableUsuarios;
    
    document.addEventListener('DOMContentLoaded', function() {
        // Cargar roles
        cargarRoles();
        
        // Inicializar DataTable
        tableUsuarios = $('#tableUsuarios').DataTable({
            "language": {"url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"},
            "ajax": {
                "url": "<?= BASE_URL ?>usuarios/getUsuarios",
                "dataSrc": function(json) { return json || []; }
            },
            "columns": [
                {"data": "idusuario"},
                {
                    "data": null,
                    "render": function(data) {
                        return data.nombre + ' ' + data.apellido;
                    }
                },
                {"data": "usuario"},
                {"data": "email"},
                {"data": "nombrerol"},
                {
                    "data": "status",
                    "render": function(data) {
                        if(data == 1) return '<span class="badge bg-success">Activo</span>';
                        if(data == 0) return '<span class="badge bg-warning">Inactivo</span>';
                        return '<span class="badge bg-danger">Eliminado</span>';
                    }
                },
                {
                    "data": "idusuario",
                    "render": function(data) {
                        return `
                            <button class="btn btn-sm btn-primary" onclick="editarUsuario(${data})" title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="eliminarUsuario(${data})" title="Eliminar">
                                <i class="fas fa-trash"></i>
                            </button>`;
                    }
                }
            ],
            "order": [[0, "desc"]]
        });
        
        // Eventos
        document.getElementById('btnNuevoUsuario').addEventListener('click', function() {
            document.getElementById('formUsuario').reset();
            document.getElementById('idUsuario').value = '';
            document.getElementById('tituloModal').textContent = 'Nuevo Usuario';
            document.getElementById('passRequired').style.display = 'inline';
            document.getElementById('passHelp').style.display = 'none';
            document.getElementById('password').required = true;
            
            const modal = new bootstrap.Modal(document.getElementById('modalUsuario'));
            modal.show();
        });
        
        document.getElementById('btnGuardar').addEventListener('click', guardarUsuario);
    });
    
    function cargarRoles() {
        fetch('<?= BASE_URL ?>usuarios/getRoles')
            .then(response => response.json())
            .then(data => {
                const select = document.getElementById('rolid');
                select.innerHTML = '<option value="">Seleccionar rol</option>';
                data.forEach(rol => {
                    select.innerHTML += `<option value="${rol.idrol}">${rol.nombrerol}</option>`;
                });
            });
    }
    
    function editarUsuario(id) {
        document.getElementById('formUsuario').reset();
        document.getElementById('tituloModal').textContent = 'Editar Usuario';
        document.getElementById('passRequired').style.display = 'none';
        document.getElementById('passHelp').style.display = 'block';
        document.getElementById('password').required = false;
        
        fetch(`<?= BASE_URL ?>usuarios/getUsuario/${id}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('idUsuario').value = data.idusuario;
                document.getElementById('nombre').value = data.nombre;
                document.getElementById('apellido').value = data.apellido;
                document.getElementById('usuario').value = data.usuario;
                document.getElementById('email').value = data.email;
                document.getElementById('rolid').value = data.rolid;
                document.getElementById('status').value = data.status;
                
                const modal = new bootstrap.Modal(document.getElementById('modalUsuario'));
                modal.show();
            });
    }
    
    function guardarUsuario() {
        const form = document.getElementById('formUsuario');
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
        
        fetch('<?= BASE_URL ?>usuarios/setUsuario', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            Swal.close();
            if(data.status) {
                Swal.fire('Éxito', data.msg, 'success');
                const modal = bootstrap.Modal.getInstance(document.getElementById('modalUsuario'));
                modal.hide();
                tableUsuarios.ajax.reload();
            } else {
                Swal.fire('Error', data.msg, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error', 'Ocurrió un error al procesar la solicitud', 'error');
        });
    }
    
    function eliminarUsuario(id) {
        Swal.fire({
            title: '¿Está seguro?',
            text: "Esta acción eliminará el usuario",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                const formData = new FormData();
                formData.append('idUsuario', id);
                
                fetch('<?= BASE_URL ?>usuarios/delUsuario', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if(data.status) {
                        Swal.fire('Eliminado', data.msg, 'success');
                        tableUsuarios.ajax.reload();
                    } else {
                        Swal.fire('Error', data.msg, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error', 'Ocurrió un error al procesar la solicitud', 'error');
                });
            }
        });
    }
</script>