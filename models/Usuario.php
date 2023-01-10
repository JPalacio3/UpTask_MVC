<?php

namespace Model;

class Usuario extends ActiveRecord
{
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'email', 'password', 'token', 'confirmado'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->password2 = $args['password2'] ?? null;
        $this->password_actual = $args['password_actual'] ?? null;
        $this->password_nuevo = $args['password_nuevo'] ?? null;
        $this->token = $args['token'] ?? '';
        $this->confirmado = $args['confirmado'] ?? 0;
    }

    // VALIDAR EL LOGIN DE USUARIOS
    public function validarLogin()
    {
        if (!$this->email) {
            self::$alertas['error'][] = 'El Email es Obligatorio';
        }

        if (!$this->password) {
            self::$alertas['error'][] = 'La Contraseña NO puede ir vacía';
        }
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'Email NO Válido';
        }

        return self::$alertas;
    }


    // Validación para cuentas nuevas:
    public function validarNuevaCuenta()
    {
        if (!$this->nombre) {
            self::$alertas['error'][] = 'El Nombre de Usuario es Obligatorio';
        }

        if (!$this->email) {
            self::$alertas['error'][] = 'El Email es Obligatorio';
        }

        if (!$this->password) {
            self::$alertas['error'][] = 'La Contraseña NO puede ir vacía';
        }

        if (strlen($this->password) < 8) {
            self::$alertas['error'][] = 'La Contraseña debe tener al menos 8 carácteres';
        }

        if ($this->password !== $this->password2) {
            self::$alertas['error'][] = ' Las Contraseñas NO coinciden';
        }
        return self::$alertas;
    }

    // Validar password nuevo en cambio de contraseña
    public function nuevo_password(): array
    {
        if (!$this->password_actual) {
            self::$alertas['error'][] = 'El password actual NO puede ir vacío';
        }
        if (!$this->password_nuevo) {
            self::$alertas['error'][] = 'El password Nuevo NO puede ir vacío';
        }
        if (strlen($this->password_nuevo) < 8) {
            self::$alertas['error'][] = 'El passwowrd Nuevo debe tener una extensión de mínimo 8 caracteres';
        }
        return self::$alertas;

        if (empty($alertas)) {
            $resultado = $usuario->comprobar_password();
        }
    }

    // Comprobar el password anterior desde la base de datos
    public function comprobar_password(): bool
    {
        return password_verify($this->password_actual, $this->password);
    }

    // Hashea el password
    public function hashPassword(): void
    {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    // Generar un Token
    public function token(): void
    {
        $this->token = md5(uniqid());
    }

    // Validar un Email
    public function validarEmail()
    {
        if (!$this->email) {
            self::$alertas['error'][] = 'Es Obligatorio que escribas tu Email';
        }
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'Email NO Válido';
        }
        return self::$alertas;
    }

    // Valida el usuario antes de enviarlo a la base de datos:
    public function validar_perfil()
    {
        if (!$this->nombre) {
            self::$alertas['error'][] = 'El Nombre es Obligatorio';
        }
        if (!$this->email) {
            self::$alertas['error'][] = 'El Email es Obligatorio';
        }
        return self::$alertas;
    }

    // Valida el password en restablecer
    public function validarPassword()
    {
        if (!$this->password) {
            self::$alertas['error'][] = 'La Contraseña NO puede ir vacía';
        }

        if (strlen($this->password) < 8) {
            self::$alertas['error'][] = 'La Contraseña debe tener al menos 8 carácteres';
        }
        return self::$alertas;
    }
}