<!-- Main sidebar -->
<div class="d2c_sidebar offcanvas-lg offcanvas-start p-4" tabindex="-1" id="d2c_sidebar">
    <div class="d-flex flex-column">
        <!-- Logo -->
        <a href="<?= BASE_URL ?>dashboard" class="brand-icon">
            <img class="navbar-brand" src="<?= BASE_URL ?>assets/images/logo/logo.png" alt="logo">
        </a>
        <!-- End:Logo -->

        <!-- Menu -->
        <ul class="navbar-nav flex-grow-1">
            <!-- Menu Item -->
            <li class="nav-item">
                <h6 class="d2c_nav_title">Menu</h6>
                <!-- Sub Menu -->
                <ul class="sub-menu">
                    <!-- Dashboard siempre visible -->
                    <li class="nav-item <?= (isset($data['page_name']) && $data['page_name'] == 'dashboard') ? 'active' : '' ?>">
                        <a class="sub-menu-link" href="<?= BASE_URL ?>dashboard">
                            <span class="d2c_icon">
                                <i class="fas fa-home"></i>
                            </span>
                            <span> Inicio </span>
                        </a>
                    </li>

                    <?php 
                    // Obtener módulos del usuario
                    $userModules = getUserModules();
                    $mainModules = ['categorias', 'productos', 'produccion', 'clientes', 'proveedores', 'compras', 'pos', 'ventas', 'caja'];
                    
                    foreach($userModules as $module): 
                        if(in_array($module['url'], $mainModules)):
                    ?>
                    <li class="nav-item <?= (isset($data['page_name']) && $data['page_name'] == $module['url']) ? 'active' : '' ?>">
                        <a class="sub-menu-link" href="<?= BASE_URL ?><?= $module['url'] ?>">
                            <span class="d2c_icon">
                                <i class="<?= $module['icono'] ?>"></i>
                            </span>
                            <span> <?= $module['nombre'] ?> </span>
                        </a>
                    </li>
                    <?php 
                        endif;
                    endforeach; 
                    ?>
                </ul>
                <!-- End:Sub Menu -->
            </li>
            <!-- End:Menu Item -->

            <?php 
            // Verificar si tiene módulos de administración
            $adminModules = ['usuarios', 'roles', 'reportes'];
            $hasAdminModules = false;
            foreach($userModules as $module) {
                if(in_array($module['url'], $adminModules)) {
                    $hasAdminModules = true;
                    break;
                }
            }
            
            if($hasAdminModules): 
            ?>
            <!-- Menu Item -->
            <li class="nav-item">
                <h6 class="d2c_nav_title">Administración</h6>

                <!-- Sub Menu -->
                <ul class="sub-menu collapse show" id="admin">
                    <?php 
                    foreach($userModules as $module): 
                        if(in_array($module['url'], $adminModules)):
                    ?>
                    <li class="nav-item <?= (isset($data['page_name']) && $data['page_name'] == $module['url']) ? 'active' : '' ?>">
                        <a class="sub-menu-link" href="<?= BASE_URL ?><?= $module['url'] ?>">
                            <span class="d2c_icon">
                                <i class="<?= $module['icono'] ?>"></i>
                            </span>
                            <span> <?= $module['nombre'] ?> </span>
                        </a>
                    </li>
                    <?php 
                        endif;
                    endforeach; 
                    ?>
                </ul>
                <!-- End:Sub Menu -->
            </li>
            <!-- End:Menu Item -->
            <?php endif; ?>
        </ul>
        <!-- End:Menu -->

        <!-- Theme Mode -->
        <div class="card d2c_switch_card">
            <div class="card-body">
                <ul class="navbar-nav">
                    <!-- User Profile Item -->
                    <li class="nav-item clearfix mb-4">
                        <div class="float-start me-2">
                            <a href="<?= BASE_URL ?>perfil"><img class="w-100 rounded" src="<?= BASE_URL ?>assets/images/avatar/user.png" alt="Profile Image" style="height: 3rem; width: 3rem; object-fit: cover"></a>
                        </div>
                        <div class="float-start">
                            <h6 class="mb-1"><a href="<?= BASE_URL ?>perfil">
                                <?php if(isset($_SESSION['userData'])): ?>
                                    <?= $_SESSION['userData']['nombre'] . ' ' . $_SESSION['userData']['apellido'] ?>
                                <?php else: ?>
                                    Usuario
                                <?php endif; ?>
                            </a></h6>
                            <p class="mb-0 badge bg-primary text-white">
                                <?php if(isset($_SESSION['userData'])): ?>
                                    <?= $_SESSION['userData']['nombrerol'] ?>
                                <?php else: ?>
                                    Sin rol
                                <?php endif; ?>
                            </p>
                        </div>
                    </li>
                  
                    <!-- Logout Item -->
                    <li class="nav-item mt-3">
                        <a href="<?= BASE_URL ?>logout" class="btn btn-danger w-100 d-flex align-items-center justify-content-center">
                            <i class="fas fa-sign-out-alt me-2"></i>
                            <span>Cerrar Sesión</span>
                        </a>
                    </li>
                    <!-- End:Logout Item -->
                </ul>
            </div>
        </div>
        <!-- End:Theme Mode -->
    </div>
</div>
<!-- End:Sidebar -->