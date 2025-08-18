<?php 
    headerAdmin($data); 
?>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
            <div class="col-md-2">
                <div class="card bg-light border-0 shadow-sm">
                    <div class="card-body p-2">
                        <div class="text-center">
                            <i class="fas fa-cash-register mb-1 text-muted"></i>
                            <h6 class="mb-0 small text-muted">Caja Abierta</h6>
                            <small class="text-dark"><?= date('d/m H:i', strtotime($data['cajaAbierta']['fecha_apertura'])) ?></small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card bg-white border-1 shadow-sm">
                    <div class="card-body p-2">
                        <div class="text-center">
                            <i class="fas fa-dollar-sign mb-1 text-muted"></i>
                            <h6 class="mb-0 small text-muted">Monto Inicial</h6>
                            <h6 class="mb-0 text-dark">$<?= number_format($data['cajaAbierta']['monto_inicial'], 0) ?></h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card bg-light border-0 shadow-sm">
                    <div class="card-body p-2">
                        <div class="text-center">
                            <i class="fas fa-shopping-cart mb-1 text-muted"></i>
                            <h6 class="mb-0 small text-muted">Ventas</h6>
                            <h6 class="mb-0 text-dark" id="totalVentas">$<?= number_format($data['cajaAbierta']['total_ventas'], 0) ?></h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card bg-white border-1 shadow-sm">
                    <div class="card-body p-2">
                        <div class="text-center">
                            <i class="fas fa-credit-card mb-1 text-muted"></i>
                            <h6 class="mb-0 small text-muted">Transferencias</h6>
                            <h6 class="mb-0 text-dark" id="totalTransferencias">$0</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card bg-light border-0 shadow-sm">
                    <div class="card-body p-2">
                        <div class="text-center">
                            <i class="fas fa-plus-circle mb-1 text-muted"></i>
                            <h6 class="mb-0 small text-muted">Ingresos</h6>
                            <h6 class="mb-0 text-dark" id="totalIngresos">$0</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card bg-white border-1 shadow-sm">
                    <div class="card-body p-2">
                        <div class="text-center">
                            <i class="fas fa-minus-circle mb-1 text-muted"></i>
                            <h6 class="mb-0 small text-muted">Egresos</h6>
                            <h6 class="mb-0 text-dark" id="totalEgresos">$0</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card bg-light border-2 shadow-sm">
                    <div class="card-body p-3">
                        <div class="text-center">
                            <i class="fas fa-calculator me-2 text-muted"></i>
                            <h5 class="mb-0 text-dark">Total en Caja: <span id="totalCaja" class="fw-bold">$<?= number_format($data['cajaAbierta']['total_actual'] ?? ($data['cajaAbierta']['monto_inicial'] + $data['cajaAbierta']['total_ventas']), 0) ?></span></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botones de Acción -->
        <div class="d-flex flex-wrap gap-2 mb-4">
            <button class="btn btn-success flex-fill" id="btnIngreso">
                <i class="fas fa-plus-circle me-2"></i>Ingreso
            </button>
            <button class="btn btn-danger flex-fill" id="btnEgreso">
                <i class="fas fa-minus-circle me-2"></i>Egreso
            </button>
        </div>

        <!-- Resumen Visual -->
        <div class="card mb-4" id="resumenVisual" style="display: none;">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">Resumen de Cierre de Caja</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <canvas id="graficoIngresos" width="300" height="200"></canvas>
                    </div>
                    <div class="col-md-6">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <tr class="table-success"><td><strong>Transferencias:</strong></td><td id="resumenTransferencias">$0</td></tr>
                                <tr class="table-info"><td><strong>Ingresos:</strong></td><td id="resumenIngresos">$0</td></tr>
                                <tr class="table-danger"><td><strong>Egresos:</strong></td><td id="resumenEgresos">$0</td></tr>
                                <tr class="table-dark"><td><strong>TOTAL GENERAL:</strong></td><td id="resumenTotal">$0</td></tr>
                            </table>
                        </div>
                    </div>
                </div>
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
            <br><br>
        <?php else: ?>
        <!-- Caja Cerrada -->
        <div class="card mb-4">
            <div class="card-body text-center">
                <i class="fas fa-lock fa-5x text-muted mb-3"></i>
                <h3>Caja Cerrada</h3>
                <p class="text-muted">Debes abrir la caja para comenzar a trabajar</p>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- Historial de Cajas -->
        <?php if(!empty($data['historialCajas'])): ?>
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Historial de Cajas Recientes</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Fecha Apertura</th>
                                <th>Fecha Cierre</th>
                                <th>Monto Inicial</th>
                                <th>Total Ventas</th>
                                <th>Total de Caja Final</th>
                                <th>Diferencia</th>
                                <th>Usuario</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($data['historialCajas'] as $caja): ?>
                            <?php 
                                $diferencia = ($caja['monto_final'] ?? 0) - (($caja['monto_inicial'] ?? 0) + ($caja['total_ventas'] ?? 0));
                                $colorDiferencia = $diferencia == 0 ? 'text-success' : ($diferencia > 0 ? 'text-info' : 'text-danger');
                            ?>
                            <tr>
                                <td><?= date('d/m/Y H:i', strtotime($caja['fecha_apertura'])) ?></td>
                                <td>
                                    <?= $caja['fecha_cierre'] ? date('d/m/Y H:i', strtotime($caja['fecha_cierre'])) : '<span class="badge bg-success">Abierta</span>' ?>
                                </td>
                                <td>$<?= number_format($caja['monto_inicial'] ?? 0, 0) ?></td>
                                <td>$<?= number_format($caja['total_ventas'] ?? 0, 0) ?></td>
                                <td>
                                    <?= $caja['monto_final'] ? '$' . number_format($caja['monto_final'], 0) : '-' ?>
                                </td>
                                <td class="<?= $colorDiferencia ?>">
                                    <?= $caja['fecha_cierre'] ? '$' . number_format($diferencia, 0) : '-' ?>
                                </td>
                                <td><?= $caja['usuario_nombre'] ?></td>
                                <td>
                                    <?php if($caja['fecha_cierre']): ?>
                                    <button class="btn btn-sm btn-info" onclick="verDetallesCaja(<?= $caja['id'] ?>)" title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-success" onclick="generarReporte(<?= $caja['id'] ?>)" title="Generar reporte">
                                        <i class="fas fa-file-pdf"></i>
                                    </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
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

<!-- Modal Cancelar Venta -->
<div class="modal fade" id="modalCancelarVenta" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title">Cancelar Venta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formCancelarVenta">
                    <div class="mb-3">
                        <label for="ventaIdCancelar" class="form-label">ID de Venta <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="ventaIdCancelar" name="ventaId" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="motivoCancelacion" class="form-label">Motivo de Cancelación</label>
                        <textarea class="form-control" id="motivoCancelacion" name="motivo" rows="3"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="ajusteCaja" name="ajusteCaja">
                            <label class="form-check-label" for="ajusteCaja">
                                Ajustar efectivo en caja (devolver dinero al cliente)
                            </label>
                        </div>
                    </div>
                    
                    <div class="mb-3" id="montoDevolucionContainer" style="display: none;">
                        <label for="montoDevuelto" class="form-label">Monto a Devolver</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" class="form-control" id="montoDevuelto" name="montoDevuelto" min="0" step="0.01">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-warning" id="btnConfirmarCancelacion">Cancelar Venta</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Producto Temporal -->
<div class="modal fade" id="modalProductoTemporal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Agregar Producto No Inventariado</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formProductoTemporal">
                    <div class="mb-3">
                        <label for="nombreProductoTemporal" class="form-label">Nombre del Producto <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nombreProductoTemporal" name="nombre" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="precioProductoTemporal" class="form-label">Precio <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" class="form-control" id="precioProductoTemporal" name="precio" min="0" step="0.01" required>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" id="btnGuardarProductoTemporal">Agregar al Carrito</button>
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
                    <input type="hidden" id="cajaId" name="cajaId" value="<?= $data['cajaAbierta']['id'] ?? '' ?>">
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
                    
                    <div class="mb-3" id="metodoContainer">
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

<!-- Modal Detalles de Caja -->
<div class="modal fade" id="modalDetallesCaja" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Detalles de Caja Cerrada</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="contenidoDetallesCaja">
                <!-- Se cargará dinámicamente -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<?php footerAdmin($data); ?>

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
            abrirModalMovimiento('ingreso', 'Registrar Ingreso en Caja', 'bg-success text-white');
        });
        
        document.getElementById('btnEgreso')?.addEventListener('click', function() {
            abrirModalMovimiento('egreso', 'Registrar Egreso de Caja', 'bg-danger text-white');
        });
        
        document.getElementById('btnConfirmarApertura')?.addEventListener('click', abrirCaja);
        document.getElementById('btnConfirmarCierre')?.addEventListener('click', cerrarCaja);
        document.getElementById('btnGuardarMovimiento')?.addEventListener('click', guardarMovimiento);
        document.getElementById('btnPuntoVenta')?.addEventListener('click', function() {
            window.location.href = '<?= BASE_URL ?>pos';
        });
        document.getElementById('btnHistorialCaja')?.addEventListener('click', mostrarResumenVisual);
        document.getElementById('ajusteCaja')?.addEventListener('change', function() {
            const container = document.getElementById('montoDevolucionContainer');
            container.style.display = this.checked ? 'block' : 'none';
        });
        document.getElementById('btnConfirmarCancelacion')?.addEventListener('click', cancelarVenta);
        document.getElementById('btnGuardarProductoTemporal')?.addEventListener('click', guardarProductoTemporal);
    });
    
    function abrirModalMovimiento(tipo, titulo, clase) {
        document.getElementById('tipoMovimiento').value = tipo;
        document.getElementById('tituloMovimiento').textContent = titulo;
        document.getElementById('headerMovimiento').className = 'modal-header ' + clase;
        document.getElementById('formMovimiento').reset();
        document.getElementById('tipoMovimiento').value = tipo;
        document.getElementById('cajaId').value = cajaId;
        
        // Ocultar método de pago para ambos tipos y forzar efectivo
        const metodoContainer = document.getElementById('metodoContainer');
        metodoContainer.style.display = 'none';
        document.getElementById('metodoPago').value = 1; // Forzar efectivo
        
        const modal = new bootstrap.Modal(document.getElementById('modalMovimiento'));
        modal.show();
    }
    
    function abrirCaja() {
        const form = document.getElementById('formAbrirCaja');
        if(!form.checkValidity()) {
            form.classList.add('was-validated');
            return;
        }
        
        // Mostrar modal de carga
        const loadingModal = document.getElementById('loadingModal');
        loadingModal.classList.remove('hide');
        loadingModal.classList.add('show');
        
        const formData = new FormData(form);
        
        fetch('<?= BASE_URL ?>caja/abrirCaja', {
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
                const data = JSON.parse(text);
                
                // Ocultar modal de carga
                loadingModal.classList.remove('show');
                loadingModal.classList.add('hide');
                
                if(data.status) {
                    Swal.fire('Éxito', data.msg, 'success').then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Error', data.msg, 'error');
                }
            } catch (e) {
                console.error('Respuesta del servidor:', text);
                
                // Ocultar modal de carga
                loadingModal.classList.remove('show');
                loadingModal.classList.add('hide');
                
                Swal.fire('Error', 'Error al procesar la respuesta del servidor', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            
            // Ocultar modal de carga
            loadingModal.classList.remove('show');
            loadingModal.classList.add('hide');
            
            Swal.fire('Error', 'Error de conexión', 'error');
        });
    }
    
    function cerrarCaja() {
        const form = document.getElementById('formCerrarCaja');
        if(!form.checkValidity()) {
            form.classList.add('was-validated');
            return;
        }
        
        const formData = new FormData();
        formData.append('cajaId', document.getElementById('cajaIdCierre').value);
        formData.append('montoFinal', document.getElementById('montoFinal').value);
        formData.append('observaciones', document.getElementById('observacionesCierre').value);
        
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
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la respuesta del servidor');
            }
            return response.text();
        })
        .then(text => {
            try {
                const data = JSON.parse(text);
                if(data.status) {
                    Swal.fire('Éxito', data.msg, 'success');
                    const modal = bootstrap.Modal.getInstance(document.getElementById('modalMovimiento'));
                    modal.hide();
                    cargarMovimientos();
                    actualizarResumen();
                } else {
                    Swal.fire('Error', data.msg, 'error');
                }
            } catch (e) {
                console.error('Respuesta del servidor:', text);
                Swal.fire('Error', 'Error al procesar la respuesta del servidor', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error', 'Error de conexión', 'error');
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
                    
                    // Aplicar estilo rojo si es una venta anulada (monto negativo)
                    if (mov.concepto && mov.concepto.includes('anulada') && parseFloat(mov.monto) < 0) {
                        tr.style.color = 'red';
                        tr.style.fontWeight = 'bold';
                    }
                    
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
                document.getElementById('totalVentas').textContent = '$' + parseFloat(data.total_ventas_caja || 0).toLocaleString();
                document.getElementById('totalTransferencias').textContent = '$' + parseFloat(data.ingresos_transferencias || 0).toLocaleString();
                document.getElementById('totalIngresos').textContent = '$' + parseFloat(data.total_ingresos || 0).toLocaleString();
                
                const egresos = parseFloat(data.total_egresos || 0);
                const egresosElement = document.getElementById('totalEgresos');
                if(egresos > 0) {
                    egresosElement.textContent = '-$' + egresos.toLocaleString();
                } else {
                    egresosElement.textContent = '$0';
                }
                
                document.getElementById('totalCaja').textContent = '$' + parseFloat(data.total_actual || 0).toLocaleString();
            });
    }
    
    function verDetallesCaja(cajaId) {
        // Mostrar modal de carga
        const loadingModal = document.getElementById('loadingModal');
        loadingModal.classList.remove('hide');
        loadingModal.classList.add('show');
        
        fetch(`<?= BASE_URL ?>caja/getResumenCaja/${cajaId}`)
            .then(response => response.text())
            .then(text => {
                try {
                    const data = JSON.parse(text);
                    
                    const contenido = `
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Información General</h6>
                                <table class="table table-sm">
                                    <tr><td><strong>Fecha Apertura:</strong></td><td>${new Date(data.fecha_apertura).toLocaleString('es-CO')}</td></tr>
                                    <tr><td><strong>Fecha Cierre:</strong></td><td>${data.fecha_cierre ? new Date(data.fecha_cierre).toLocaleString('es-CO') : 'N/A'}</td></tr>
                                    <tr><td><strong>Usuario:</strong></td><td>${data.usuario_nombre}</td></tr>
                                    <tr><td><strong>Monto Inicial:</strong></td><td>$${parseFloat(data.monto_inicial || 0).toLocaleString()}</td></tr>
                                    <tr><td><strong>Monto Final:</strong></td><td>$${parseFloat(data.monto_final || 0).toLocaleString()}</td></tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h6>Resumen de Ventas</h6>
                                <table class="table table-sm">
                                    <tr><td><strong>Total Ventas:</strong></td><td>$${parseFloat(data.total_ventas_caja || 0).toLocaleString()}</td></tr>
                                    <tr><td><strong>Efectivo:</strong></td><td>$${parseFloat(data.efectivo_ventas || 0).toLocaleString()}</td></tr>
                                    <tr><td><strong>Tarjeta:</strong></td><td>$${parseFloat(data.tarjeta_ventas || 0).toLocaleString()}</td></tr>
                                    <tr><td><strong>Transferencia:</strong></td><td>$${parseFloat(data.transferencia_ventas || 0).toLocaleString()}</td></tr>
                                    <tr><td><strong>Ingresos Extra:</strong></td><td>$${parseFloat(data.total_ingresos || 0).toLocaleString()}</td></tr>
                                    <tr><td><strong>Egresos:</strong></td><td>$${parseFloat(data.total_egresos || 0).toLocaleString()}</td></tr>
                                </table>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <h6>Cálculo Final</h6>
                                    <p><strong>Esperado en Caja:</strong> $${(parseFloat(data.monto_inicial || 0) + parseFloat(data.total_ventas_caja || 0) + parseFloat(data.total_ingresos || 0) - parseFloat(data.total_egresos || 0)).toLocaleString()}</p>
                                    <p><strong>Real en Caja:</strong> $${parseFloat(data.monto_final || 0).toLocaleString()}</p>
                                    <p><strong>Diferencia:</strong> <span class="${(parseFloat(data.monto_final || 0) - (parseFloat(data.monto_inicial || 0) + parseFloat(data.total_ventas_caja || 0) + parseFloat(data.total_ingresos || 0) - parseFloat(data.total_egresos || 0))) == 0 ? 'text-success' : 'text-danger'}">$${(parseFloat(data.monto_final || 0) - (parseFloat(data.monto_inicial || 0) + parseFloat(data.total_ventas_caja || 0) + parseFloat(data.total_ingresos || 0) - parseFloat(data.total_egresos || 0))).toLocaleString()}</span></p>
                                </div>
                            </div>
                        </div>
                        ${data.observaciones ? `<div class="row"><div class="col-12"><h6>Observaciones</h6><p>${data.observaciones}</p></div></div>` : ''}
                    `;
                    
                    document.getElementById('contenidoDetallesCaja').innerHTML = contenido;
                    
                    // Ocultar modal de carga
                    loadingModal.classList.remove('show');
                    loadingModal.classList.add('hide');
                    
                    const modal = new bootstrap.Modal(document.getElementById('modalDetallesCaja'), {
                        backdrop: 'static',
                        keyboard: false
                    });
                    modal.show();
                } catch (e) {
                    console.error('Error al cargar detalles:', text);
                    
                    // Ocultar modal de carga
                    loadingModal.classList.remove('show');
                    loadingModal.classList.add('hide');
                    
                    Swal.fire('Error', 'No se pudieron cargar los detalles de la caja', 'error');
                }
            });
    }
    
    function generarReporte(cajaId) {
        window.open(`<?= BASE_URL ?>caja/reporteCaja/${cajaId}`, '_blank');
    }
    
    function mostrarResumenVisual() {
        if(!cajaId) {
            Swal.fire('Info', 'No hay caja abierta para mostrar resumen', 'info');
            return;
        }
        
        fetch(`<?= BASE_URL ?>caja/getResumenCaja/${cajaId}`)
            .then(response => response.json())
            .then(data => {
                const enCaja = parseFloat(data.total_actual || 0);
                const transferencias = parseFloat(data.ingresos_transferencias || 0);
                const ingresos = parseFloat(data.total_ingresos || 0);
                const egresos = parseFloat(data.total_egresos || 0);
                const totalGeneral = enCaja;
                
                document.getElementById('resumenTransferencias').textContent = '$' + transferencias.toLocaleString();
                document.getElementById('resumenIngresos').textContent = '$' + ingresos.toLocaleString();
                
                const egresosElement = document.getElementById('resumenEgresos');
                if(egresos > 0) {
                    egresosElement.textContent = '-$' + egresos.toLocaleString();
                    egresosElement.style.color = 'red';
                } else {
                    egresosElement.textContent = '$0';
                    egresosElement.style.color = '';
                }
                
                document.getElementById('resumenTotal').textContent = '$' + totalGeneral.toLocaleString();
                
                document.getElementById('resumenVisual').style.display = 'block';
                crearGraficoIngresos(data);
            });
    }
    
    function crearGraficoIngresos(data) {
        const ctx = document.getElementById('graficoIngresos').getContext('2d');
        
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Monto Inicial', 'Ventas', 'Ingresos Extra', 'Egresos'],
                datasets: [{
                    data: [
                        parseFloat(data.monto_inicial || 0),
                        parseFloat(data.total_ventas_caja || 0),
                        parseFloat(data.total_ingresos || 0),
                        parseFloat(data.total_egresos || 0)
                    ],
                    backgroundColor: ['#6c757d', '#007bff', '#28a745', '#dc3545']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' },
                    title: { display: true, text: 'Composición del Total General' }
                }
            }
        });
    }
    
    function cancelarVenta() {
        const form = document.getElementById('formCancelarVenta');
        if(!form.checkValidity()) {
            form.classList.add('was-validated');
            return;
        }
        
        const formData = new FormData(form);
        
        Swal.fire({
            title: '¿Cancelar venta?',
            text: 'Esta acción registrará la cancelación en el historial',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, cancelar venta',
            cancelButtonText: 'No cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('<?= BASE_URL ?>caja/cancelarVenta', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if(data.status) {
                        Swal.fire('Éxito', data.msg, 'success');
                        const modal = bootstrap.Modal.getInstance(document.getElementById('modalCancelarVenta'));
                        modal.hide();
                        form.reset();
                        actualizarResumen();
                    } else {
                        Swal.fire('Error', data.msg, 'error');
                    }
                });
            }
        });
    }
    
    function guardarProductoTemporal() {
        const form = document.getElementById('formProductoTemporal');
        if(!form.checkValidity()) {
            form.classList.add('was-validated');
            return;
        }
        
        const formData = new FormData(form);
        
        fetch('<?= BASE_URL ?>caja/agregarProductoTemporal', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if(data.status) {
                Swal.fire('Éxito', data.msg, 'success');
                const modal = bootstrap.Modal.getInstance(document.getElementById('modalProductoTemporal'));
                modal.hide();
                form.reset();
                
                window.location.href = '<?= BASE_URL ?>pos?producto_temporal=' + data.id;
            } else {
                Swal.fire('Error', data.msg, 'error');
            }
        });
    }
</script>

<!-- Chart.js para gráficos -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>