/**
 * Funciones para el login
 */

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
        
        fetch(base_url + 'login/loginUser', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status) {
                window.location.href = base_url + 'dashboard';
            } else {
                Swal.fire({
                    title: 'Error',
                    text: data.msg,
                    icon: 'error'
                });
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
        
        fetch(base_url + 'login/resetPass', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status) {
                Swal.fire({
                    title: 'Éxito',
                    text: data.msg,
                    icon: 'success'
                });
                document.getElementById('modalForgotPassword').querySelector('.btn-close').click();
                document.getElementById('formResetPass').reset();
            } else {
                Swal.fire({
                    title: 'Error',
                    text: data.msg,
                    icon: 'error'
                });
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