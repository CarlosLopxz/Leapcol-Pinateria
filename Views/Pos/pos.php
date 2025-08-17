<?php headerAdmin($data); ?>

<div class="d2c_main px-0 px-md-2 py-4">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-0 text-capitalize">Punto de Venta</h4>
                <p class="text-muted">Registra ventas y genera tickets</p>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-warning btn-sm" id="btnProductoNoInventariadoHeader">
                    <i class="fas fa-plus-circle me-1"></i>Producto No Inventariado
                </button>
            </div>
        </div>
        
        <!-- Tarjetas de Estado de Caja -->
        <div class="row mb-4">
            <?php if($data['cajaAbierta']): ?>
            <div class="col-md-2">
                <div class="card bg-light border-0 shadow-sm">
                    <div class="card-body p-2 text-center">
                        <small class="text-muted">En Caja</small>
                        <h6 class="mb-0 text-dark" id="montoCajaHeader">$<?= number_format($data['cajaAbierta']['total_actual'] ?? 0, 0) ?></h6>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card bg-white border-1 shadow-sm">
                    <div class="card-body p-2 text-center">
                        <small class="text-muted">Transferencias</small>
                        <h6 class="mb-0 text-dark" id="montoTransferenciasHeader">$0</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card bg-light border-0 shadow-sm">
                    <div class="card-body p-2 text-center">
                        <small class="text-muted">Ingresos</small>
                        <h6 class="mb-0 text-dark" id="montoIngresosHeader">$0</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card bg-white border-1 shadow-sm">
                    <div class="card-body p-2 text-center">
                        <small class="text-muted">Egresos</small>
                        <h6 class="mb-0 text-dark" id="montoEgresosHeader">$0</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card bg-light border-0 shadow-sm">
                    <div class="card-body p-2 text-center">
                        <small class="text-muted">Ventas</small>
                        <h6 class="mb-0 text-dark" id="montoVentasHeader">$<?= number_format($data['cajaAbierta']['total_ventas'] ?? 0, 0) ?></h6>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <button class="btn btn-danger w-100" id="btnCerrarCajaHeader">
                    <i class="fas fa-lock me-2"></i>Cerrar Caja
                </button>
            </div>
            <?php else: ?>
            <div class="col-md-8">
                <div class="card bg-secondary text-white">
                    <div class="card-body p-3 text-center">
                        <h5 class="mb-0">CAJA CERRADA</h5>
                        <small>Debe abrir la caja para comenzar a trabajar</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <button class="btn btn-success w-100" id="btnAbrirCajaHeader">
                    <i class="fas fa-cash-register me-2"></i>Abrir Caja
                </button>
            </div>
            <?php endif; ?>
        </div>
        


        <div class="row">
            <div class="col-lg-8">
                <!-- Búsqueda de productos -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="position-relative">
                            <div class="input-group">
                                <input type="text" id="buscarProducto" class="form-control" placeholder="Buscar producto por código o nombre...">
                                <span class="input-group-text">
                                    <i class="fas fa-search"></i>
                                </span>
                            </div>
                            <!-- Dropdown de productos filtrados -->
                            <div id="dropdownProductos" class="card position-absolute w-100" style="display: none; z-index: 1000; max-height: 300px; overflow-y: auto; top: 100%; margin-top: 2px; background-color: #efefef;">
                                <div class="card-body p-2">
                                    <div id="listaProductosFiltrados"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Carrito -->
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">Carrito de Venta</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped" id="tablaCarrito">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th width="100">Cantidad</th>
                                        <th width="100">Precio</th>
                                        <th width="100">Mano Obra</th>
                                        <th width="120">Subtotal</th>
                                        <th width="50">Acción</th>
                                    </tr>
                                </thead>
                                <tbody id="carritoItems">
                                    <tr id="carritoVacio">
                                        <td colspan="6" class="text-center">No hay productos en el carrito</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Cliente -->
                <div class="card mb-4">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">Cliente</h5>
                    </div>
                    <div class="card-body">
                        <select class="form-select" id="clienteSelect">
                            <option value="0">Cliente General</option>
                        </select>
                    </div>
                </div>

                <!-- Resumen -->
                <div class="card mb-4">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">Resumen de Venta</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Subtotal:</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="text" class="form-control" id="subtotal" readonly value="0">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Descuento:</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="descuento" value="0" min="0">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">TOTAL:</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="text" class="form-control form-control-lg fw-bold" id="total" readonly value="0">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pago -->
                <div class="card mb-4">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">Método de Pago</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Destino del dinero:</label>
                            <select class="form-select" id="destinoCaja">
                                <option value="general">Caja General</option>
                                <option value="creacion">Caja Creación</option>
                            </select>
                        </div>
                        
                        <select class="form-select mb-3" id="metodoPago">
                            <option value="1">Efectivo</option>
                            <option value="2">Tarjeta de Crédito</option>
                            <option value="3">Tarjeta de Débito</option>
                            <option value="4">Transferencia</option>
                        </select>
                        
                        <div class="mb-3" id="pagoEfectivoContainer">
                            <label class="form-label">Paga con:</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="pagaCon" min="0">
                            </div>
                        </div>
                        
                        <div class="mb-3" id="cambioContainer" style="display: none;">
                            <label class="form-label fw-bold">Cambio:</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="text" class="form-control form-control-lg fw-bold text-success" id="cambio" readonly>
                            </div>
                        </div>
                    </div>
                </div>


                


                <!-- Botones Principales -->
                <div class="d-grid gap-2">
                    <button class="btn btn-primary btn-lg" id="btnProcesarVenta">
                        <i class="fas fa-cash-register me-2"></i>Procesar Venta
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Producto No Inventariado -->
<div class="modal fade" id="modalProductoNoInventariado" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title">Agregar Producto No Inventariado</h5>
                <button type="button" class="btn-close" onclick="cerrarModalManual()"></button>
            </div>
            <div class="modal-body">
                <form id="formProductoNoInventariado">
                    <div class="mb-3">
                        <label for="nombreProductoNoInv" class="form-label">Nombre del Producto <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nombreProductoNoInv" name="nombre" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="precioProductoNoInv" class="form-label">Precio <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" class="form-control" id="precioProductoNoInv" name="precio" min="0" step="0.01" required>
                        </div>
                    </div>
                    

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="cerrarModalManual()">Cancelar</button>
                <button type="button" class="btn btn-warning" id="btnAgregarProductoNoInv">Agregar al Carrito</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Cancelar Venta -->
<div class="modal fade" id="modalCancelarVentaPos" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Cancelar Venta Existente</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formCancelarVentaPos">
                    <div class="mb-3">
                        <label for="ventaIdCancelarPos" class="form-label">ID de Venta <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="ventaIdCancelarPos" name="ventaId" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="motivoCancelacionPos" class="form-label">Motivo de Cancelación</label>
                        <textarea class="form-control" id="motivoCancelacionPos" name="motivo" rows="3"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="ajusteCajaPos" name="ajusteCaja">
                            <label class="form-check-label" for="ajusteCajaPos">
                                Ajustar efectivo en caja (devolver dinero al cliente)
                            </label>
                        </div>
                    </div>
                    
                    <div class="mb-3" id="montoDevolucionContainerPos" style="display: none;">
                        <label for="montoDevueltoPos" class="form-label">Monto a Devolver</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" class="form-control" id="montoDevueltoPos" name="montoDevuelto" min="0" step="0.01">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-danger" id="btnConfirmarCancelacionPos">Cancelar Venta</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Movimiento Caja -->
<div class="modal fade" id="modalMovimientoCaja" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" id="headerMovimientoCaja">
                <h5 class="modal-title" id="tituloMovimientoCaja">Registrar Movimiento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formMovimientoCaja">
                    <input type="hidden" id="tipoMovimientoCaja" name="tipo">
                    
                    <div class="mb-3">
                        <label for="conceptoCaja" class="form-label">Concepto <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="conceptoCaja" name="concepto" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="montoCaja" class="form-label">Monto <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" class="form-control" id="montoCaja" name="monto" min="0" step="0.01" required>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnGuardarMovimientoCaja">Guardar</button>
            </div>
        </div>
    </div>
</div>

<?php footerAdmin($data); ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
let productos = [];
let carrito = [];

function formatoPrecioCOP(precio) {
    return '$' + parseFloat(precio).toLocaleString('es-CO', {
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    });
}

document.addEventListener('DOMContentLoaded', function() {
    cargarClientes();
    cargarProductos();
    actualizarTarjetasCaja();
    
    const inputBuscar = document.getElementById('buscarProducto');
    inputBuscar.addEventListener('input', filtrarProductos);
    inputBuscar.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            buscarProductoDirecto();
        }
    });
    inputBuscar.addEventListener('blur', function() {
        setTimeout(() => {
            document.getElementById('dropdownProductos').style.display = 'none';
        }, 200);
    });
    
    document.getElementById('btnProcesarVenta').addEventListener('click', procesarVenta);

    document.getElementById('btnProductoNoInventariadoHeader').addEventListener('click', function() {
        const modalElement = document.getElementById('modalProductoNoInventariado');
        modalElement.style.display = 'block';
        modalElement.classList.add('show');
        document.body.classList.add('modal-open');
        
        // Crear backdrop manualmente
        const backdrop = document.createElement('div');
        backdrop.className = 'modal-backdrop fade show';
        backdrop.id = 'modal-backdrop-temp';
        document.body.appendChild(backdrop);
        
        // Cerrar al hacer click en backdrop
        backdrop.addEventListener('click', cerrarModalManual);
    });
    
    document.getElementById('btnAbrirCajaHeader')?.addEventListener('click', function() {
        mostrarModalAbrirCaja();
    });
    
    document.getElementById('btnCerrarCajaHeader')?.addEventListener('click', function() {
        mostrarModalCerrarCaja();
    });
    document.getElementById('btnAgregarProductoNoInv').addEventListener('click', agregarProductoNoInventariado);
    document.getElementById('btnConfirmarCancelacionPos').addEventListener('click', cancelarVentaExistente);
    document.getElementById('btnGuardarMovimientoCaja').addEventListener('click', guardarMovimientoCaja);
    document.getElementById('ajusteCajaPos').addEventListener('change', function() {
        const container = document.getElementById('montoDevolucionContainerPos');
        container.style.display = this.checked ? 'block' : 'none';
    });
    document.getElementById('descuento').addEventListener('input', calcularTotales);
    document.getElementById('metodoPago').addEventListener('change', manejarMetodoPago);
    document.getElementById('pagaCon').addEventListener('input', calcularCambio);
    document.getElementById('destinoCaja').addEventListener('change', actualizarListaClientes);
});

let todosLosClientes = [];

function cargarClientes() {
    fetch('<?= BASE_URL ?>pos/getClientes')
        .then(response => response.json())
        .then(data => {
            todosLosClientes = data;
            actualizarListaClientes();
        });
}

function actualizarListaClientes() {
    const select = document.getElementById('clienteSelect');
    const destinoCaja = document.getElementById('destinoCaja').value;
    
    // Limpiar opciones existentes excepto Cliente General
    select.innerHTML = '<option value="0">Cliente General</option>';
    
    todosLosClientes.forEach(cliente => {
        // Si destino es creación, no mostrar Cliente Chela
        if(destinoCaja === 'creacion' && cliente.nombre.includes('Cliente Chela')) {
            return;
        }
        
        const option = document.createElement('option');
        option.value = cliente.id;
        option.textContent = cliente.nombre;
        select.appendChild(option);
    });
}

function cargarProductos() {
    fetch('<?= BASE_URL ?>pos/getProductos')
        .then(response => response.json())
        .then(data => {
            productos = data;
        });
}

function filtrarProductos() {
    const busqueda = document.getElementById('buscarProducto').value.trim().toLowerCase();
    const dropdown = document.getElementById('dropdownProductos');
    const lista = document.getElementById('listaProductosFiltrados');
    
    if (!busqueda || busqueda.length < 2) {
        dropdown.style.display = 'none';
        return;
    }
    
    const productosFiltrados = productos.filter(p => 
        p.codigo.toLowerCase().includes(busqueda) || 
        p.nombre.toLowerCase().includes(busqueda)
    ).slice(0, 10); // Limitar a 10 resultados
    
    if (productosFiltrados.length === 0) {
        lista.innerHTML = '<div class="text-center text-muted py-2">No se encontraron productos</div>';
        dropdown.style.display = 'block';
        return;
    }
    
    lista.innerHTML = '';
    productosFiltrados.forEach(producto => {
        const stockDisponible = producto.stock;
        const item = document.createElement('div');
        item.className = 'border-bottom py-2 px-2 producto-item';
        item.style.cursor = stockDisponible > 0 ? 'pointer' : 'not-allowed';
        item.style.opacity = stockDisponible > 0 ? '1' : '0.5';
        
        item.innerHTML = `
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <strong>${producto.nombre}</strong><br>
                    <small class="text-muted">Código: ${producto.codigo} | Stock: ${stockDisponible}</small>
                    ${producto.mano_obra > 0 ? `<br><small class="text-info">Mano de obra: ${formatoPrecioCOP(producto.mano_obra)}</small>` : ''}
                </div>
                <div class="text-end">
                    <span class="fw-bold">${formatoPrecioCOP(parseFloat(producto.precio_venta) + parseFloat(producto.mano_obra || 0))}</span>
                </div>
            </div>
        `;
        
        if (stockDisponible > 0) {
            item.addEventListener('click', function() {
                agregarAlCarrito(producto.id, 1);
                document.getElementById('buscarProducto').value = '';
                dropdown.style.display = 'none';
            });
            
            item.addEventListener('mouseenter', function() {
                this.style.backgroundColor = '#d4d4d4';
            });
            
            item.addEventListener('mouseleave', function() {
                this.style.backgroundColor = 'transparent';
            });
        }
        
        lista.appendChild(item);
    });
    
    dropdown.style.display = 'block';
}

function buscarProductoDirecto() {
    const busqueda = document.getElementById('buscarProducto').value.trim().toLowerCase();
    if (!busqueda) return;
    
    const producto = productos.find(p => 
        p.codigo.toLowerCase() === busqueda
    );
    
    if (producto && producto.stock > 0) {
        agregarAlCarrito(producto.id, 1);
        document.getElementById('buscarProducto').value = '';
        document.getElementById('dropdownProductos').style.display = 'none';
    }
}

function agregarAlCarrito(productoId, cantidad) {
    const producto = productos.find(p => p.id === productoId);
    if (!producto || producto.stock <= 0) return;
    
    const precioTotal = parseFloat(producto.precio_venta) + parseFloat(producto.mano_obra || 0);
    const index = carrito.findIndex(item => item.id === productoId);
    
    if (index !== -1) {
        const nuevaCantidad = carrito[index].cantidad + cantidad;
        if (nuevaCantidad > producto.stock) {
            Swal.fire('Error', `Stock insuficiente. Disponible: ${producto.stock}`, 'error');
            return;
        }
        carrito[index].cantidad = nuevaCantidad;
        carrito[index].subtotal = carrito[index].cantidad * precioTotal;
    } else {
        if (cantidad > producto.stock) {
            Swal.fire('Error', `Stock insuficiente. Disponible: ${producto.stock}`, 'error');
            return;
        }
        carrito.push({
            id: producto.id,
            codigo: producto.codigo,
            nombre: producto.nombre,
            precio: producto.precio_venta,
            manoObra: producto.mano_obra || 0,
            precioTotal: precioTotal,
            cantidad: cantidad,
            subtotal: cantidad * precioTotal
        });
    }
    
    actualizarTablaCarrito();
    calcularTotales();
    
    // Mostrar notificación sin cerrar modal
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true
    });
    
    Toast.fire({
        icon: 'success',
        title: `${producto.nombre} agregado`
    });
}

function actualizarTablaCarrito() {
    const tbody = document.getElementById('carritoItems');
    tbody.innerHTML = '';
    
    if (carrito.length === 0) {
        tbody.innerHTML = '<tr><td colspan="6" class="text-center">No hay productos en el carrito</td></tr>';
        return;
    }
    
    carrito.forEach((item, index) => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td><strong>${item.nombre}</strong><br><small>Código: ${item.codigo}</small></td>
            <td>
                <div class="input-group input-group-sm" style="width:100px;">
                    <button class="btn btn-outline-secondary" onclick="cambiarCantidad(${index}, -1)">-</button>
                    <input type="text" class="form-control text-center" value="${item.cantidad}" readonly>
                    <button class="btn btn-outline-secondary" onclick="cambiarCantidad(${index}, 1)">+</button>
                </div>
            </td>
            <td class="text-end">${formatoPrecioCOP(item.precio)}</td>
            <td class="text-end">${item.manoObra > 0 ? formatoPrecioCOP(item.manoObra) : '-'}</td>
            <td class="text-end">${formatoPrecioCOP(item.subtotal)}</td>
            <td class="text-center">
                <button class="btn btn-sm btn-danger" onclick="eliminarDelCarrito(${index})">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        `;
        tbody.appendChild(tr);
    });
}

function cambiarCantidad(index, cambio) {
    const nuevaCantidad = carrito[index].cantidad + cambio;
    if (nuevaCantidad <= 0) {
        eliminarDelCarrito(index);
        return;
    }
    
    // Verificar stock disponible
    const producto = productos.find(p => p.id === carrito[index].id);
    if (producto && nuevaCantidad > producto.stock) {
        Swal.fire('Error', `Stock insuficiente. Disponible: ${producto.stock}`, 'error');
        return;
    }
    
    carrito[index].cantidad = nuevaCantidad;
    carrito[index].subtotal = nuevaCantidad * carrito[index].precioTotal;
    actualizarTablaCarrito();
    calcularTotales();
}

function eliminarDelCarrito(index) {
    carrito.splice(index, 1);
    actualizarTablaCarrito();
    calcularTotales();
}

function calcularTotales() {
    const subtotal = carrito.reduce((sum, item) => sum + item.subtotal, 0);
    const descuento = parseFloat(document.getElementById('descuento').value) || 0;
    const total = subtotal - descuento;
    
    document.getElementById('subtotal').value = subtotal.toFixed(0);
    document.getElementById('total').value = total.toFixed(0);
}

function manejarMetodoPago() {
    const metodoPago = document.getElementById('metodoPago').value;
    const container = document.getElementById('pagoEfectivoContainer');
    const cambioContainer = document.getElementById('cambioContainer');
    
    if(metodoPago === '1') {
        container.style.display = 'block';
    } else {
        container.style.display = 'none';
        cambioContainer.style.display = 'none';
        document.getElementById('pagaCon').value = '';
        document.getElementById('cambio').value = '';
    }
}

function calcularCambio() {
    const total = parseFloat(document.getElementById('total').value) || 0;
    const pagaCon = parseFloat(document.getElementById('pagaCon').value) || 0;
    const cambioContainer = document.getElementById('cambioContainer');
    const cambioInput = document.getElementById('cambio');
    
    if(pagaCon > 0 && total > 0) {
        const cambio = pagaCon - total;
        cambioInput.value = cambio.toFixed(0);
        cambioContainer.style.display = 'block';
    } else {
        cambioContainer.style.display = 'none';
    }
}

function procesarVenta() {
    if (carrito.length === 0) {
        Swal.fire('Error', 'No hay productos en el carrito', 'error');
        return;
    }
    
    <?php if(!isset($data['cajaAbierta']) || !$data['cajaAbierta']): ?>
    Swal.fire({
        title: '¿Continuar sin caja abierta?',
        text: 'No tienes una caja abierta. La venta se registrará pero no se contabilizará en caja.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Continuar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            ejecutarVenta();
        }
    });
    return;
    <?php endif; ?>
    
    ejecutarVenta();
}

function ejecutarVenta() {
    

    
    const metodoSeleccionado = document.getElementById('metodoPago').value;
    if(metodoSeleccionado === '1') {
        const totalVenta = parseFloat(document.getElementById('total').value);
        const pagaCon = parseFloat(document.getElementById('pagaCon').value) || 0;
        
        if(pagaCon < totalVenta) {
            Swal.fire('Error', 'El monto a pagar es insuficiente', 'error');
            return;
        }
    }
    
    const formData = new FormData();
    const destinoCaja = document.getElementById('destinoCaja').value;
    let clienteId = document.getElementById('clienteSelect').value;
    
    // Si el destino es creación, usar el cliente especial de creación
    if(destinoCaja === 'creacion') {
        clienteId = 'creacion';
    }
    
    formData.append('cliente', clienteId);
    formData.append('subtotal', document.getElementById('subtotal').value);
    formData.append('impuestos', 0);
    formData.append('descuentos', document.getElementById('descuento').value || 0);
    formData.append('total', document.getElementById('total').value);
    formData.append('metodo_pago', document.getElementById('metodoPago').value);
    formData.append('observaciones', '');
    formData.append('destino_caja', destinoCaja);
    formData.append('productos', JSON.stringify(carrito.map(item => ({
        id: item.id,
        cantidad: item.cantidad,
        precio: item.precio,
        subtotal: item.subtotal
    }))));
    
    if(metodoSeleccionado === '1') {
        formData.append('pagoCon', document.getElementById('pagaCon').value || 0);
        formData.append('cambio', document.getElementById('cambio').value || 0);
    }
    
    Swal.fire({
        title: 'Procesando venta',
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading()
    });
    
    fetch('<?= BASE_URL ?>pos/procesarVenta', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        Swal.close();
        if (data.status) {
            // Actualizar stock localmente
            carrito.forEach(item => {
                const producto = productos.find(p => p.id === item.id);
                if (producto) {
                    producto.stock -= item.cantidad;
                }
            });
            
            Swal.fire({
                icon: 'success',
                title: '¡Venta Realizada!',
                text: `Venta #${data.idVenta} registrada correctamente`,
                showCancelButton: true,
                confirmButtonText: 'Imprimir Ticket',
                cancelButtonText: 'Cerrar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.open(`<?= BASE_URL ?>pos/imprimirTicket/${data.idVenta}`, '_blank');
                }
                limpiarVenta();
            });
        } else {
            Swal.fire('Error', data.msg, 'error');
        }
    })
    .catch(error => {
        Swal.close();
        Swal.fire('Error', 'Ocurrió un error al procesar la venta', 'error');
    });
}



function agregarProductoNoInventariado() {
    const form = document.getElementById('formProductoNoInventariado');
    if(!form.checkValidity()) {
        form.classList.add('was-validated');
        return;
    }
    
    const nombre = document.getElementById('nombreProductoNoInv').value;
    const precio = parseFloat(document.getElementById('precioProductoNoInv').value);
    
    if(!nombre || precio <= 0) {
        Swal.fire('Error', 'Nombre y precio son requeridos', 'error');
        return;
    }
    
    // Agregar directamente al carrito sin llamada al servidor
    const numeroTemp = Math.floor(Math.random() * 9000) + 1000;
    const productoTemporal = {
        id: 'temp_' + Date.now(),
        codigo: 'TEMP' + numeroTemp,
        nombre: nombre,
        precio: precio,
        manoObra: 0,
        precioTotal: precio,
        cantidad: 1,
        subtotal: precio,
        temporal: true
    };
    
    carrito.push(productoTemporal);
    actualizarTablaCarrito();
    calcularTotales();
    
    // Cerrar modal
    cerrarModalManual();
    
    form.reset();
    
    // Toast en esquina superior derecha
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true
    });
    
    Toast.fire({
        icon: 'success',
        title: `${nombre} agregado`
    });
}

function cancelarVentaExistente() {
    const form = document.getElementById('formCancelarVentaPos');
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
            fetch('<?= BASE_URL ?>pos/cancelarVenta', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if(data.status) {
                    Swal.fire('Éxito', data.msg, 'success');
                    const modal = bootstrap.Modal.getInstance(document.getElementById('modalCancelarVentaPos'));
                    modal.hide();
                    form.reset();
                } else {
                    Swal.fire('Error', data.msg, 'error');
                }
            });
        }
    });
}

function abrirModalMovimientoCaja(tipo, titulo, clase) {
    document.getElementById('tipoMovimientoCaja').value = tipo;
    document.getElementById('tituloMovimientoCaja').textContent = titulo;
    document.getElementById('headerMovimientoCaja').className = 'modal-header ' + clase;
    document.getElementById('formMovimientoCaja').reset();
    document.getElementById('tipoMovimientoCaja').value = tipo;
    
    const modal = new bootstrap.Modal(document.getElementById('modalMovimientoCaja'));
    modal.show();
}

function guardarMovimientoCaja() {
    const form = document.getElementById('formMovimientoCaja');
    if(!form.checkValidity()) {
        form.classList.add('was-validated');
        return;
    }
    
    const formData = new FormData(form);
    formData.append('cajaId', <?= $data['cajaAbierta']['id'] ?? 'null' ?>);
    formData.append('metodoPago', 1); // Efectivo por defecto
    
    fetch('<?= BASE_URL ?>caja/registrarMovimiento', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.status) {
            Swal.fire('Éxito', data.msg, 'success');
            const modal = bootstrap.Modal.getInstance(document.getElementById('modalMovimientoCaja'));
            modal.hide();
        } else {
            Swal.fire('Error', data.msg, 'error');
        }
    });
}



function limpiarVenta() {
    carrito = [];
    actualizarTablaCarrito();
    document.getElementById('clienteSelect').value = 0;
    document.getElementById('subtotal').value = 0;
    document.getElementById('descuento').value = 0;
    document.getElementById('total').value = 0;
    document.getElementById('metodoPago').value = 1;
    document.getElementById('destinoCaja').value = 'general';
    document.getElementById('pagaCon').value = '';
    document.getElementById('cambio').value = '';
    document.getElementById('pagoEfectivoContainer').style.display = 'block';
    document.getElementById('cambioContainer').style.display = 'none';
}

function cerrarModalManual() {
    const modalElement = document.getElementById('modalProductoNoInventariado');
    modalElement.style.display = 'none';
    modalElement.classList.remove('show');
    document.body.classList.remove('modal-open');
    
    const backdrop = document.getElementById('modal-backdrop-temp');
    if(backdrop) backdrop.remove();
}

function mostrarModalCerrarCaja() {
    <?php if($data['cajaAbierta']): ?>
    fetch(`<?= BASE_URL ?>caja/getResumenCaja/<?= $data['cajaAbierta']['id'] ?>`)
        .then(response => response.json())
        .then(data => {
            const enCaja = parseFloat(data.efectivo_disponible || 0);
            const transferencias = parseFloat(data.ingresos_transferencias || 0);
            const ingresos = parseFloat(data.total_ingresos || 0);
            const ventas = parseFloat(data.total_ventas_caja || 0);
            const totalGeneral = enCaja;
            
            Swal.fire({
                title: 'Cerrar Caja',
                html: `
                    <div class="text-start">
                        <h6>Resumen de Caja:</h6>
                        <div class="row mb-2">
                            <div class="col-6"><strong>Transferencias:</strong></div>
                            <div class="col-6">$${transferencias.toLocaleString()}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6"><strong>Ingresos:</strong></div>
                            <div class="col-6">$${ingresos.toLocaleString()}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6"><strong>Egresos:</strong></div>
                            <div class="col-6" style="color: ${parseFloat(data.total_egresos || 0) > 0 ? 'red' : ''}">${parseFloat(data.total_egresos || 0) > 0 ? '-$' + parseFloat(data.total_egresos || 0).toLocaleString() : '$0'}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6"><strong>Ventas:</strong></div>
                            <div class="col-6">$${ventas.toLocaleString()}</div>
                        </div>
                        <hr>
                        <div class="row mb-3">
                            <div class="col-6"><strong>TOTAL GENERAL:</strong></div>
                            <div class="col-6"><strong>$${totalGeneral.toLocaleString()}</strong></div>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <label class="form-label">Monto Final en Caja:</label>
                            <input type="number" id="montoFinalCierre" class="form-control" placeholder="Ingrese el dinero físico" step="0.01">
                        </div>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Cerrar Caja',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#dc3545',
                preConfirm: () => {
                    const montoFinal = document.getElementById('montoFinalCierre').value;
                    if (!montoFinal || parseFloat(montoFinal) < 0) {
                        Swal.showValidationMessage('Debe ingresar un monto válido');
                        return false;
                    }
                    return parseFloat(montoFinal);
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    cerrarCajaConfirmado(result.value);
                }
            });
        });
    <?php endif; ?>
}

function cerrarCajaConfirmado(montoFinal) {
    const formData = new FormData();
    formData.append('cajaId', <?= $data['cajaAbierta']['id'] ?? 'null' ?>);
    formData.append('montoFinal', montoFinal);
    formData.append('observaciones', 'Cerrado desde POS');
    
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

function actualizarTarjetasCaja() {
    <?php if($data['cajaAbierta']): ?>
    fetch(`<?= BASE_URL ?>caja/getResumenCaja/<?= $data['cajaAbierta']['id'] ?>`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('montoCajaHeader').textContent = '$' + parseFloat(data.total_actual || 0).toLocaleString();
            document.getElementById('montoTransferenciasHeader').textContent = '$' + parseFloat(data.ingresos_transferencias || 0).toLocaleString();
            document.getElementById('montoIngresosHeader').textContent = '$' + parseFloat(data.total_ingresos || 0).toLocaleString();
            
            const egresos = parseFloat(data.total_egresos || 0);
            const egresosElement = document.getElementById('montoEgresosHeader');
            if(egresos > 0) {
                egresosElement.textContent = '-$' + egresos.toLocaleString();
                egresosElement.style.color = 'red';
            } else {
                egresosElement.textContent = '$0';
                egresosElement.style.color = '';
            }
            
            document.getElementById('montoVentasHeader').textContent = '$' + parseFloat(data.total_ventas_caja || 0).toLocaleString();
        });
    <?php endif; ?>
}

function mostrarModalAbrirCaja() {
    Swal.fire({
        title: 'Abrir Caja',
        html: `
            <div class="text-start">
                <div class="mb-3">
                    <label class="form-label">Monto Inicial:</label>
                    <input type="number" id="montoInicialApertura" class="form-control" placeholder="Ingrese el monto inicial" step="0.01" min="0">
                </div>
                <div class="mb-3">
                    <label class="form-label">Observaciones:</label>
                    <textarea id="observacionesApertura" class="form-control" rows="3" placeholder="Observaciones opcionales"></textarea>
                </div>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Abrir Caja',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#28a745',
        preConfirm: () => {
            const montoInicial = document.getElementById('montoInicialApertura').value;
            if (!montoInicial || parseFloat(montoInicial) < 0) {
                Swal.showValidationMessage('Debe ingresar un monto inicial válido');
                return false;
            }
            return {
                monto: parseFloat(montoInicial),
                observaciones: document.getElementById('observacionesApertura').value
            };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            abrirCajaConfirmado(result.value.monto, result.value.observaciones);
        }
    });
}

function abrirCajaConfirmado(montoInicial, observaciones) {
    const formData = new FormData();
    formData.append('montoInicial', montoInicial);
    formData.append('observaciones', observaciones);
    
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
</script>