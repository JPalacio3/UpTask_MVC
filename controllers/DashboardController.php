<?php

namespace Controllers;

use MVC\Router;
use Model\Proyecto;


class DashboardController
{
    public static function index(Router $router)
    {
        session_start();
        isAuth();

        $router->render('/dashboard/index', [
            'titulo' => 'Proyectos'
        ]);
    }

    public static function crear_proyecto(Router $router)
    {

        session_start();
        isAuth();
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $proyecto = new Proyecto($_POST);

            // Validación
            $alertas = $proyecto->validarProyecto();

            if (empty($alertas)) {

                // Generar una URL único
                $hash = md5(uniqid());
                $proyecto->url = $hash;

                // Almacenar al creador del proyecto
                $proyecto->propietarioId = $_SESSION['id'];

                // Guardar el proyecto
                $proyecto->guardar();

                // Redireccionar
                header('Location: /proyecto?dir%=' . $proyecto->url . '#%');
            }
        }

        $router->render('/dashboard/crear-proyecto', [
            'titulo' => 'Crear Proyecto',
            'alertas' => $alertas
        ]);
    }

    public static function proyecto(Router $router)
    {
        session_start();
        isAuth();
        $alertas = [];

        // Revisar que la persona que visita el proyecto, es quien lo creó
        $token = $_GET['dir%'];
        if (!$token) header('Location: /dashboard');

        $proyecto = Proyecto::where('url', $token);

        if ($proyecto->propietarioId !== $_SESSION['id']) {
            header('Location: /dashboard');
        }

        $router->render('/dashboard/proyecto', [
            'titulo' => $proyecto->proyecto,
            'alertas' => $alertas
        ]);
    }


    public static function perfil(Router $router)
    {
        session_start();
        isAuth();

        $router->render('/dashboard/perfil', [
            'titulo' => 'Mi Perfil'
        ]);
    }
}