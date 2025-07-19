<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?= BASE_URL ?>assets/images/logo/logo-sm.png" type="image/gif" sizes="16x16">
    <title><?= $data['page_tag'] ?></title>
    <meta name="description" content="Sistema de gestión para piñatería">
    <meta name="robots" content="index, follow">
    <!-- bootstrap css link -->
    <link rel="stylesheet" href="<?= BASE_URL ?>lib/bootstrap_5/bootstrap.min.css">
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="<?= BASE_URL ?>lib/fontawesome/css/all.min.css">
    <!-- main css -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/global.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
    <!-- responsive css -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/responsive.css">
</head>

<body class="d2c_theme_light">
    <!-- Preloader Start -->
    <div class="preloader">
        <img src="<?= BASE_URL ?>assets/images/logo/logo.png" alt="<?= NOMBRE_EMPRESA ?>">
    </div>
    <!-- Preloader End -->

    <!-- Main Body-->
    <section class="d2c_login_system d-flex align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-xl-10 offset-xl-1">
                    <div class="row">
                        <div class="col-lg-6 pe-lg-0 d2c_login_left">
                            <div class="d2c_login_wrapper">
                                <div class="text-center mb-4">
                                    <h4 class="text-capitalize">Bienvenido a <?= NOMBRE_EMPRESA ?></h4>
                                    <p class="text-muted">Inicia sesión para acceder al sistema</p>
                                </div>
                                <form id="formLogin" name="formLogin" class="needs-validation" method="post" onsubmit="return false;" novalidate>
                                    <div class="mb-3">
                                        <label class="form-label">Correo Electrónico</label>
                                        <input type="email" id="txtEmail" name="txtEmail" class="form-control" placeholder="Ingresa tu correo" required>
                                        <div class="invalid-feedback">
                                            Por favor ingrese un correo electrónico válido.
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Contraseña</label>
                                        <div class="input-group has-validation">
                                            <input type="password" id="txtPassword" name="txtPassword" class="form-control border-0" placeholder="Ingresa tu contraseña" required>
                                            <button class="btn ps-0 border-0 toggle-password" type="button"><i class="far fa-eye-slash"></i></button>
                                            <div class="invalid-feedback">
                                                Por favor ingrese su contraseña.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <button type="submit" id="btnLogin" class="btn btn-primary w-100 text-uppercase">Iniciar Sesión</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- login right image -->
                        <div class="col-lg-6 d2c_login_right_image"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End:Main Body -->

    <!-- Initial Javascript -->
    <script src="<?= BASE_URL ?>lib/jQuery/jquery-3.5.1.min.js"></script>
    <script src="<?= BASE_URL ?>lib/bootstrap_5/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- custom js -->
    <script>
        const base_url = "<?= BASE_URL ?>";
    </script>
    <script src="<?= BASE_URL ?>assets/js/main.js"></script>
    <script src="<?= BASE_URL ?>assets/js/functions_login.js"></script>
</body>

</html>