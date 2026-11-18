<?php
require_once 'configuracion/base_datos.php';

$usuarios = [
    ['nombre' => 'Ana García',   'correo' => 'ana@example.com',    'contrasena' => '123456'],
    ['nombre' => 'Carlos Pérez', 'correo' => 'carlos@example.com', 'contrasena' => '123456'],
    ['nombre' => 'María López',  'correo' => 'maria@example.com',  'contrasena' => 'admin123'],
];

echo "<h2>🔐 Generación de hashes reales</h2><pre>";

foreach ($usuarios as $u) {
    $hash       = password_hash($u['contrasena'], PASSWORD_DEFAULT);
    $verificado = password_verify($u['contrasena'], $hash) ? '✅ OK' : '❌ FALLO';

    $sentencia = $pdo->prepare(
        "INSERT INTO usuarios (nombre, correo, contrasena)
         VALUES (?, ?, ?)
         ON DUPLICATE KEY UPDATE nombre = VALUES(nombre), contrasena = VALUES(contrasena)"
    );
    $sentencia->execute([$u['nombre'], $u['correo'], $hash]);

    echo "Usuario: {$u['nombre']}\n";
    echo "Correo:  {$u['correo']}\n";
    echo "Clave:   {$u['contrasena']}\n";
    echo "Hash:    {$hash}\n";
    echo "Verificación: {$verificado}\n";
    echo str_repeat('-', 55) . "\n";
}

echo "</pre><p>⚠️ <strong>Elimina este archivo después de ejecutarlo.</strong></p>";