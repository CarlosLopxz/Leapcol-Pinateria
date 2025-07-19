<?php 
headerAdmin($data); 
?>

<!-- Main Body-->
<div class="d2c_main px-0 px-md-2 py-4">
    <div class="container-fluid">
        <!-- Title -->
        <p class="mb-1">Bienvenido, <?= $_SESSION['userData']['nombre'] . ' ' . $_SESSION['userData']['apellido']; ?></p>
        <h4 class="mb-4 text-capitalize">Piñatería - Panel de Control</h4>
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
                                <p class="mb-0">150 productos</p>
                                <p class="mb-0 text-success">+5 nuevos</p>
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
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                        </div>
                        <div class="w-100">
                            <h5 class="mb-1">Ventas</h5>
                            <div class="d-flex justify-content-between">
                                <p class="mb-0">45 ventas</p>
                                <p class="mb-0 text-success">+12%</p>
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
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                        <div class="w-100">
                            <h5 class="mb-1">Clientes</h5>
                            <div class="d-flex justify-content-between">
                                <p class="mb-0">78 clientes</p>
                                <p class="mb-0 text-success">+8 nuevos</p>
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
                                <p class="mb-0">$5,240.00</p>
                                <p class="mb-0 text-success">+15%</p>
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
                            <div class="d2c_coin_icon_wrapper bg-danger text-danger bg-opacity-10 d-flex align-items-center justify-content-center me-3">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                        </div>
                        <div class="w-100">
                            <h5 class="mb-1">Eventos</h5>
                            <div class="d-flex justify-content-between">
                                <p class="mb-0">12 eventos</p>
                                <p class="mb-0 text-success">+3 nuevos</p>
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
                <h4 class="mb-4 text-capitalize mt-3">Productos Populares</h4>
                <!-- Tabla de productos populares -->
                <div class="card">
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Ventas</th>
                                    <th>Precio</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Piñata Superhéroes</td>
                                    <td>45</td>
                                    <td>$350.00</td>
                                </tr>
                                <tr>
                                    <td>Piñata Princesas</td>
                                    <td>38</td>
                                    <td>$320.00</td>
                                </tr>
                                <tr>
                                    <td>Globos Metálicos</td>
                                    <td>120</td>
                                    <td>$25.00</td>
                                </tr>
                                <tr>
                                    <td>Dulces Surtidos</td>
                                    <td>200</td>
                                    <td>$150.00</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php footerAdmin($data); ?>