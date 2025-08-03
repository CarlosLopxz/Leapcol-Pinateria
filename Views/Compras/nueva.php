<?php 
    headerAdmin($data); 
?>

<!-- Main Body-->
<div class="d2c_main px-0 px-md-2 py-4">
    <div class="container-fluid">
        <!-- Title -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-0 text-capitalize">Registrar Nueva Compra</h4>
                <p class="text-muted">Ingrese los datos de la compra a proveedor</p>
            </div>
            <a href="<?= BASE_URL ?>compras" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Volver
            </a>
        </div>

        <!-- Formulario de Compra -->
        <div class="card">
            <div class="card-body">
                <form id="formCompra" name="formCompra" class="needs-validation" novalidate>
                    <input type="hidden" id="idCompra" name="idCompra" value="0">
                    
                    <div class="row mb-4">
                        <!-- Datos de la Compra -->
                        <div class="col-md-6">
                            <h5 class="mb-3">Datos de la Compra</h5>
                            
                            <div class="mb-3">
                                <label for="proveedor" class="form-label">Proveedor *</label>
                                <select class="form-select" id="proveedor" name="proveedor" required>
                                    <option value="">Seleccionar...</option>
                                    <!-- Se cargará dinámicamente -->
                                </select>
                                <div class="invalid-feedback">
                                    Seleccione un proveedor
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="numero_factura" class="form-label">Número de Factura</label>
                                <input type="text" class="form-control" id="numero_factura" name="numero_factura">
                            </div>
                            
                            <div class="mb-3">
                                <label for="fecha_compra" class="form-label">Fecha de Compra *</label>
                                <input type="date" class="form-control" id="fecha_compra" name="fecha_compra" required>
                                <div class="invalid-feedback">
                                    Ingrese la fecha de compra
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="estado" class="form-label">Estado</label>
                                <select class="form-select" id="estado" name="estado">
                                    <option value="1">Completada</option>
                                    <option value="2">Pendiente</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="observaciones" class="form-label">Observaciones</label>
                                <textarea class="form-control" id="observaciones" name="observaciones" rows="3"></textarea>
                            </div>
                        </div>
                        
                        <!-- Totales -->
                        <div class="col-md-6">
                            <h5 class="mb-3">Totales</h5>
                            
                            <div class="card bg-light mb-3">
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <label for="subtotal" class="col-sm-4 col-form-label">Subtotal:</label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <span class="input-group-text">$</span>
                                                <input type="number" class="form-control" id="subtotal" name="subtotal" step="0.01" min="0" value="0.00" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-2">
                                        <label for="impuestos" class="col-sm-4 col-form-label">Impuestos:</label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <span class="input-group-text">$</span>
                                                <input type="number" class="form-control" id="impuestos" name="impuestos" step="0.01" min="0" value="0.00">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-2">
                                        <label for="descuentos" class="col-sm-4 col-form-label">Descuentos:</label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <span class="input-group-text">$</span>
                                                <input type="number" class="form-control" id="descuentos" name="descuentos" step="0.01" min="0" value="0.00">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <label for="total" class="col-sm-4 col-form-label fw-bold">Total:</label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <span class="input-group-text">$</span>
                                                <input type="number" class="form-control fw-bold" id="total" name="total" step="0.01" min="0" value="0.00" readonly required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-save me-2"></i>Guardar Compra
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Productos -->
                    <h5 class="mb-3">Productos</h5>
                    
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="mb-3">
                                                <label for="buscarProducto" class="form-label">Buscar Producto</label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control" id="buscarProducto" placeholder="Escriba para buscar..." autocomplete="off">
                                                    <div id="listaProductosBusqueda" class="position-absolute w-100 bg-white border rounded shadow-sm" style="z-index: 1000; max-height: 200px; overflow-y: auto; display: none;"></div>
                                                </div>
                                                <input type="hidden" id="producto" name="producto">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <label for="cantidad" class="form-label">Cantidad</label>
                                                <input type="number" class="form-control" id="cantidad" min="1" value="1">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <label for="precio" class="form-label">Precio</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">$</span>
                                                    <input type="number" class="form-control" id="precio" step="0.01" min="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <label for="subtotal_producto" class="form-label">Subtotal</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">$</span>
                                                    <input type="number" class="form-control" id="subtotal_producto" step="0.01" min="0" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-1 d-flex align-items-end">
                                            <button type="button" class="btn btn-success mb-3" id="btnAgregarProducto">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-striped" id="tablaProductos">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio</th>
                                    <th>Subtotal</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="listaProductos">
                                <tr id="filaVacia">
                                    <td colspan="6" class="text-center">No hay productos agregados</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <input type="hidden" id="productos" name="productos" value="[]">
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End:Main Body -->

<?php footerAdmin($data); ?>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Función para formatear precios en formato colombiano
    function formatoPrecioCOP(precio) {
        return '$' + parseFloat(precio).toLocaleString('es-CO', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }
    
    // Variables globales
    var listaProductos = [];
    var productosData = [];
    var proveedoresData = [];
    var editando = false;
    
    document.addEventListener('DOMContentLoaded', function() {
        // Establecer fecha actual por defecto
        document.getElementById('fecha_compra').valueAsDate = new Date();
        
        // Cargar proveedores
        cargarProveedores();
        
        // Cargar productos
        cargarProductos();
        
        // Verificar si es edición
        const urlParams = new URLSearchParams(window.location.search);
        const idCompra = window.location.pathname.split('/').pop();
        
        if(idCompra && !isNaN(idCompra) && idCompra > 0) {
            editando = true;
            document.getElementById('idCompra').value = idCompra;
            cargarDatosCompra(idCompra);
        }
        
        // Eventos para calcular subtotal del producto
        document.getElementById('cantidad').addEventListener('input', calcularSubtotalProducto);
        document.getElementById('precio').addEventListener('input', calcularSubtotalProducto);
        
        // Evento para agregar producto
        document.getElementById('btnAgregarProducto').addEventListener('click', agregarProducto);
        
        // Eventos para calcular total
        document.getElementById('impuestos').addEventListener('input', calcularTotal);
        document.getElementById('descuentos').addEventListener('input', calcularTotal);
        
        // Evento para enviar formulario
        document.getElementById('formCompra').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validar formulario
            if(!this.checkValidity()) {
                e.stopPropagation();
                this.classList.add('was-validated');
                return;
            }
            
            // Validar que haya productos
            if(listaProductos.length === 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Debe agregar al menos un producto a la compra'
                });
                return;
            }
            
            // Actualizar campo oculto con la lista de productos
            document.getElementById('productos').value = JSON.stringify(listaProductos);
            
            // Enviar formulario
            guardarCompra();
        });
    });
    
    function cargarProveedores() {
        fetch('<?= BASE_URL ?>compras/getProveedores')
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
                proveedoresData = data;
                const selectProveedor = document.getElementById('proveedor');
                
                // Limpiar opciones actuales
                selectProveedor.innerHTML = '<option value="">Seleccionar...</option>';
                
                // Agregar proveedores
                data.forEach(proveedor => {
                    const option = document.createElement('option');
                    option.value = proveedor.id;
                    option.textContent = proveedor.nombre;
                    selectProveedor.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
    
    function cargarProductos() {
        fetch('<?= BASE_URL ?>compras/getProductos')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor');
                }
                return response.text();
            })
            .then(text => {
                try {
                    const data = JSON.parse(text);
                    productosData = Array.isArray(data) ? data : [];
                    console.log('Productos cargados:', productosData.length);
                    configurarBuscadorProductos();
                } catch (e) {
                    console.error('Error al parsear JSON:', e);
                    productosData = [];
                }
            })
            .catch(error => {
                console.error('Error:', error);
                productosData = [];
            });
    }
    
    function configurarBuscadorProductos() {
        const inputBuscar = document.getElementById('buscarProducto');
        const listaResultados = document.getElementById('listaProductosBusqueda');
        const inputProducto = document.getElementById('producto');
        
        inputBuscar.addEventListener('input', function() {
            const termino = this.value.toLowerCase().trim();
            
            if (termino.length === 0) {
                listaResultados.style.display = 'none';
                return;
            }
            
            if (termino.length === 1) {
                // Mostrar todos los productos si solo hay 1 caracter
                mostrarResultadosBusqueda(productosData);
                return;
            }
            
            const productosFiltrados = productosData.filter(producto => 
                producto.codigo.toLowerCase().includes(termino) ||
                producto.nombre.toLowerCase().includes(termino)
            );
            
            mostrarResultadosBusqueda(productosFiltrados);
        });
        
        inputBuscar.addEventListener('blur', function() {
            setTimeout(() => {
                listaResultados.style.display = 'none';
            }, 200);
        });
        
        inputBuscar.addEventListener('focus', function() {
            const termino = this.value.toLowerCase().trim();
            if (termino.length === 0) {
                // Mostrar todos los productos al hacer focus sin texto
                mostrarResultadosBusqueda(productosData);
            } else if (termino.length >= 1) {
                const productosFiltrados = productosData.filter(producto => 
                    producto.codigo.toLowerCase().includes(termino) ||
                    producto.nombre.toLowerCase().includes(termino)
                );
                mostrarResultadosBusqueda(productosFiltrados);
            }
        });
    }
    
    function mostrarResultadosBusqueda(productos) {
        const listaResultados = document.getElementById('listaProductosBusqueda');
        
        if (productos.length === 0) {
            listaResultados.innerHTML = '<div class="p-2 text-muted">No se encontraron productos</div>';
            listaResultados.style.display = 'block';
            return;
        }
        
        listaResultados.innerHTML = '';
        
        productos.slice(0, 10).forEach(producto => {
            const item = document.createElement('div');
            item.className = 'p-2 border-bottom cursor-pointer';
            item.style.cursor = 'pointer';
            item.innerHTML = `
                <div class="fw-bold">${producto.codigo} - ${producto.nombre}</div>
                <small class="text-muted">Precio: ${formatoPrecioCOP(producto.precio_compra)}</small>
            `;
            
            item.addEventListener('click', function() {
                seleccionarProducto(producto);
            });
            
            item.addEventListener('mouseenter', function() {
                this.style.backgroundColor = '#f8f9fa';
            });
            
            item.addEventListener('mouseleave', function() {
                this.style.backgroundColor = 'white';
            });
            
            listaResultados.appendChild(item);
        });
        
        listaResultados.style.display = 'block';
    }
    
    function seleccionarProducto(producto) {
        document.getElementById('buscarProducto').value = `${producto.codigo} - ${producto.nombre}`;
        document.getElementById('producto').value = producto.id;
        document.getElementById('precio').value = producto.precio_compra;
        document.getElementById('listaProductosBusqueda').style.display = 'none';
        calcularSubtotalProducto();
    }
    
    function cargarDatosCompra(idCompra) {
        fetch(`<?= BASE_URL ?>compras/getCompra/${idCompra}`)
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
                // Llenar datos de la compra
                document.getElementById('proveedor').value = data.proveedor_id;
                document.getElementById('numero_factura').value = data.numero_factura || '';
                document.getElementById('fecha_compra').value = data.fecha_compra;
                document.getElementById('estado').value = data.estado;
                document.getElementById('observaciones').value = data.observaciones || '';
                document.getElementById('subtotal').value = data.subtotal;
                document.getElementById('impuestos').value = data.impuestos;
                document.getElementById('descuentos').value = data.descuentos;
                document.getElementById('total').value = data.total;
                
                // Cargar productos
                if(data.detalle && data.detalle.length > 0) {
                    data.detalle.forEach(item => {
                        const producto = {
                            id: item.producto_id,
                            codigo: item.codigo,
                            nombre: item.nombre,
                            cantidad: parseInt(item.cantidad),
                            precio: parseFloat(item.precio_unitario),
                            subtotal: parseFloat(item.subtotal)
                        };
                        
                        listaProductos.push(producto);
                    });
                    
                    actualizarTablaProductos();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo cargar la información de la compra'
                });
            });
    }
    
    function calcularSubtotalProducto() {
        const cantidad = parseFloat(document.getElementById('cantidad').value) || 0;
        const precio = parseFloat(document.getElementById('precio').value) || 0;
        const subtotal = cantidad * precio;
        
        document.getElementById('subtotal_producto').value = subtotal.toFixed(2);
    }
    
    function agregarProducto() {
        const productoId = document.getElementById('producto').value;
        
        if(!productoId) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Debe seleccionar un producto'
            });
            return;
        }
        
        const cantidad = parseInt(document.getElementById('cantidad').value) || 0;
        if(cantidad <= 0) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'La cantidad debe ser mayor a cero'
            });
            return;
        }
        
        const precio = parseFloat(document.getElementById('precio').value) || 0;
        if(precio <= 0) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'El precio debe ser mayor a cero'
            });
            return;
        }
        
        // Verificar si el producto ya está en la lista
        const productoExistente = listaProductos.find(p => p.id == productoId);
        if(productoExistente) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Este producto ya está en la lista'
            });
            return;
        }
        
        // Obtener datos del producto
        const productoSeleccionado = productosData.find(p => p.id == productoId);
        if (!productoSeleccionado) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Producto no encontrado'
            });
            return;
        }
        
        const subtotal = cantidad * precio;
        
        // Agregar producto a la lista
        const producto = {
            id: productoId,
            codigo: productoSeleccionado.codigo,
            nombre: productoSeleccionado.nombre,
            cantidad: cantidad,
            precio: precio,
            subtotal: subtotal
        };
        
        listaProductos.push(producto);
        
        // Actualizar tabla
        actualizarTablaProductos();
        
        // Calcular total
        calcularSubtotal();
        
        // Limpiar campos
        document.getElementById('buscarProducto').value = '';
        document.getElementById('producto').value = '';
        document.getElementById('cantidad').value = '1';
        document.getElementById('precio').value = '';
        document.getElementById('subtotal_producto').value = '';
    }
    
    function eliminarProducto(index) {
        listaProductos.splice(index, 1);
        actualizarTablaProductos();
        calcularSubtotal();
    }
    
    function actualizarTablaProductos() {
        const tbody = document.getElementById('listaProductos');
        tbody.innerHTML = '';
        
        if(listaProductos.length === 0) {
            const tr = document.createElement('tr');
            tr.id = 'filaVacia';
            tr.innerHTML = '<td colspan="6" class="text-center">No hay productos agregados</td>';
            tbody.appendChild(tr);
            return;
        }
        
        listaProductos.forEach((producto, index) => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${producto.codigo}</td>
                <td>${producto.nombre}</td>
                <td>${producto.cantidad}</td>
                <td>${formatoPrecioCOP(producto.precio)}</td>
                <td>${formatoPrecioCOP(producto.subtotal)}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-danger" onclick="eliminarProducto(${index})">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;
            tbody.appendChild(tr);
        });
    }
    
    function calcularSubtotal() {
        const subtotal = listaProductos.reduce((sum, producto) => sum + producto.subtotal, 0);
        document.getElementById('subtotal').value = subtotal.toFixed(2);
        calcularTotal();
    }
    
    function calcularTotal() {
        const subtotal = parseFloat(document.getElementById('subtotal').value) || 0;
        const impuestos = parseFloat(document.getElementById('impuestos').value) || 0;
        const descuentos = parseFloat(document.getElementById('descuentos').value) || 0;
        
        const total = subtotal + impuestos - descuentos;
        document.getElementById('total').value = total.toFixed(2);
    }
    
    function guardarCompra() {
        const formData = new FormData(document.getElementById('formCompra'));
        
        // Mostrar spinner
        Swal.fire({
            title: 'Guardando...',
            text: 'Por favor espere',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        fetch('<?= BASE_URL ?>compras/setCompra', {
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
            if(data.status) {
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: data.msg,
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    window.location.href = '<?= BASE_URL ?>compras';
                });
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
</script>