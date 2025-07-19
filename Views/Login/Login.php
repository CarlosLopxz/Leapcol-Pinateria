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
                                <form id="formLogin" name="formLogin" class="needs-validation" novalidate>
                                    <div class="mb-3">
                                        <label class="form-label">Correo Electrónico</label>
                                        <input type="email" id="txtEmail" name="txtEmail" class="form-control" placeholder="Ingresa tu correo" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Contraseña</label>
                                        <div class="input-group">
                                            <input type="password" id="txtPassword" name="txtPassword" class="form-control border-0" placeholder="Ingresa tu contraseña" required>
                                            <button class="btn ps-0 border-0 toggle-password" type="button"><i class="far fa-eye-slash"></i></button>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="rememberMe">
                                                <label class="form-check-label text-muted" for="rememberMe">Recordarme</label>
                                            </div>
                                        </div>
                                        <div class="col text-end ps-0">
                                            <a href="#" id="btnForgotPass" class="d2c_link text-primary text-capitalize">¿Olvidaste tu contraseña?</a>
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
<!-- 
    <div class="modal fade" id="modalForgotPassword" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Recuperar Contraseña</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formResetPass" name="formResetPass">
                        <p class="text-center">Escribe el correo electrónico asociado a tu cuenta para recibir instrucciones de recuperación.</p>
                        <div class="mb-3">
                            <input type="email" class="form-control" id="txtEmailReset" name="txtEmailReset" placeholder="Correo electrónico" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" id="btnResetPass" class="btn btn-primary">Enviar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> -->

    <!-- Initial Javascript -->
    <script src="<?= BASE_URL ?>lib/jQuery/jquery-3.5.1.min.js"></script>
    <script src="<?= BASE_URL ?>lib/bootstrap_5/bootstrap.bundle.min.js"></script>
    <!-- custom js -->
    <script src="<?= BASE_URL ?>assets/js/main.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle password visibility
            document.querySelector('.toggle-password').addEventListener('click', function() {
                const passwordInput = document.getElementById('txtPassword');
                const icon = this.querySelector('i');
                
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                } else {
                    passwordInput.type = 'password';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                }
            });

            // Show forgot password modal
            document.getElementById('btnForgotPass').addEventListener('click', function(e) {
                e.preventDefault();
                const modal = new bootstrap.Modal(document.getElementById('modalForgotPassword'));
                modal.show();
            });

            // Login form submit
            document.getElementById('formLogin').addEventListener('submit', function(e) {
                e.preventDefault();
                
                const btnLogin = document.getElementById('btnLogin');
                const formData = new FormData(this);
                
                btnLogin.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Cargando...';
                btnLogin.disabled = true;
                
                fetch('<?= BASE_URL ?>login/loginUser', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status) {
                        window.location.href = '<?= BASE_URL ?>dashboard';
                    } else {
                        alert(data.msg);
                        btnLogin.innerHTML = 'Iniciar Sesión';
                        btnLogin.disabled = false;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    btnLogin.innerHTML = 'Iniciar Sesión';
                    btnLogin.disabled = false;
                });
            });

            // Reset password form submit
            document.getElementById('formResetPass').addEventListener('submit', function(e) {
                e.preventDefault();
                
                const btnResetPass = document.getElementById('btnResetPass');
                const formData = new FormData(this);
                
                btnResetPass.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Enviando...';
                btnResetPass.disabled = true;
                
                fetch('<?= BASE_URL ?>login/resetPass', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status) {
                        alert(data.msg);
                        document.getElementById('modalForgotPassword').querySelector('.btn-close').click();
                    } else {
                        alert(data.msg);
                    }
                    btnResetPass.innerHTML = 'Enviar';
                    btnResetPass.disabled = false;
                })
                .catch(error => {
                    console.error('Error:', error);
                    btnResetPass.innerHTML = 'Enviar';
                    btnResetPass.disabled = false;
                });
            });
        });
    </script>
</body>

</html>