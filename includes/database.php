<?php

$host = 'localhost';
$user = 'root';
$password = '';
$db = 'uptaskMVC';

$db = mysqli_connect($host, $user, $password, $db);


if (!$db) {
    echo "Error: No se pudo conectar a MySQL.";
    echo "errno de depuración: " . mysqli_connect_errno();
    echo "error de depuración: " . mysqli_connect_error();
    exit;
}