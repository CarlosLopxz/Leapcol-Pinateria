<?php
/**
 * Modal de Perfil de Usuario
 */
?>
<!-- Modal Perfil -->
<div class="modal fade" id="modalPerfil" tabindex="-1" aria-labelledby="modalPerfilLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalPerfilLabel">Perfil de Usuario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formPerfil" name="formPerfil">
          <div class="mb-3">
            <label for="txtNombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="txtNombre" name="txtNombre" value="Usuario Demo">
          </div>
          <div class="mb-3">
            <label for="txtEmail" class="form-label">Email</label>
            <input type="email" class="form-control" id="txtEmail" name="txtEmail" value="usuario@pinateria.com">
          </div>
          <div class="mb-3">
            <label for="txtPassword" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="txtPassword" name="txtPassword">
            <small class="text-muted">Dejar en blanco si no desea cambiar la contraseña</small>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btnGuardarPerfil">Guardar Cambios</button>
      </div>
    </div>
  </div>
</div>