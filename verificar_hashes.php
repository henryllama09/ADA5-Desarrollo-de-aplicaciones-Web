<?php
require_once 'configuracion/base_datos.php';

echo "<h2>🔍 Verificación de hashes en la base de datos</h2><pre>";

foreach ($pdo->query("SELECT nombre, correo, contrasena FROM usuarios") as $u) {
    $formato = preg_match('/^\$2[aby]\$\d{2}\$[./A-Za-z0-9]{53}$/', $u['contrasena']);
    echo "Usuario: {$u['nombre']} ({$u['correo']})\n";
    echo "Hash: {$u['contrasena']}\n";
    echo "Longitud: " . strlen($u['contrasena']) . " caracteres\n";
    echo "Formato bcrypt: " . ($formato ? '✅ Sí' : '❌ No') . "\n";
    echo "¿Verifica '123456'? " . (password_verify('123456', $u['contrasena']) ? '✅ Sí' : '❌ No') . "\n";
    echo str_repeat('-', 60) . "\n";
}

echo "</pre>";