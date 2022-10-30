<?php

namespace Controllers;

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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        }

        // Render a la vista
        $router->render('auth/crear', [
            'titulo' => ' Crea Tu Cuenta'
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
    public static function restablecer()
    {
        echo 'Desde restablecer';

        if (
            $_SERVER['REQUEST_METHOD'] === 'POST'
        ) {
        }
    }

    // Mensaje de confirmación de cuenta
    public static function mensaje()
    {
        echo 'Desde Mensaje';
    }

    // Confirmación de cuenta restablecida
    public static function confirmar()
    {
        echo 'Desde Confirmar';
    }
}