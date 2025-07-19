<?php 
    headerAdmin($data); 
?>

<!-- Main Body-->
<div class="d2c_main px-0 px-md-2 py-4">
    <div class="container-fluid">
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
                                <p class="mb-0">Total: 150</p>
                                <p class="mb-0 text-success">+5%</p>
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
                                <p class="mb-0">Total: 45</p>
                                <p class="mb-0 text-success">+2%</p>
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
                                <p class="mb-0">Total: 120</p>
                                <p class="mb-0 text-success">+8%</p>
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
                                <p class="mb-0">$5,342.50</p>
                                <p class="mb-0 text-success">+3.5%</p>
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
                                    <tr>
                                        <td>001</td>
                                        <td>Juan Pérez</td>
                                        <td>15/06/2023</td>
                                        <td>$150.00</td>
                                    </tr>
                                    <tr>
                                        <td>002</td>
                                        <td>María López</td>
                                        <td>16/06/2023</td>
                                        <td>$250.00</td>
                                    </tr>
                                    <tr>
                                        <td>003</td>
                                        <td>Carlos Gómez</td>
                                        <td>17/06/2023</td>
                                        <td>$320.00</td>
                                    </tr>
                                    <tr>
                                        <td>004</td>
                                        <td>Ana Martínez</td>
                                        <td>18/06/2023</td>
                                        <td>$180.00</td>
                                    </tr>
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