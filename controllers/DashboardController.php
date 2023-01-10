<?php

namespace Controllers;

use MVC\Router;
use Model\Usuario;
use Model\Proyecto;


class DashboardController
{
    public static function index(Router $router)
    {
        session_start();
        isAuth();

        $id = $_SESSION['id'];

        $proyectos = Proyecto::belongsTo('propietarioId', $id);

        $router->render('/dashboard/index', [
            'titulo' => 'Proyectos',
            'proyectos' => $proyectos
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

                // Generar una URL única
                $hash = md5(uniqid());
                $proyecto->url = $hash;

                // Almacenar al creador del proyecto
                $proyecto->propietarioId = $_SESSION['id'];

                // Guardar el proyecto
                $proyecto->guardar();

                // Redireccionar
                header('Location: /proyecto?id=' . $proyecto->url);
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

        $token = $_GET['id'];
        if (!$token) header('Location: /dashboard');
        // Revisar que la persona que visita el proyecto, es quien lo creo
        $proyecto = Proyecto::where('url', $token);
        if ($proyecto->propietarioId !== $_SESSION['id']) {
            header('Location: /dashboard');
        }

        $router->render('dashboard/proyecto', [
            'titulo' => $proyecto->proyecto
        ]);
    }


    public static function perfil(Router $router)
    {
        session_start();
        isAuth();
        $usuario = Usuario::find($_SESSION['id']);
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validar_perfil();

            if(empty($alertas)){
                // anates de guardar el ususario, verificamos que el correo nuevo no se encuentre ya registrado en la base de datos con otro usuario:
                $existeUsuario = Usuario::where('email', $usuario->email);

                if($existeUsuario && $existeUsuario->id !== $usuario->id){
                    // Mensaje de error
                Usuario::setAlerta('error', 'Correo electrónico ya existe');
                $alertas = $usuario->getAlertas();

                }else {

                    // Guardar el usuario
                $usuario->guardar();

                //Asignar el nombre nuevo a la barra
                $_SESSION['nombre'] = $usuario->nombre;

                //Alerta de actualización correcta
                Usuario::setAlerta('exito', 'Guardado Correctamente');
                $alertas = $usuario->getAlertas();
                }


            }
        }

        $router->render('/dashboard/perfil', [
            'titulo' => 'Mi Perfil',
            'usuario' => $usuario,
            'alertas' => $alertas

            ]);
        }

    public static function cambiar_password(Router $router) {
        session_start();
        isAuth();
        $alertas = [];

        if($_SERVER['REQUEST_METHOD']==='POST'){
            $usuario = Usuario::find($_SESSION['id']);

            //Sincronizar con los datos del usuario
            $usuario->sincronizar($_POST);
            $alertas = $usuario->nuevo_password();

            if(empty($alertas)) {
                $resultado = $usuario->comprobar_password();

                if($resultado) {
                    // Asignar el nuevo password
                    $usuario->password = $usuario->password_nuevo;

                     // Eliminar el password actual
                    unset($usuario->password_actual);
                    unset($usuario->password_nuevo);

                    //Hashear el nuevo password
                    $usuario->hashPassword();

                    // Actualizar el nuevo password
                    $resultado =  $usuario->guardar();

                    if($resultado) {
                        Usuario::setAlerta('exito', 'Has actualizado tu contraseña correctamente');
                    $alertas = $usuario->getAlertas();
                    }
                }else {
                    Usuario::setAlerta('error', 'Password Incorrecto');
                    $alertas = $usuario->getAlertas();
                }
            }



        }

        $router->render('dashboard/cambiar_password', [
            'titulo' => 'Cambiar Password',
            'alertas' => $alertas
            ]);
                }
    }