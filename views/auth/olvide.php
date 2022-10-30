<div class="contenedor olvide">
    <?php include_once __DIR__ . '/../templates/nombre-sitio.php' ?>


    <div class="contenedor-sm">
        <p class="descripcion-pagina">Recupera tu Acceso a UpTask</p>

        <form class="formulario" method="POST" action="/olvide">

            <div class="campo">
                <label for="email">E mail : </label>
                <input type="email" id="email" placeholder="Escribe tu Email" name="email" />
            </div>

            <input type="submit" class="boton" value="Enviar Instrucciones">
        </form>

        <div class="acciones">
            <a href="/">¿Ya tienes una cuenta?, Inicia Sesión</a>
            <a href="/crear">Regístrate con Nosotros</a>
        </div>
    </div>
    <!--.contenedor-sm -->
</div>