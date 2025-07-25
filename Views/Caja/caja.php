<?php 
    headerAdmin($data); 
?>

<!-- Main Body-->
<div class="d2c_main px-0 px-md-2 py-4">
    <div class="container-fluid">
        <!-- Title -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-0 text-capitalize">Gestión de Caja</h4>
                <p class="text-muted">Control de ingresos y egresos de caja</p>
            </div>
            <div>
                <?php if(!$data['cajaAbierta']): ?>
                    <button class="btn btn-success" id="btnAbrirCaja">
                        <i class="fas fa-cash-register me-2"></i>Abrir Caja
                    </button>
                <?php else: ?>
                    <button class="btn btn-danger" id="btnCerrarCaja">
                        <i class="fas fa-lock me-2"></i>Cerrar Caja
                    </button>
                <?php endif; ?>
            </div>
        </div>

        <?php if($data['cajaAbierta']): ?>
        <!-- Estado de Caja Abierta -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-cash-register fa-2x me-3"></i>
                            <div>
                                <h6 class="mb-0">Caja Abierta</h6>
                                <small>Desde: <?= date('d/m/Y H:i', strtotime($data['cajaAbierta']['fecha_apertura'])) ?></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-dollar-sign fa-2x me-3"></i>
                            <div>
                                <h6 class="mb-0">Monto Inicial</h6>
                                <h5 class="mb-0">$<?= number_format($data['cajaAbierta']['monto_inicial'], 0) ?></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-shopping-cart fa-2x me-3"></i>
                            <div>
                                <h6 class="mb-0">Total Ventas</h6>
                                <h5 class="mb-0" id="totalVentas">$<?= number_format($data['cajaAbierta']['total_ventas'], 0) ?></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-calculator fa-2x me-3"></i>
                            <div>
                                <h6 class="mb-0">Total en Caja</h6>
                                <h5 class="mb-0" id="totalCaja">$<?= number_format($data['cajaAbierta']['monto_inicial'] + $data['cajaAbierta']['total_ventas'], 0) ?></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botones de Acción -->
        <div class="row mb-4">
            <div class="col-md-6">
                <button class="btn btn-success w-100" id="btnIngreso">
                    <i class="fas fa-plus-circle me-2"></i>Registrar Ingreso
                </button>
            </div>
            <div class="col-md-6">
                <button class="btn btn-danger w-100" id="btnEgreso">
                    <i class="fas fa-minus-circle me-2"></i>Registrar Egreso
                </button>
            </div>
        </div>

        <!-- Movimientos de Caja -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Movimientos de Caja</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="tablaMovimientos">
                        <thead>
                            <tr>
                                <th>Hora</th>
                                <th>Tipo</th>
                                <th>Concepto</th>
                                <th>Método</th>
                                <th>Monto</th>
                                <th>Usuario</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

        <?php else: ?>
        <!-- Caja Cerrada -->
        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-lock fa-5x text-muted mb-3"></i>
                <h3>Caja Cerrada</h3>
                <p class="text-muted">Debes abrir la caja para comenzar a trabajar</p>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
<!-- End:Main Body -->

<!-- Modal Abrir Caja -->
<div class="modal fade" id="modalAbrirCaja" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Abrir Caja</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formAbrirCaja">
                    <div class="mb-3">
                        <label for="montoInicial" class="form-label">Monto Inicial <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" class="form-control" id="montoInicial" name="montoInicial" min="0" step="0.01" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="observacionesApertura" class="form-label">Observaciones</label>
                        <textarea class="form-control" id="observacionesApertura" name="observaciones" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" id="btnConfirmarApertura">Abrir Caja</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Cerrar Caja -->
<div class="modal fade" id="modalCerrarCaja" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Cerrar Caja</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formCerrarCaja">
                    <input type="hidden" id="cajaIdCierre" value="<?= $data['cajaAbierta']['id'] ?? '' ?>">
                    <div class="mb-3">
                        <label for="montoFinal" class="form-label">Monto Final en Caja <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" class="form-control" id="montoFinal" name="montoFinal" min="0" step="0.01" required>
                        </div>
                        <small class="text-muted">Ingresa el dinero físico que hay en la caja</small>
                    </div>
                    <div class="mb-3">
                        <label for="observacionesCierre" class="form-label">Observaciones</label>
                        <textarea class="form-control" id="observacionesCierre" name="observaciones" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="btnConfirmarCierre">Cerrar Caja</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Movimiento -->
<div class="modal fade" id="modalMovimiento" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" id="headerMovimiento">
                <h5 class="modal-title" id="tituloMovimiento">Registrar Movimiento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formMovimiento">
                    <input type="hidden" id="cajaIdMovimiento" value="<?= $data['cajaAbierta']['id'] ?? '' ?>">
                    <input type="hidden" id="tipoMovimiento" name="tipo">
                    
                    <div class="mb-3">
                        <label for="concepto" class="form-label">Concepto <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="concepto" name="concepto" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="monto" class="form-label">Monto <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" class="form-control" id="monto" name="monto" min="0" step="0.01" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="metodoPago" class="form-label">Método</label>
                        <select class="form-select" id="metodoPago" name="metodoPago">
                            <option value="1">Efectivo</option>
                            <option value="2">Tarjeta</option>
                            <option value="4">Transferencia</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnGuardarMovimiento">Guardar</button>
            </div>
        </div>
    </div>
</div>

<?php footerAdmin($data); ?>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    const cajaAbierta = <?= $data['cajaAbierta'] ? 'true' : 'false' ?>;
    const cajaId = <?= $data['cajaAbierta']['id'] ?? 'null' ?>;
    
    document.addEventListener('DOMContentLoaded', function() {
        if(cajaAbierta) {
            cargarMovimientos();
            actualizarResumen();
        }
        
        // Eventos
        document.getElementById('btnAbrirCaja')?.addEventListener('click', function() {
            const modal = new bootstrap.Modal(document.getElementById('modalAbrirCaja'));
            modal.show();
        });
        
        document.getElementById('btnCerrarCaja')?.addEventListener('click', function() {
            const modal = new bootstrap.Modal(document.getElementById('modalCerrarCaja'));
            modal.show();
        });
        
        document.getElementById('btnIngreso')?.addEventListener('click', function() {
            abrirModalMovimiento('ingreso', 'Registrar Ingreso', 'bg-success text-white');
        });
        
        document.getElementById('btnEgreso')?.addEventListener('click', function() {
            abrirModalMovimiento('egreso', 'Registrar Egreso', 'bg-danger text-white');
        });
        
        document.getElementById('btnConfirmarApertura')?.addEventListener('click', abrirCaja);
        document.getElementById('btnConfirmarCierre')?.addEventListener('click', cerrarCaja);
        document.getElementById('btnGuardarMovimiento')?.addEventListener('click', guardarMovimiento);
    });
    
    function abrirModalMovimiento(tipo, titulo, clase) {
        document.getElementById('tipoMovimiento').value = tipo;
        document.getElementById('tituloMovimiento').textContent = titulo;
        document.getElementById('headerMovimiento').className = 'modal-header ' + clase;
        document.getElementById('formMovimiento').reset();
        document.getElementById('tipoMovimiento').value = tipo;
        
        const modal = new bootstrap.Modal(document.getElementById('modalMovimiento'));
        modal.show();
    }
    
    function abrirCaja() {
        const form = document.getElementById('formAbrirCaja');
        if(!form.checkValidity()) {
            form.classList.add('was-validated');
            return;
        }
        
        const formData = new FormData(form);
        
        fetch('<?= BASE_URL ?>caja/abrirCaja', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if(data.status) {
                Swal.fire('Éxito', data.msg, 'success').then(() => {
                    location.reload();
                });
            } else {
                Swal.fire('Error', data.msg, 'error');
            }
        });
    }
    
    function cerrarCaja() {
        const form = document.getElementById('formCerrarCaja');
        if(!form.checkValidity()) {
            form.classList.add('was-validated');
            return;
        }
        
        const formData = new FormData(form);
        
        Swal.fire({
            title: '¿Cerrar caja?',
            text: 'Esta acción no se puede deshacer',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, cerrar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('<?= BASE_URL ?>caja/cerrarCaja', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if(data.status) {
                        Swal.fire('Éxito', data.msg, 'success').then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Error', data.msg, 'error');
                    }
                });
            }
        });
    }
    
    function guardarMovimiento() {
        const form = document.getElementById('formMovimiento');
        if(!form.checkValidity()) {
            form.classList.add('was-validated');
            return;
        }
        
        const formData = new FormData(form);
        
        fetch('<?= BASE_URL ?>caja/registrarMovimiento', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if(data.status) {
                Swal.fire('Éxito', data.msg, 'success');
                const modal = bootstrap.Modal.getInstance(document.getElementById('modalMovimiento'));
                modal.hide();
                cargarMovimientos();
                actualizarResumen();
            } else {
                Swal.fire('Error', data.msg, 'error');
            }
        });
    }
    
    function cargarMovimientos() {
        if(!cajaId) return;
        
        fetch(`<?= BASE_URL ?>caja/getMovimientos/${cajaId}`)
            .then(response => response.json())
            .then(data => {
                const tbody = document.querySelector('#tablaMovimientos tbody');
                tbody.innerHTML = '';
                
                data.forEach(mov => {
                    const tipo = mov.tipo === 'ingreso' ? '<span class="badge bg-success">Ingreso</span>' : 
                                mov.tipo === 'egreso' ? '<span class="badge bg-danger">Egreso</span>' : 
                                '<span class="badge bg-info">Venta</span>';
                    
                    const metodo = mov.metodo_pago == 1 ? 'Efectivo' : 
                                  mov.metodo_pago == 2 ? 'Tarjeta' : 'Transferencia';
                    
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${new Date(mov.fecha).toLocaleTimeString()}</td>
                        <td>${tipo}</td>
                        <td>${mov.concepto}</td>
                        <td>${metodo}</td>
                        <td>$${parseFloat(mov.monto).toLocaleString()}</td>
                        <td>${mov.usuario_nombre}</td>
                    `;
                    tbody.appendChild(tr);
                });
            });
    }
    
    function actualizarResumen() {
        if(!cajaId) return;
        
        fetch(`<?= BASE_URL ?>caja/getResumenCaja/${cajaId}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('totalVentas').textContent = '$' + parseFloat(data.total_ventas || 0).toLocaleString();
                const totalCaja = parseFloat(data.monto_inicial || 0) + parseFloat(data.total_ventas || 0);
                document.getElementById('totalCaja').textContent = '$' + totalCaja.toLocaleString();
            });
    }
</script>