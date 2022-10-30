<div class="contenedor login">
    <h1 class="uptask">UpTask</h1>
    <h4 class="tagline">Crea y Administra tus Proyectos</h4>


    <div class="contenedor-sm">
        <p class="descripcion-pagina">Iniciar Sesión</p>

        <form class="formulario" method="POST" action="/">
            <div class="campo">
                <label for="email">E mail : </label>
                <input type="email" id="email" placeholder="Escribe tu email" name="email" />
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