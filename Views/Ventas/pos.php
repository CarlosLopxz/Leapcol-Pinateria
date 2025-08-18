<?php 
    headerAdmin($data); 
?>

<!-- Main Body-->
<div class="d2c_main px-0 px-md-2 py-4">
    <div class="container-fluid">
        <!-- Title -->
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h6 class="mb-0">POS</h6>
            <a href="<?= BASE_URL ?>ventas" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left"></i>
            </a>
        </div>

        <div class="row">
            <!-- Productos y Carrito -->
            <div class="col-lg-8">
                <!-- Búsqueda -->
                <div class="card mb-2">
                    <div class="card-body p-2">
                        <div class="row g-1">
                            <div class="col-8">
                                <div class="input-group input-group-sm">
                                    <input type="text" id="buscarProducto" class="form-control" placeholder="Buscar...">
                                    <button class="btn btn-primary" type="button" id="btnBuscarProducto">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-4">
                                <button class="btn btn-success btn-sm w-100" id="btnMostrarProductos">
                                    <i class="fas fa-th"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Carrito -->
                <div class="card">
                    <div class="card-header bg-light py-1">
                        <small class="fw-bold">Carrito</small>
                    </div>
                    <div class="card-body p-1">
                        <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                            <table class="table table-sm mb-0" id="tablaCarrito">
                                <thead>
                                    <tr style="font-size: 0.75rem;">
                                        <th>Producto</th>
                                        <th width="60">Cant</th>
                                        <th width="60">$</th>
                                        <th width="30"></th>
                                    </tr>
                                </thead>
                                <tbody id="carritoItems">
                                    <tr id="carritoVacio">
                                        <td colspan="4" class="text-center text-muted" style="font-size: 0.8rem;">Sin productos</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Resumen y Pago -->
            <div class="col-lg-4">
                <!-- Cliente -->
                <div class="card mb-2">
                    <div class="card-body p-2">
                        <select class="form-select form-select-sm mb-1" id="clienteSelect">
                            <option value="0">Cliente General</option>
                        </select>
                        <button class="btn btn-outline-primary btn-sm w-100" id="btnNuevoCliente" style="font-size: 0.75rem;">
                            <i class="fas fa-plus"></i> Cliente
                        </button>
                    </div>
                </div>

                <!-- Totales -->
                <div class="card mb-2">
                    <div class="card-body p-2">
                        <div class="row g-1 mb-1">
                            <div class="col-6">
                                <small>Subtotal:</small>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text">$</span>
                                    <input type="text" class="form-control" id="subtotal" readonly value="0">
                                </div>
                            </div>
                            <div class="col-6">
                                <small>Descuento:</small>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" id="descuento" value="0" min="0">
                                </div>
                            </div>
                        </div>
                        <div>
                            <small class="fw-bold">TOTAL:</small>
                            <div class="input-group">
                                <span class="input-group-text fw-bold">$</span>
                                <input type="text" class="form-control fw-bold text-primary" id="total" readonly value="0">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pago -->
                <div class="card mb-2">
                    <div class="card-body p-2">
                        <select class="form-select form-select-sm mb-1" id="metodoPago">
                            <option value="1">Efectivo</option>
                            <option value="2">Tarjeta</option>
                            <option value="3">Transferencia</option>
                        </select>
                        
                        <div class="mb-1" id="pagoEfectivoContainer">
                            <small>Paga con:</small>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="pagaCon" min="0">
                            </div>
                        </div>
                        
                        <div class="mb-1" id="cambioContainer" style="display: none;">
                            <small class="fw-bold text-success">Cambio:</small>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text">$</span>
                                <input type="text" class="form-control fw-bold text-success" id="cambio" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones -->
                <div class="d-grid gap-1">
                    <button class="btn btn-primary" id="btnProcesarVenta">
                        <i class="fas fa-cash-register"></i> VENDER
                    </button>
                    <button class="btn btn-outline-secondary btn-sm" id="btnCancelarVenta">
                        <i class="fas fa-times"></i> Limpiar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End:Main Body -->

<!-- Modal para Productos -->
<div class="modal fade" id="modalProductos" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Seleccionar Productos</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col">
                        <input type="text" class="form-control" id="filtroProductos" placeholder="Filtrar productos...">
                    </div>
                </div>
                <div class="row" id="listaProductos">
                    <!-- Se cargarán dinámicamente -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Nuevo Cliente -->
<div class="modal fade" id="modalNuevoCliente" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Nuevo Cliente</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formNuevoCliente">
                    <div class="mb-3">
                        <label for="nombreCliente" class="form-label">Nombre:</label>
                        <input type="text" class="form-control" id="nombreCliente" required>
                    </div>
                    <div class="mb-3">
                        <label for="apellidoCliente" class="form-label">Apellido:</label>
                        <input type="text" class="form-control" id="apellidoCliente" required>
                    </div>
                    <div class="mb-3">
                        <label for="documentoCliente" class="form-label">Documento:</label>
                        <input type="text" class="form-control" id="documentoCliente">
                    </div>
                    <div class="mb-3">
                        <label for="telefonoCliente" class="form-label">Teléfono:</label>
                        <input type="text" class="form-control" id="telefonoCliente">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnGuardarCliente">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Cantidad de Producto -->
<div class="modal fade" id="modalCantidad" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Cantidad</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="productoId">
                <div class="mb-3">
                    <label for="cantidadProducto" class="form-label">Cantidad:</label>
                    <input type="number" class="form-control" id="cantidadProducto" value="1" min="1">
                </div>
                <p class="mb-0">Stock disponible: <span id="stockDisponible">0</span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnAgregarAlCarrito">Agregar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Venta Exitosa -->
<div class="modal fade" id="modalVentaExitosa" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">¡Venta Realizada!</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <i class="fas fa-check-circle text-success fa-5x mb-3"></i>
                <h4>Venta registrada correctamente</h4>
                <p>Número de venta: <strong id="ventaId"></strong></p>
                <p>Total: <strong id="ventaTotal"></strong></p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-info" id="btnImprimirTicketVenta">
                    <i class="fas fa-print me-2"></i>Imprimir Ticket
                </button>
                <button type="button" class="btn btn-success" id="btnFacturaDigital">
                    <i class="fas fa-file-pdf me-2"></i>Factura Digital
                </button>
            </div>
        </div>
    </div>
</div>

<?php footerAdmin($data); ?>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Variables globales
    let productos = [];
    let carrito = [];
    let ventaActualId = 0;
    
    // Función para formatear precios en formato colombiano
    function formatoPrecioCOP(precio) {
        return '$' + parseFloat(precio).toLocaleString('es-CO', {
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        });
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        // Cargar clientes
        cargarClientes();
        
        // Cargar productos
        cargarProductos();
        
        // Evento para buscar producto por código o nombre
        document.getElementById('btnBuscarProducto').addEventListener('click', buscarProducto);
        document.getElementById('buscarProducto').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                buscarProducto();
            }
        });
        
        // Evento para mostrar modal de productos
        document.getElementById('btnMostrarProductos').addEventListener('click', function() {
            const modal = new bootstrap.Modal(document.getElementById('modalProductos'));
            modal.show();
        });
        
        // Evento para filtrar productos en el modal
        document.getElementById('filtroProductos').addEventListener('input', function() {
            const filtro = this.value.toLowerCase();
            const productosHTML = document.querySelectorAll('#listaProductos .producto-item');
            
            productosHTML.forEach(item => {
                const nombre = item.getAttribute('data-nombre').toLowerCase();
                const codigo = item.getAttribute('data-codigo').toLowerCase();
                
                if (nombre.includes(filtro) || codigo.includes(filtro)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
        
        // Evento para mostrar modal de nuevo cliente
        document.getElementById('btnNuevoCliente').addEventListener('click', function() {
            const modal = new bootstrap.Modal(document.getElementById('modalNuevoCliente'));
            modal.show();
        });
        
        // Evento para guardar nuevo cliente
        document.getElementById('btnGuardarCliente').addEventListener('click', guardarCliente);
        
        // Evento para agregar producto al carrito desde el modal de cantidad
        document.getElementById('btnAgregarAlCarrito').addEventListener('click', function() {
            const productoId = parseInt(document.getElementById('productoId').value);
            const cantidad = parseInt(document.getElementById('cantidadProducto').value);
            const stockDisponible = parseInt(document.getElementById('stockDisponible').textContent);
            
            if (cantidad <= 0) {
                Swal.fire('Error', 'La cantidad debe ser mayor a 0', 'error');
                return;
            }
            
            if (cantidad > stockDisponible) {
                Swal.fire('Error', 'La cantidad no puede ser mayor al stock disponible', 'error');
                return;
            }
            
            agregarAlCarrito(productoId, cantidad);
            
            // Cerrar modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('modalCantidad'));
            modal.hide();
        });
        
        // Evento para procesar venta
        document.getElementById('btnProcesarVenta').addEventListener('click', procesarVenta);
        
        // Evento para cancelar venta
        document.getElementById('btnCancelarVenta').addEventListener('click', cancelarVenta);
        

        
        // Evento para imprimir ticket desde modal de venta exitosa
        document.getElementById('btnImprimirTicketVenta').addEventListener('click', function() {
            imprimirTicket(ventaActualId);
        });
        
        // Evento para descargar factura digital
        document.getElementById('btnFacturaDigital').addEventListener('click', function() {
            descargarFacturaDigital(ventaActualId);
        });
        
        // Evento para calcular totales cuando cambia el descuento
        document.getElementById('descuento').addEventListener('input', calcularTotales);
        
        // Eventos para método de pago y cambio
        document.getElementById('metodoPago').addEventListener('change', manejarMetodoPago);
        document.getElementById('pagaCon').addEventListener('input', calcularCambio);
    });
    
    function cargarClientes() {
        fetch('<?= BASE_URL ?>ventas/getClientes')
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
                const selectCliente = document.getElementById('clienteSelect');
                
                // Mantener la opción de Cliente General
                const optionGeneral = selectCliente.options[0];
                selectCliente.innerHTML = '';
                selectCliente.appendChild(optionGeneral);
                
                // Agregar clientes
                data.forEach(cliente => {
                    const option = document.createElement('option');
                    option.value = cliente.id;
                    option.textContent = cliente.nombre;
                    selectCliente.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
    
    function cargarProductos() {
        fetch('<?= BASE_URL ?>ventas/getProductos')
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
                productos = data;
                
                // Generar HTML para el modal de productos
                const listaProductos = document.getElementById('listaProductos');
                listaProductos.innerHTML = '';
                
                productos.forEach(producto => {
                    const col = document.createElement('div');
                    col.className = 'col-md-3 mb-3';
                    
                    const card = document.createElement('div');
                    card.className = 'card h-100 producto-item';
                    card.setAttribute('data-nombre', producto.nombre);
                    card.setAttribute('data-codigo', producto.codigo);
                    
                    // Verificar stock disponible considerando lo que ya está en el carrito
                    const itemEnCarrito = carrito.find(item => item.id === producto.id);
                    const cantidadEnCarrito = itemEnCarrito ? itemEnCarrito.cantidad : 0;
                    const stockDisponible = producto.stock - cantidadEnCarrito;
                    
                    const stockClass = stockDisponible <= 0 ? 'text-danger' : (stockDisponible <= 5 ? 'text-warning' : 'text-success');
                    const btnDisabled = stockDisponible <= 0 ? 'disabled' : '';
                    const btnText = stockDisponible <= 0 ? 'Sin Stock' : 'Agregar';
                    
                    card.innerHTML = `
                        <div class="card-body">
                            <h6 class="card-title">${producto.nombre}</h6>
                            <p class="card-text mb-1">Código: ${producto.codigo}</p>
                            <p class="card-text mb-1">Precio: ${formatoPrecioCOP(producto.precio_venta)}</p>
                            <p class="card-text mb-2 ${stockClass}">Stock: ${stockDisponible}</p>
                            <button class="btn btn-sm btn-primary w-100" onclick="seleccionarProducto(${producto.id})" ${btnDisabled}>
                                <i class="fas fa-plus me-1"></i> ${btnText}
                            </button>
                        </div>
                    `;
                    
                    col.appendChild(card);
                    listaProductos.appendChild(col);
                });
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
    
    function buscarProducto() {
        const busqueda = document.getElementById('buscarProducto').value.trim().toLowerCase();
        
        if (busqueda === '') {
            Swal.fire('Atención', 'Ingrese un código o nombre de producto', 'warning');
            return;
        }
        
        // Buscar por código o nombre
        const producto = productos.find(p => 
            p.codigo.toLowerCase() === busqueda || 
            p.nombre.toLowerCase().includes(busqueda)
        );
        
        if (producto) {
            // Verificar stock disponible
            if (producto.stock <= 0) {
                Swal.fire('Sin stock', 'No hay stock disponible para este producto', 'warning');
                return;
            }
            
            // Verificar si ya está en el carrito
            const itemEnCarrito = carrito.find(item => item.id === producto.id);
            const cantidadEnCarrito = itemEnCarrito ? itemEnCarrito.cantidad : 0;
            const stockDisponible = producto.stock - cantidadEnCarrito;
            
            if (stockDisponible <= 0) {
                Swal.fire('Sin stock', 'Ya tienes todo el stock disponible de este producto en el carrito', 'warning');
                return;
            }
            
            // Agregar al carrito
            agregarAlCarrito(producto.id, 1);
        } else {
            Swal.fire('No encontrado', 'No se encontró ningún producto con ese código o nombre', 'info');
        }
    }
    
    function seleccionarProducto(id) {
        const producto = productos.find(p => p.id === id);
        
        if (!producto) {
            Swal.fire('Error', 'Producto no encontrado', 'error');
            return;
        }
        
        // Verificar si hay stock
        if (producto.stock <= 0) {
            Swal.fire('Sin stock', 'No hay stock disponible para este producto', 'warning');
            return;
        }
        
        // Verificar si ya está en el carrito y calcular stock disponible
        const itemEnCarrito = carrito.find(item => item.id === producto.id);
        const cantidadEnCarrito = itemEnCarrito ? itemEnCarrito.cantidad : 0;
        const stockDisponible = producto.stock - cantidadEnCarrito;
        
        if (stockDisponible <= 0) {
            Swal.fire('Sin stock', 'Ya tienes todo el stock disponible de este producto en el carrito', 'warning');
            return;
        }
        
        // Agregar directamente al carrito con cantidad 1
        agregarAlCarrito(producto.id, 1);
        
        // Mostrar alerta rápida
        Swal.fire({
            icon: 'success',
            title: 'Agregado',
            timer: 800,
            showConfirmButton: false,
            toast: true,
            position: 'top-end'
        });
        
        // Cerrar modal de productos
        const modal = bootstrap.Modal.getInstance(document.getElementById('modalProductos'));
        if (modal) {
            modal.hide();
        }
    }
    
    function agregarAlCarrito(productoId, cantidad) {
        const producto = productos.find(p => p.id === productoId);
        
        if (!producto) {
            Swal.fire('Error', 'Producto no encontrado', 'error');
            return;
        }
        
        // Verificar si el producto ya está en el carrito
        const index = carrito.findIndex(item => item.id === productoId);
        
        if (index !== -1) {
            // Actualizar cantidad
            const nuevaCantidad = carrito[index].cantidad + cantidad;
            
            if (nuevaCantidad > producto.stock) {
                Swal.fire('Error', 'La cantidad total no puede ser mayor al stock disponible', 'error');
                return;
            }
            
            carrito[index].cantidad = nuevaCantidad;
            carrito[index].subtotal = nuevaCantidad * producto.precio_venta;
        } else {
            // Agregar nuevo producto
            carrito.push({
                id: producto.id,
                codigo: producto.codigo,
                nombre: producto.nombre,
                precio: producto.precio_venta,
                cantidad: cantidad,
                subtotal: cantidad * producto.precio_venta
            });
        }
        
        // Actualizar tabla del carrito
        actualizarTablaCarrito();
        
        // Calcular totales
        calcularTotales();
        
        // Actualizar vista de productos para reflejar stock disponible
        cargarProductos();
        
        // Limpiar campo de búsqueda
        document.getElementById('buscarProducto').value = '';
    }
    
    function actualizarTablaCarrito() {
        const tbody = document.getElementById('carritoItems');
        tbody.innerHTML = '';
        
        if (carrito.length === 0) {
            const tr = document.createElement('tr');
            tr.id = 'carritoVacio';
            tr.innerHTML = '<td colspan="5" class="text-center">No hay productos en el carrito</td>';
            tbody.appendChild(tr);
            return;
        }
        
        carrito.forEach((item, index) => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td style="font-size: 0.75rem;">
                    <div class="fw-bold">${item.nombre.length > 15 ? item.nombre.substring(0, 15) + '...' : item.nombre}</div>
                    <small class="text-muted">${item.codigo}</small>
                </td>
                <td>
                    <div class="input-group input-group-sm" style="width:50px;">
                        <button class="btn btn-outline-secondary" type="button" onclick="cambiarCantidad(${index}, -1)" style="padding:1px 4px; font-size:0.7rem;">-</button>
                        <input type="text" class="form-control text-center" value="${item.cantidad}" readonly style="padding:1px; font-size:0.7rem; width:20px;">
                        <button class="btn btn-outline-secondary" type="button" onclick="cambiarCantidad(${index}, 1)" style="padding:1px 4px; font-size:0.7rem;">+</button>
                    </div>
                </td>
                <td class="text-end fw-bold" style="font-size: 0.75rem;">${formatoPrecioCOP(item.subtotal)}</td>
                <td class="text-center">
                    <button class="btn btn-sm btn-outline-danger" onclick="eliminarDelCarrito(${index})" style="padding:1px 4px;">
                        <i class="fas fa-times" style="font-size:0.6rem;"></i>
                    </button>
                </td>
            `;
            tbody.appendChild(tr);
        });
    }
    
    function cambiarCantidad(index, cambio) {
        const item = carrito[index];
        const producto = productos.find(p => p.id === item.id);
        
        if (!producto) {
            return;
        }
        
        const nuevaCantidad = item.cantidad + cambio;
        
        if (nuevaCantidad <= 0) {
            eliminarDelCarrito(index);
            return;
        }
        
        if (nuevaCantidad > producto.stock) {
            Swal.fire('Error', 'La cantidad no puede ser mayor al stock disponible', 'error');
            return;
        }
        
        carrito[index].cantidad = nuevaCantidad;
        carrito[index].subtotal = nuevaCantidad * item.precio;
        
        actualizarTablaCarrito();
        calcularTotales();
        cargarProductos();
    }
    
    function eliminarDelCarrito(index) {
        carrito.splice(index, 1);
        actualizarTablaCarrito();
        calcularTotales();
        cargarProductos();
    }
    
    function calcularTotales() {
        // Calcular subtotal
        const subtotal = carrito.reduce((sum, item) => sum + item.subtotal, 0);
        
        // Obtener descuento
        const descuento = parseFloat(document.getElementById('descuento').value) || 0;
        
        // Calcular total (sin IVA)
        const total = subtotal - descuento;
        
        // Actualizar campos
        document.getElementById('subtotal').value = subtotal.toFixed(0);
        document.getElementById('total').value = total.toFixed(0);
    }
    
    function guardarCliente() {
        const nombre = document.getElementById('nombreCliente').value.trim();
        const apellido = document.getElementById('apellidoCliente').value.trim();
        const documento = document.getElementById('documentoCliente').value.trim();
        const telefono = document.getElementById('telefonoCliente').value.trim();
        
        if (nombre === '' || apellido === '') {
            Swal.fire('Error', 'El nombre y apellido son obligatorios', 'error');
            return;
        }
        
        // Mostrar indicador de carga
        Swal.fire({
            title: 'Guardando cliente',
            text: 'Por favor espere...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        // Preparar datos para enviar
        const formData = new FormData();
        formData.append('nombre', nombre);
        formData.append('apellido', apellido);
        formData.append('documento', documento);
        formData.append('telefono', telefono);
        formData.append('email', ''); // Campo opcional
        formData.append('direccion', ''); // Campo opcional
        
        // Enviar datos al servidor
        fetch('<?= BASE_URL ?>clientes/setCliente', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la respuesta del servidor');
            }
            return response.json();
        })
        .then(data => {
            // Cerrar indicador de carga
            Swal.close();
            
            if (data.status) {
                Swal.fire({
                    icon: 'success',
                    title: 'Cliente guardado',
                    text: data.msg,
                    timer: 1500,
                    showConfirmButton: false
                });
                
                // Cerrar modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('modalNuevoCliente'));
                modal.hide();
                
                // Limpiar formulario
                document.getElementById('formNuevoCliente').reset();
                
                // Recargar clientes
                cargarClientes();
            } else {
                Swal.fire('Error', data.msg, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.close();
            Swal.fire('Error', 'Ocurrió un error al guardar el cliente', 'error');
        });
    }
    
    function procesarVenta() {
        // Verificar que haya productos en el carrito
        if (carrito.length === 0) {
            Swal.fire('Error', 'No hay productos en el carrito', 'error');
            return;
        }
        
        // Verificar pago en efectivo
        const metodoSeleccionado = document.getElementById('metodoPago').value;
        if(metodoSeleccionado === '1') { // Efectivo
            const totalVenta = parseFloat(document.getElementById('total').value);
            const pagaCon = parseFloat(document.getElementById('pagaCon').value) || 0;
            
            if(pagaCon <= 0) {
                Swal.fire('Error', 'Debe ingresar el monto con que paga', 'error');
                return;
            }
            
            if(pagaCon < totalVenta) {
                Swal.fire('Error', 'El monto a pagar es insuficiente', 'error');
                return;
            }
        }
        
        // Obtener datos de la venta
        const cliente = document.getElementById('clienteSelect').value;
        const subtotal = parseFloat(document.getElementById('subtotal').value);
        const impuestos = 0; // Sin IVA
        const descuentos = parseFloat(document.getElementById('descuento').value) || 0;
        const total = parseFloat(document.getElementById('total').value);
        const metodoPago = document.getElementById('metodoPago').value;
        const observaciones = '';
        
        // Preparar productos para enviar
        const productosVenta = carrito.map(item => ({
            id: item.id,
            cantidad: item.cantidad,
            precio: item.precio,
            subtotal: item.subtotal
        }));
        
        // Mostrar indicador de carga
        Swal.fire({
            title: 'Procesando venta',
            text: 'Por favor espere...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        // Enviar datos al servidor
        const formData = new FormData();
        formData.append('idVenta', 0); // Nueva venta
        formData.append('cliente', cliente);
        formData.append('subtotal', subtotal);
        formData.append('impuestos', impuestos);
        formData.append('descuentos', descuentos);
        formData.append('total', total);
        formData.append('metodo_pago', metodoPago);
        formData.append('observaciones', observaciones);
        formData.append('productos', JSON.stringify(productosVenta));
        
        // Agregar datos de pago si es efectivo
        if(metodoPago === '1') {
            const pagoCon = parseFloat(document.getElementById('pagaCon').value) || 0;
            const cambio = parseFloat(document.getElementById('cambio').value) || 0;
            formData.append('pagoCon', pagoCon);
            formData.append('cambio', cambio);
        }
        
        fetch('<?= BASE_URL ?>ventas/setVenta', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Error en la respuesta del servidor: ${response.status}`);
            }
            return response.text();
        })
        .then(text => {
            // Verificar si el texto está vacío
            if (!text || text.trim() === '') {
                throw new Error('La respuesta del servidor está vacía');
            }
            
            try {
                return JSON.parse(text);
            } catch (e) {
                console.error('Error al parsear JSON:', e);
                console.log('Respuesta recibida:', text);
                throw new Error('Error al procesar la respuesta del servidor');
            }
        })
        .then(data => {
            // Cerrar indicador de carga
            Swal.close();
            
            console.log('Respuesta del servidor:', data);
            
            if (data.status) {
                // Guardar ID de la venta
                ventaActualId = data.idVenta;
                
                // Limpiar carrito
                limpiarVenta();
                
                // Mostrar modal de venta exitosa
                document.getElementById('ventaId').textContent = data.idVenta;
                document.getElementById('ventaTotal').textContent = formatoPrecioCOP(total);
                
                const modal = new bootstrap.Modal(document.getElementById('modalVentaExitosa'));
                modal.show();
            } else {
                // Mostrar información detallada del error
                let errorMsg = data.msg || 'Error desconocido al procesar la venta';
                let errorDetails = '';
                
                if (data.debug) {
                    errorDetails = 'Modo debug activado. Revise la consola para más detalles.';
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'Error al procesar la venta',
                    text: errorMsg,
                    footer: errorDetails,
                    confirmButtonText: 'Entendido',
                    showCancelButton: data.debug,
                    cancelButtonText: 'Ver detalles',
                    cancelButtonColor: '#3085d6'
                }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.cancel) {
                        // Mostrar detalles técnicos
                        console.log('Datos enviados:', {
                            cliente,
                            subtotal,
                            impuestos,
                            descuentos,
                            total,
                            metodoPago,
                            observaciones,
                            productos: productosVenta
                        });
                        
                        Swal.fire({
                            icon: 'info',
                            title: 'Detalles técnicos',
                            text: 'Se han mostrado los detalles en la consola del navegador (F12)',
                            confirmButtonText: 'Cerrar'
                        });
                    }
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.close(); // Asegurar que se cierra el indicador de carga
            
            // Mostrar mensaje de error más detallado
            let errorMsg = 'Ocurrió un error al procesar la venta';
            
            // Intentar obtener más información del error
            if (error.message) {
                if (error.message.includes('respuesta del servidor')) {
                    errorMsg = 'Error de comunicación con el servidor. Verifique su conexión a internet.';
                } else if (error.message.includes('JSON')) {
                    errorMsg = 'Error en el formato de respuesta del servidor. Contacte al administrador.';
                } else {
                    errorMsg = `${errorMsg}: ${error.message}`;
                }
            }
            
            // Registrar el error en la consola para depuración
            console.log('Detalles del error:', error);
            
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: errorMsg,
                footer: '<a href="#" onclick="mostrarDetallesError()">Ver detalles técnicos</a>'
            });
        });
        
        // Función para mostrar detalles técnicos del error (para administradores)
        window.mostrarDetallesError = function() {
            Swal.fire({
                icon: 'info',
                title: 'Detalles técnicos',
                text: 'Revise la consola del navegador (F12) para ver los detalles del error.',
                confirmButtonText: 'Entendido'
            });
        }
    }
    
    function cancelarVenta() {
        // Confirmar cancelación
        if (carrito.length > 0) {
            Swal.fire({
                title: '¿Está seguro?',
                text: "Se perderán todos los productos del carrito",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, cancelar',
                cancelButtonText: 'No, mantener'
            }).then((result) => {
                if (result.isConfirmed) {
                    limpiarVenta();
                }
            });
        } else {
            limpiarVenta();
        }
    }
    
    function limpiarVenta() {
        // Limpiar carrito
        carrito = [];
        actualizarTablaCarrito();
        
        // Limpiar campos
        document.getElementById('clienteSelect').value = 0;
        document.getElementById('subtotal').value = 0;
        document.getElementById('descuento').value = 0;
        document.getElementById('total').value = 0;
        document.getElementById('metodoPago').value = 1;
        // document.getElementById('observaciones').value = '';
        document.getElementById('buscarProducto').value = '';
        document.getElementById('pagaCon').value = '';
        document.getElementById('cambio').value = '';
        document.getElementById('pagoEfectivoContainer').style.display = 'block';
        document.getElementById('cambioContainer').style.display = 'none';
    }
    
    function imprimirTicket(id) {
        // Abrir en una nueva ventana
        window.open(`<?= BASE_URL ?>ventas/imprimirTicket/${id}`, '_blank');
    }
    
    function manejarMetodoPago() {
        const metodoPago = document.getElementById('metodoPago').value;
        const pagoEfectivoContainer = document.getElementById('pagoEfectivoContainer');
        const cambioContainer = document.getElementById('cambioContainer');
        
        if(metodoPago === '1') { // Efectivo
            pagoEfectivoContainer.style.display = 'block';
            document.getElementById('pagaCon').required = true;
        } else {
            pagoEfectivoContainer.style.display = 'none';
            cambioContainer.style.display = 'none';
            document.getElementById('pagaCon').required = false;
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
            
            if(cambio >= 0) {
                cambioInput.value = cambio.toFixed(0);
                cambioInput.className = 'form-control form-control-lg fw-bold text-success';
                cambioContainer.style.display = 'block';
            } else {
                cambioInput.value = Math.abs(cambio).toFixed(0);
                cambioInput.className = 'form-control form-control-lg fw-bold text-danger';
                cambioContainer.style.display = 'block';
            }
        } else {
            cambioContainer.style.display = 'none';
        }
    }
    
    function descargarFacturaDigital(id) {
        // Crear enlace de descarga
        const link = document.createElement('a');
        link.href = `<?= BASE_URL ?>ventas/facturaDigital/${id}`;
        link.download = `factura_${id}.pdf`;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
</script>