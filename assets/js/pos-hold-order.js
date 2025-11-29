// Sistema Simplificado de Guardar Ventas para POS
let ventasGuardadas = [];

// Cargar ventas guardadas desde localStorage al iniciar
function cargarVentasGuardadas() {
    const guardadas = localStorage.getItem('ventasGuardadas');
    if (guardadas) {
        try {
            ventasGuardadas = JSON.parse(guardadas);
            // Convertir las fechas de string a Date
            ventasGuardadas.forEach(venta => {
                venta.fecha = new Date(venta.fecha);
            });
            actualizarBotonGuardar();
        } catch (e) {
            console.error('Error al cargar ventas guardadas:', e);
            ventasGuardadas = [];
        }
    }
}

// Guardar ventas en localStorage
function guardarEnLocalStorage() {
    try {
        localStorage.setItem('ventasGuardadas', JSON.stringify(ventasGuardadas));
    } catch (e) {
        console.error('Error al guardar en localStorage:', e);
    }
}

// Cargar ventas al iniciar la página
document.addEventListener('DOMContentLoaded', function () {
    cargarVentasGuardadas();
});

// Función para actualizar el botón según el estado
function actualizarBotonGuardar() {
    const btnGuardar = document.getElementById('btnGuardarVenta');
    if (!btnGuardar) return;

    if (ventasGuardadas.length > 0) {
        // Hay ventas guardadas - mostrar botón para recuperar
        btnGuardar.style.display = 'block';
        btnGuardar.className = 'btn btn-success position-relative';
        btnGuardar.innerHTML = `
            <i class="fas fa-clock me-2"></i>Ventas Guardadas
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">${ventasGuardadas.length}</span>
        `;
        btnGuardar.onclick = mostrarVentasGuardadas;
    } else if (carrito.length > 0) {
        // Hay productos en el carrito - mostrar botón para guardar
        btnGuardar.style.display = 'block';
        btnGuardar.className = 'btn btn-secondary';
        btnGuardar.innerHTML = '<i class="fas fa-save me-2"></i>Guardar Venta';
        btnGuardar.onclick = guardarVenta;
    } else {
        // No hay nada - ocultar botón
        btnGuardar.style.display = 'none';
    }
}

// Función para guardar la venta actual
function guardarVenta() {
    if (carrito.length === 0) {
        Swal.fire('Error', 'No hay productos para guardar', 'warning');
        return;
    }

    const ventaGuardada = {
        id: Date.now(),
        fecha: new Date(),
        carrito: JSON.parse(JSON.stringify(carrito)),
        clienteId: document.getElementById('clienteSelect').value,
        clienteNombre: document.getElementById('clienteSelect').options[document.getElementById('clienteSelect').selectedIndex].text,
        descuento: parseFloat(document.getElementById('descuento').value) || 0,
        metodoPago: document.getElementById('metodoPago').value,
        destinoCaja: document.getElementById('destinoCaja').value,
        pagaCon: document.getElementById('pagaCon').value,
        total: parseFloat(document.getElementById('total').value)
    };

    ventasGuardadas.push(ventaGuardada);
    guardarEnLocalStorage();
    limpiarVenta();

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true
    });

    Toast.fire({
        icon: 'success',
        title: 'Venta guardada correctamente'
    });

    actualizarBotonGuardar();
}

// Función para mostrar modal de ventas guardadas
function mostrarVentasGuardadas() {
    if (ventasGuardadas.length === 0) {
        Swal.fire('Info', 'No hay ventas guardadas', 'info');
        return;
    }

    // Si solo hay una venta guardada, recuperarla directamente
    if (ventasGuardadas.length === 1) {
        recuperarVenta(0);
        return;
    }

    // Si hay múltiples ventas, mostrar lista
    let html = '<div class="list-group">';
    ventasGuardadas.forEach((venta, index) => {
        const hora = venta.fecha.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        const items = venta.carrito.length;
        html += `
            <button type="button" class="list-group-item list-group-item-action" onclick="recuperarVenta(${index})">
                <div class="d-flex w-100 justify-content-between">
                    <h6 class="mb-1">${venta.clienteNombre}</h6>
                    <small>${hora}</small>
                </div>
                <p class="mb-1">${items} productos - ${formatoPrecioCOP(venta.total)}</p>
            </button>
        `;
    });
    html += '</div>';

    Swal.fire({
        title: 'Selecciona una venta',
        html: html,
        showConfirmButton: false,
        showCancelButton: true,
        cancelButtonText: 'Cerrar',
        width: '600px'
    });
}

// Función para recuperar una venta guardada
function recuperarVenta(index) {
    const venta = ventasGuardadas[index];

    // Si hay productos en el carrito actual, preguntar
    if (carrito.length > 0) {
        Swal.fire({
            title: '¿Guardar venta actual?',
            text: 'Hay productos en el carrito. ¿Desea guardarlos antes de recuperar la otra venta?',
            icon: 'question',
            showCancelButton: true,
            showDenyButton: true,
            confirmButtonText: 'Sí, guardar',
            denyButtonText: 'No, descartar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                guardarVenta();
                cargarVentaGuardada(index);
            } else if (result.isDenied) {
                cargarVentaGuardada(index);
            }
        });
    } else {
        cargarVentaGuardada(index);
    }
}

// Función para cargar una venta guardada
function cargarVentaGuardada(index) {
    const venta = ventasGuardadas[index];

    // Restaurar carrito
    carrito = JSON.parse(JSON.stringify(venta.carrito));

    // Restaurar campos
    document.getElementById('clienteSelect').value = venta.clienteId;
    document.getElementById('descuento').value = venta.descuento;
    document.getElementById('metodoPago').value = venta.metodoPago;
    document.getElementById('destinoCaja').value = venta.destinoCaja;
    document.getElementById('pagaCon').value = venta.pagaCon || '';

    // Actualizar vista
    actualizarTablaCarrito();
    calcularTotales();
    manejarMetodoPago();

    // Eliminar de guardadas
    ventasGuardadas.splice(index, 1);
    guardarEnLocalStorage();
    actualizarBotonGuardar();

    // Cerrar cualquier modal abierto
    Swal.close();

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true
    });

    Toast.fire({
        icon: 'success',
        title: 'Venta recuperada'
    });
}

// Modificar la función limpiarVenta original para actualizar el botón
const limpiarVentaOriginal = window.limpiarVenta;
window.limpiarVenta = function () {
    if (limpiarVentaOriginal) {
        limpiarVentaOriginal();
    }
    actualizarBotonGuardar();
};

// Modificar actualizarTablaCarrito para actualizar el botón
const actualizarTablaCarritoOriginal = window.actualizarTablaCarrito;
window.actualizarTablaCarrito = function () {
    if (actualizarTablaCarritoOriginal) {
        actualizarTablaCarritoOriginal();
    }
    actualizarBotonGuardar();
};
