<?php
// Definición de constantes de conexión
define('SERVIDOR',    'localhost');
define('BASE_DATOS',  'carrito_bd');
define('USUARIO',     'root');
define('CLAVE',       '');

try {
    $pdo = new PDO(
        "mysql:host=" . SERVIDOR . ";dbname=" . BASE_DATOS . ";charset=utf8mb4",
        USUARIO,
        CLAVE,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]
    );
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}