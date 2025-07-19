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
                                    <h4 class="text-capitalize">Cambiar Contraseña</h4>
                                    <p class="text-muted">Ingresa tu nueva contraseña</p>
                                </div>
                                <form id="formCambiarPass" name="formCambiarPass" class="needs-validation" novalidate>
                                    <input type="hidden" id="idUsuario" name="idUsuario" value="<?= $data['idpersona'] ?>">
                                    <input type="hidden" id="txtEmail" name="txtEmail" value="<?= $data['email'] ?>">
                                    <input type="hidden" id="txtToken" name="txtToken" value="<?= $data['token'] ?>">
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Nueva Contraseña</label>
                                        <div class="input-group">
                                            <input type="password" id="txtPassword" name="txtPassword" class="form-control border-0" placeholder="Ingresa tu nueva contraseña" required>
                                            <button class="btn ps-0 border-0 toggle-password" type="button" data-input="txtPassword"><i class="far fa-eye-slash"></i></button>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Confirmar Contraseña</label>
                                        <div class="input-group">
                                            <input type="password" id="txtPasswordConfirm" name="txtPasswordConfirm" class="form-control border-0" placeholder="Confirma tu nueva contraseña" required>
                                            <button class="btn ps-0 border-0 toggle-password" type="button" data-input="txtPasswordConfirm"><i class="far fa-eye-slash"></i></button>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <button type="submit" id="btnChangePassword" class="btn btn-primary w-100 text-uppercase">Guardar Contraseña</button>
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
    <!-- custom js -->
    <script src="<?= BASE_URL ?>assets/js/main.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle password visibility
            document.querySelectorAll('.toggle-password').forEach(button => {
                button.addEventListener('click', function() {
                    const inputId = this.getAttribute('data-input');
                    const passwordInput = document.getElementById(inputId);
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
            });

            // Change password form submit
            document.getElementById('formCambiarPass').addEventListener('submit', function(e) {
                e.preventDefault();
                
                const btnChangePassword = document.getElementById('btnChangePassword');
                const password = document.getElementById('txtPassword').value;
                const passwordConfirm = document.getElementById('txtPasswordConfirm').value;
                
                if (password !== passwordConfirm) {
                    alert('Las contraseñas no coinciden');
                    return;
                }
                
                const formData = new FormData(this);
                
                btnChangePassword.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Guardando...';
                btnChangePassword.disabled = true;
                
                fetch('<?= BASE_URL ?>login/setPassword', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status) {
                        alert(data.msg);
                        window.location.href = '<?= BASE_URL ?>login';
                    } else {
                        alert(data.msg);
                        btnChangePassword.innerHTML = 'Guardar Contraseña';
                        btnChangePassword.disabled = false;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    btnChangePassword.innerHTML = 'Guardar Contraseña';
                    btnChangePassword.disabled = false;
                });
            });
        });
    </script>
</body>

</html>