<?php

namespace Controllers;

use Model\Usuario;
use MVC\Router;

class LoginController
{
    //login
    public static function login(Router $router)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        }

        // render a la vista
        $router->render('auth/login', [
            'titulo' => 'Iniciar Sesión'
        ]);
    }

    //logout
    public static function logout()
    {
        echo 'Desde Logout';
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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        }

        // Render a la vista
        $router->render('auth/olvide', [
            'titulo' => ' Recupera tu Contraseña'
        ]);
    }

    //Restablecer el Password
    public static function restablecer(Router $router)
    {

        if (
            $_SERVER['REQUEST_METHOD'] === 'POST'
        ) {
        }

        // Render a la vista
        $router->render('auth/restablecer', [
            'titulo' => 'Restablece tu Contraseña'
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
        // Render a la vista
        $router->render('auth/confirmar', [
            'titulo' => 'Confirmación de cuenta en UpTask'
        ]);
    }
}