<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController
{
    //login
    public static function login(Router $router)
    {
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = new Usuario($_POST);

            $alertas = $usuario->validarLogin();

            if (empty($alertas)) {
                // Verificar que el usuario exista
                $usuario = Usuario::where('email', $usuario->email);

                if (!$usuario || !$usuario->confirmado == '1') {
                    Usuario::setAlerta('error', 'El Usuario No está registrado o No está Validado');
                } else {
                    // El usuario existe
                    if (password_verify($_POST['password'], $usuario->password)) {
                        // Iniciar la sesión del usuario
                        session_start();
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        // Redireccionar
                        header('Location: /dashboard');
                    } else {
                        Usuario::setAlerta('error', 'Contraseña Incorrecta');
                    }
                }
            }
        }

        $alertas = Usuario::getAlertas();

        // render a la vista
        $router->render('auth/login', [
            'titulo' => '🔐 Iniciar Sesión 🔐',
            'alertas' => $alertas
        ]);
    }

    //logout
    public static function logout()
    {
        session_start();
        $_SESSION = [];
        header('Location: /');
    }

    // Crear cuenta
    public static function crear(Router $router)
    {
        $alertas = [];
        $usuario = new Usuario;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);

            $alertas = $usuario->validarNuevaCuenta();


            if (empty($alertas)) {
                $existeUsuario = Usuario::where('email', $usuario->email);

                if ($existeUsuario) {
                    Usuario::setAlerta('error', ' El Usuario ya está Registrado');
                    $alertas = Usuario::getAlertas();
                } else {
                    // Hashear el password
                    $usuario->hashPassword();

                    //Eliminar Paswword2
                    unset($usuario->password2);

                    //Crear un Token
                    $usuario->token();

                    //Crer un nuevo usuario
                    $resultado = $usuario->guardar();

                    // Enviar Email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarConfirmacion();



                    if ($resultado) {
                        header(('Location: /mensaje'));
                    }
                }
            }

            // debuguear($alertas);
        }

        // Render a la vista
        $router->render('auth/crear', [
            'titulo' => 'Crea Tu Cuenta',
            'usuario' => $usuario,
            'alertas' => $alertas,
        ]);
    }

    // Olvidé Password
    public static function olvide(Router $router)
    {
        $alertas = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = new Usuario($_POST);
            $alertas = $usuario->validarEmail();

            if (empty($alertas)) {
                // Buscar al usuario
                $usuario = Usuario::where('email', $usuario->email);

                if ($usuario && $usuario->confirmado === "1") {

                    // Generar un nuevo Token
                    $usuario->token();

                    // Actualizar el usuario
                    $usuario->guardar();

                    // Enviar el Email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();

                    // Imprimir la alerta
                    Usuario::setAlerta('exito', 'Hemos enviado a tu email las instrucciones para que restablezcas tu contraseña');
                } else {
                    Usuario::setAlerta('error', 'El Usuario NO está registrado o NO ha sido confirmado');
                }
            }
        }
        $alertas = Usuario::getAlertas();

        // Render a la vista
        $router->render('auth/olvide', [
            'titulo' => ' Recupera tu Contraseña',
            'alertas' => $alertas
        ]);
    }

    //Restablecer el Password
    public static function restablecer(Router $router)
    {
        $token = s($_GET['token']);
        $mostrar = true;

        if (!$token) header('Location: /');

        // Identificar el ususario con este token
        $usuario = Usuario::where('token', $token);

        if (empty($usuario)) {
            Usuario::setAlerta('error', 'Tan chistoso que te ves tratando de adivinar la contraseña 🤣😂');
            $mostrar = false;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Añadir el nuevo password
            $usuario->sincronizar($_POST);

            //Validar el password
            $alertas = $usuario->validarPassword();

            if (empty($alertas)) {

                // Hashear el nuevo password
                $usuario->hashPassword();

                // Eliminar el Token
                $usuario->token = null;

                // Guardar el usuario en la base de datos
                $resultado = $usuario->guardar();

                // Redireccionar
                if ($resultado) {
                    header('Location: /');
                }
            }
        }

        $alertas = Usuario::getAlertas();

        // Render a la vista
        $router->render('auth/restablecer', [
            'titulo' => 'Restablece tu Contraseña',
            'alertas' => $alertas,
            'mostrar' => $mostrar
        ]);
    }

    // Mensaje de confirmación de cuenta
    public static function mensaje(Router $router)
    {
        // Render a la vista
        $router->render('auth/mensaje', [
            'titulo' => 'Cuenta Creada'
        ]);
    }

    // Confirmación de cuenta restablecida
    public static function confirmar(Router $router)
    {
        // Leer el token de la URL
        $token = s($_GET['token']);
        if (!$token) header('Location: /');

        // Encontrar al usuario con su token
        $usuario = Usuario::where('token', $token);
        if (empty($usuario)) {
            // No se encoentró usuario con ese Token
            Usuario::setAlerta('error', 'Usuario Inexistente');
        } else {
            // Confirmar la cuenta
            $usuario->confirmado = 1;
            $usuario->token = NULL;
            unset($usuario->password2);

            //GUARDA EL USUARIO CONFIRMADO EN LA BD
            $usuario->guardar();

            //Alerta de éxito
            Usuario::setAlerta('exito', 'Usuario Confirmado Correctamente');
        }


        $alertas = Usuario::getAlertas();


        // Render a la vista
        $router->render('auth/confirmar', [
            'titulo' => 'Confirmación de cuenta en UpTask',
            'alertas' => $alertas
        ]);
    }
}