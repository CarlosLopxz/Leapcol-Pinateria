<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?= BASE_URL ?>assets/images/logo/logo-sm.png" type="image/gif" sizes="16x16">
    <title>Error 404 - Página no encontrada</title>
    <meta name="description" content="Página no encontrada">
    <meta name="robots" content="noindex, nofollow">
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

    <section class="d2c_error d-flex align-items-center">
        <div class="container">
            <div class="d2c_error_content_wrapper position-relative">
                <img src="<?= BASE_URL ?>assets/images/error_bg.png" class="img-fluid" alt="error image">
                <div class="d2c_error_content text-center w-100">
                    <h1 class="text-primary fw-semibold">404</h1>
                    <h3 class="text-capitalize">Página no encontrada</h3>
                    <p class="text-capitalize text-muted">¡Lo sentimos! La página que estás buscando no existe.</p>
                    <a href="<?= BASE_URL ?>" class="btn btn-primary">Volver al inicio</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Initial Javascript -->
    <script src="<?= BASE_URL ?>lib/jQuery/jquery-3.5.1.min.js"></script>
    <script src="<?= BASE_URL ?>lib/bootstrap_5/bootstrap.bundle.min.js"></script>
    <!-- custom js -->
    <script src="<?= BASE_URL ?>assets/js/main.js"></script>
</body>

</html>