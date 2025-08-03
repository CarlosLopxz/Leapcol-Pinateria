<?php 
    headerAdmin($data); 
?>

<!-- Main Body-->
<div class="d2c_main px-0 px-md-2 py-4">
    <div class="container-fluid">
        <?php if(isset($_SESSION['error_message'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <?= $_SESSION['error_message'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['error_message']); endif; ?>
        
        <!-- Title -->
        <p class="mb-1">Bienvenido a</p>
        <h4 class="mb-4 text-capitalize"><?= NOMBRE_EMPRESA ?></h4>
        <div class="row">
            <!-- card item -->
            <div class="col mb-4">
                <div class="card d2c_currency_card_wrapper animate__animated animate__fadeInUp">
                    <div class="card-body d-flex align-items-center">
                        <div>
                            <div class="d2c_coin_icon_wrapper bg-warning text-warning bg-opacity-10 d-flex align-items-center justify-content-center me-3">
                                <i class="fas fa-box"></i>
                            </div>
                        </div>
                        <div class="w-100">
                            <h5 class="mb-1">Productos</h5>
                            <div class="d-flex justify-content-between">
                                <p class="mb-0">Total: <?= $data['totalProductos'] ?></p>
                                <p class="mb-0 text-info">Activos</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- card item -->
            <div class="col mb-4">
                <div class="card d2c_currency_card_wrapper animate__animated animate__fadeInUp">
                    <div class="card-body d-flex align-items-center">
                        <div>
                            <div class="d2c_coin_icon_wrapper bg-primary text-primary bg-opacity-10 d-flex align-items-center justify-content-center me-3">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                        <div class="w-100">
                            <h5 class="mb-1">Clientes</h5>
                            <div class="d-flex justify-content-between">
                                <p class="mb-0">Total: <?= $data['totalClientes'] ?></p>
                                <p class="mb-0 text-info">Registrados</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- card item -->
            <div class="col mb-4">
                <div class="card d2c_currency_card_wrapper animate__animated animate__fadeInUp">
                    <div class="card-body d-flex align-items-center">
                        <div>
                            <div class="d2c_coin_icon_wrapper bg-info text-info bg-opacity-10 d-flex align-items-center justify-content-center me-3">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                        </div>
                        <div class="w-100">
                            <h5 class="mb-1">Ventas</h5>
                            <div class="d-flex justify-content-between">
                                <p class="mb-0">Total: <?= $data['totalVentas'] ?></p>
                                <p class="mb-0 text-info">Realizadas</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- card item -->
            <div class="col mb-4">
                <div class="card d2c_currency_card_wrapper animate__animated animate__fadeInUp">
                    <div class="card-body d-flex align-items-center">
                        <div>
                            <div class="d2c_coin_icon_wrapper bg-success text-success bg-opacity-10 d-flex align-items-center justify-content-center me-3">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                        </div>
                        <div class="w-100">
                            <h5 class="mb-1">Ingresos</h5>
                            <div class="d-flex justify-content-between">
                                <p class="mb-0">$<?= number_format($data['totalIngresos'], 0, ',', '.') ?></p>
                                <p class="mb-0 text-success">Total</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xxl-7 mb-4">
                <h4 class="mb-4 text-capitalize mt-3">Resumen de Ventas</h4>
                <div class="card">
                    <div class="card-body">
                        <div id="d2c_dashboard_lineChart"></div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-5 mb-4">
                <h4 class="mb-4 text-capitalize mt-3">Ventas Recientes</h4>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Cliente</th>
                                        <th>Fecha</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(!empty($data['ventasRecientes'])): ?>
                                        <?php foreach($data['ventasRecientes'] as $venta): ?>
                                        <tr>
                                            <td><?= $venta['id'] ?></td>
                                            <td><?= $venta['cliente'] ?></td>
                                            <td><?= date('d/m/Y', strtotime($venta['fecha_venta'])) ?></td>
                                            <td>$<?= number_format($venta['total'], 0, ',', '.') ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="4" class="text-center">No hay ventas registradas</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End:Main Body -->

<?php footerAdmin($data); ?>



<script>
document.addEventListener('DOMContentLoaded', function() {
    // Datos de ventas del servidor
    const ventasData = <?= json_encode($data['ventasPorMes']) ?>;
    
    // Meses en español
    const meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 
                   'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    
    // Inicializar datos con 0 para todos los meses
    const datosVentas = new Array(12).fill(0);
    
    // Procesar datos reales si existen
    if (ventasData && Array.isArray(ventasData)) {
        ventasData.forEach(function(item) {
            const mesIndex = parseInt(item.mes) - 1;
            if (mesIndex >= 0 && mesIndex < 12) {
                datosVentas[mesIndex] = parseFloat(item.total) || 0;
            }
        });
    }
    
    // Configuración del gráfico
    const options = {
        series: [{
            name: 'Ventas ($)',
            data: datosVentas
        }],
        chart: {
            type: 'area',
            height: 350,
            toolbar: {
                show: false
            }
        },
        colors: ['#007bff'],
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth',
            width: 2
        },
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.7,
                opacityTo: 0.3
            }
        },
        xaxis: {
            categories: meses
        },
        yaxis: {
            labels: {
                formatter: function (val) {
                    return '$' + Math.round(val).toLocaleString('es-CO');
                }
            }
        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return '$' + Math.round(val).toLocaleString('es-CO');
                }
            }
        },
        title: {
            text: 'Resumen de Ventas ' + new Date().getFullYear(),
            align: 'left',
            style: {
                fontSize: '16px',
                fontWeight: 'bold'
            }
        }
    };
    
    // Renderizar el gráfico
    const chartElement = document.querySelector('#d2c_dashboard_lineChart');
    if (chartElement) {
        const chart = new ApexCharts(chartElement, options);
        chart.render();
    }
});
</script>