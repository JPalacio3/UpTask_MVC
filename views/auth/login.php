<div class="contenedor login">
    <?php include_once __DIR__ . '/../templates/nombre-sitio.php' ?>


    <div class="contenedor-sm">
        <p class="descripcion-pagina">Iniciar Sesión</p>

        <?php include_once __DIR__ . '/../templates/alertas.php' ?>


        <form class="formulario" method="POST" action="/">
            <div class="campo">
                <label for="email">E mail : </label>
                <input type="email" id="email" placeholder="Escribe tu Email" name="email" />
            </div>

            <div class="campo">
                <label for="password">Password : </label>
                <input type="password" id="password" name="password" placeholder="Crea tu Password" />
            </div>

            <input type="submit" class="boton" value="Iniciar Sesión">
        </form>

        <div class="acciones">
            <a href="/crear">Regístrate con Nosotros</a>
            <a href="/olvide">¿Olvidaste tu Contraseña?</a>
        </div>
    </div>
    <!--.contenedor-sm -->
</div>