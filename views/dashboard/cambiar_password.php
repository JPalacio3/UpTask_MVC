<?php include_once __DIR__ . '/header-dashboard.php'; ?>

<div class="contenedor-sm">
    <?php include_once __DIR__ . '/../templates/alertas.php'; ?>

      <a href="/perfil" class="enlace">Volver</a>

    <form class="formulario" method="POST" action="/cambiar_password">
        <div class="campo">
            <label for="nombre">Password Actual: </label>
             <input type="password" name="password_actual" placeholder="Tu password actual" />
        </div>

        <div class="campo">
            <label for="nombre">Password Nuevo: </label>
            <input type="password" name="password_nuevo" placeholder="Escribe tu password nuevo" />
        </div>
        <input type="submit" value="Guardar Cambios">
    </form>
</div>

<?php include_once __DIR__ . '/footer-dashboard.php'; ?>
