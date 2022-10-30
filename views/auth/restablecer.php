<div class="contenedor restablecer">
    <?php include_once __DIR__ . '/../templates/nombre-sitio.php' ?>


    <div class="contenedor-sm">
        <p class="descripcion-pagina">Escribe tu Nueva Contraseña</p>

        <form class="formulario" method="POST" action="/restablecer">

            <div class="campo">
                <label for="password">Contraseña : </label>
                <input type="password" id="password" name="password" placeholder="Crea tu Nueva Contraseña" />
            </div>

            <input type="submit" class="boton" value="Guardar Contraseña">
        </form>

        <div class="acciones">
            <a href="/">¿Ya tienes una cuenta?, Inicia Sesión</a>
            <a href="/crear">Regístrate con Nosotros</a>
        </div>
    </div>
    <!--.contenedor-sm -->
</div>