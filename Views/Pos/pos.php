<?php headerAdmin($data); ?>

<div class="d2c_main px-0 px-md-2 py-4">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-0 text-capitalize">Punto de Venta</h4>
                <p class="text-muted">Registra ventas y genera tickets</p>
            </div>
        </div>
        
        <?php if(!isset($data['cajaAbierta']) || !$data['cajaAbierta']): ?>
        <div class="alert alert-warning mb-4">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Atención:</strong> No tienes una caja abierta. Las ventas se registrarán pero no se contabilizarán en caja.
            <a href="<?= BASE_URL ?>caja" class="btn btn-sm btn-warning ms-2">Abrir Caja</a>
        </div>
        <?php else: ?>
        <div class="alert alert-success mb-4">
            <i class="fas fa-cash-register me-2"></i>
            <strong>Caja Abierta:</strong> #<?= $data['cajaAbierta']['id'] ?> - Monto inicial: $<?= number_format($data['cajaAbierta']['monto_inicial'], 0) ?>
        </div>
        <?php endif; ?>

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

                <!-- Botones -->
                <div class="d-grid gap-2">
                    <button class="btn btn-primary btn-lg" id="btnProcesarVenta">
                        <i class="fas fa-cash-register me-2"></i>Procesar Venta
                    </button>
                    <button class="btn btn-danger" id="btnCancelarVenta">
                        <i class="fas fa-times me-2"></i>Cancelar
                    </button>
                </div>
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
    document.getElementById('btnCancelarVenta').addEventListener('click', cancelarVenta);
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

function cancelarVenta() {
    if (carrito.length > 0) {
        Swal.fire({
            title: '¿Está seguro?',
            text: "Se perderán todos los productos del carrito",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, cancelar',
            cancelButtonText: 'No, mantener'
        }).then((result) => {
            if (result.isConfirmed) limpiarVenta();
        });
    }
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
</script>