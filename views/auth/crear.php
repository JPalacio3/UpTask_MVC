<div class="contenedor crear">
    <?php include_once __DIR__ . '/../templates/nombre-sitio.php' ?>





    <div class="contenedor-sm">
        <p class="descripcion-pagina">Crea tu cuenta en UpTask</p>

        <?php include_once __DIR__ . '/../templates/alertas.php' ?>

        <form class="formulario" method="POST" action="/crear">

            <div class="campo">
                <label for="nombre">Nombre : </label>
                <input type="text" id="nombre" placeholder="Escribe tu Nombre" name="nombre"
                    value="<?php echo $usuario->nombre; ?>" />
            </div>


            <div class=" campo">
                <label for="email">E mail : </label>
                <input type="email" id="email" placeholder="Escribe tu Email" name="email"
                    value="<?php echo $usuario->email; ?>" />
            </div>

            <div class=" campo">
                <label for="password">Password : </label>
                <input type="password" id="password" name="password" placeholder="Crea tu Password" />
            </div>

            <div class="campo">
                <label for="password2">Repetir Password : </label>
                <input type="password" id="password2" name="password2" placeholder="Repite tu Password" />
            </div>

            <input type="submit" class="boton" value="Crear Cuenta">
        </form>

        <div class="acciones">
            <a href="/">¿Ya tienes una cuenta?, Inicia Sesión</a>
            <a href="/olvide">¿Olvidaste tu Contraseña?</a>
        </div>
    </div>
    <!--.contenedor-sm -->
</div>