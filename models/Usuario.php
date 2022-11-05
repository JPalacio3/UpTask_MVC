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
        $this->token = $args['token'] ?? '';
        $this->confirmado = $args['confirmado'] ?? 0;
    }

    // VALIDAR EL LOGIN DE USUSARIOS
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

    // Hashea el password
    public function hashPassword()
    {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    // Generar un Token
    public function token()
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