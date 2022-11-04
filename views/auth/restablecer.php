<div class="contenedor restablecer">
    <?php include_once __DIR__ . '/../templates/nombre-sitio.php' ?>


    <div class="contenedor-sm">

        <p class="descripcion-pagina">Escribe tu Nueva Contraseña</p>

        <?php include_once __DIR__ . '/../templates/alertas.php' ?>

        <?php if ($mostrar) { ?>

        <form class="formulario" method="POST">

            <div class="campo">
                <label for="password">Contraseña : </label>
                <input type="password" id="password" name="password" placeholder="Crea tu Nueva Contraseña" />
            </div>

            <input type="submit" class="boton" value="Guardar Contraseña">
        </form>

        <?php } ?>
        <div class="acciones">
            <a href="/">¿Ya tienes una cuenta?, Inicia Sesión</a>
            <a href="/crear">Regístrate con Nosotros</a>
        </div>
    </div>
    <!--.contenedor-sm -->
</div>