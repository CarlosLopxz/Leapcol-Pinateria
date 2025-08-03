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
        <div class="text-center mb-5">
            <h2 class="mb-3">Bienvenido a <?= NOMBRE_EMPRESA ?></h2>
            <div class="mb-4">
                <h4 class="text-primary" id="currentTime"></h4>
                <p class="text-muted" id="currentDate"></p>
            </div>
            <p class="text-muted">Selecciona un módulo para comenzar</p>
        </div>

        <!-- Módulos disponibles -->
        <div class="row justify-content-center">
            <?php if(!empty($data['userModules'])): ?>
                <?php foreach($data['userModules'] as $module): ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body text-center d-flex flex-column">
                            <div class="mb-3">
                                <i class="<?= $module['icono'] ?> fa-3x text-primary"></i>
                            </div>
                            <h5 class="card-title"><?= $module['nombre'] ?></h5>
                            <p class="card-text text-muted flex-grow-1"><?= $module['descripcion'] ?></p>
                            <a href="<?= BASE_URL ?><?= $module['url'] ?>" class="btn btn-primary mt-auto">
                                Acceder
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        No tienes permisos para acceder a ningún módulo del sistema.
                        <br>Contacta al administrador para obtener los permisos necesarios.
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Información del usuario -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Información de tu cuenta</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Nombre:</strong> <?= $_SESSION['userData']['nombre'] . ' ' . $_SESSION['userData']['apellido'] ?></p>
                                <p><strong>Email:</strong> <?= $_SESSION['userData']['email'] ?></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Rol:</strong> <?= $_SESSION['userData']['nombrerol'] ?></p>
                                <p><strong>Módulos disponibles:</strong> <?= count($data['userModules']) ?></p>
                            </div>
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
function updateDateTime() {
    const now = new Date();
    
    // Formatear hora
    const timeOptions = {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: true
    };
    const timeString = now.toLocaleTimeString('es-CO', timeOptions);
    
    // Formatear fecha
    const dateOptions = {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    };
    const dateString = now.toLocaleDateString('es-CO', dateOptions);
    
    document.getElementById('currentTime').textContent = timeString;
    document.getElementById('currentDate').textContent = dateString;
}

// Actualizar cada segundo
setInterval(updateDateTime, 1000);
// Ejecutar inmediatamente
updateDateTime();
</script>