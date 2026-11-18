<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

$nombre_usuario  = $_SESSION['usuario_nombre'] ?? null;
$total_articulos = array_sum($_SESSION['carrito']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tienda en Línea - Carrito</title>
    <style>
        * { box-sizing: border-box; font-family: Arial, sans-serif; }
        body { margin: 0; background: #f4f6f9; color: #333; }
        header { background: #1f2937; color: #fff; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; }
        header h1 { margin: 0; font-size: 20px; }
        header nav a { color: #fff; text-decoration: none; margin-left: 15px; font-weight: bold; }
        header nav a:hover { text-decoration: underline; }
        .contenedor { max-width: 1100px; margin: 30px auto; padding: 0 20px; }
        .insignia { background: #ef4444; color: #fff; border-radius: 50%; padding: 2px 8px; font-size: 12px; margin-left: 5px; }
        .productos { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 20px; }
        .tarjeta { background: #fff; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,.08); padding: 15px; }
        .tarjeta h3 { margin: 0 0 8px; font-size: 16px; }
        .tarjeta p { margin: 5px 0; color: #666; font-size: 14px; }
        .precio { color: #059669; font-weight: bold; font-size: 18px; }
        .boton { display: inline-block; padding: 8px 14px; border-radius: 6px; background: #2563eb; color: #fff; border: none; cursor: pointer; text-decoration: none; font-size: 14px; }
        .boton:hover { background: #1d4ed8; }
        .boton-peligro { background: #dc2626; }
        .boton-peligro:hover { background: #b91c1c; }
        .boton-exito { background: #059669; }
        table { width: 100%; border-collapse: collapse; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 6px rgba(0,0,0,.08); }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #1f2937; color: #fff; }
        input[type="number"] { width: 70px; padding: 5px; border: 1px solid #ccc; border-radius: 4px; }
        .aviso { padding: 12px; background: #d1fae5; color: #065f46; border-radius: 6px; margin-bottom: 15px; }
        .total { text-align: right; font-size: 20px; margin-top: 20px; }
        form.en-linea { display: inline; }
    </style>
</head>
<body>
<header>
    <h1>🛒 Mi Tienda</h1>
    <nav>
        <a href="index.php">Productos</a>
        <a href="carrito.php">Carrito<?php if ($total_articulos > 0): ?><span class="insignia"><?= $total_articulos ?></span><?php endif; ?></a>
        <?php if ($nombre_usuario): ?>
            <span style="margin-left:15px;">👤 <?= htmlspecialchars($nombre_usuario) ?></span>
            <a href="cerrar_sesion.php">Cerrar sesión</a>
        <?php else: ?>
            <a href="iniciar_sesion.php">Iniciar sesión</a>
        <?php endif; ?>
    </nav>
</header>
<div class="contenedor">