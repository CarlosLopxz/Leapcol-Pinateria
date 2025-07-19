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

    // Login form submit
    const formLogin = document.getElementById('formLogin');
    if (formLogin) {
        formLogin.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validar campos
            const email = document.getElementById('txtEmail').value;
            const password = document.getElementById('txtPassword').value;
            
            if (!email || !password) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Campos incompletos',
                    text: 'Por favor complete todos los campos',
                    confirmButtonText: 'Entendido',
                    confirmButtonColor: '#3557D4'
                });
                return;
            }
            
            // Validar formato de email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Formato incorrecto',
                    text: 'Por favor ingrese un correo electrónico válido',
                    confirmButtonText: 'Entendido',
                    confirmButtonColor: '#3557D4'
                });
                return;
            }
            
            const btnLogin = document.getElementById('btnLogin');
            const formData = new FormData(this);
            
            btnLogin.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Cargando...';
            btnLogin.disabled = true;
            
            // Mostrar datos que se envían
            console.log('Enviando datos:');
            for (let pair of formData.entries()) {
                console.log(pair[0] + ': ' + pair[1]);
            }
            
            // Realizar la petición fetch
            fetch(base_url + 'login/loginUser', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                console.log('Respuesta recibida:', response);
                return response.json();
            })
            .then(data => {
                console.log('Datos recibidos:', data);
                if (data.status) {
                    window.location.href = base_url + 'dashboard';
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Credenciales incorrectas',
                        text: data.msg || 'El correo o la contraseña son incorrectos',
                        confirmButtonText: 'Intentar de nuevo',
                        confirmButtonColor: '#3557D4'
                    });
                }
                btnLogin.innerHTML = 'Iniciar Sesión';
                btnLogin.disabled = false;
            })
            .catch(error => {
                console.error('Error en la petición:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error de conexión',
                    text: 'No se pudo conectar con el servidor',
                    confirmButtonText: 'Intentar de nuevo',
                    confirmButtonColor: '#3557D4'
                });
                btnLogin.innerHTML = 'Iniciar Sesión';
                btnLogin.disabled = false;
            });
        });
    }
});