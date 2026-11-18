<?php
session_start();
require_once 'configuracion/base_datos.php';

$id_producto    = isset($_POST['id_producto']) ? (int)$_POST['id_producto'] : 0;
$nueva_cantidad = isset($_POST['cantidad'])    ? (int)$_POST['cantidad']    : 1;

if ($id_producto > 0 && $nueva_cantidad > 0 && isset($_SESSION['carrito'][$id_producto])) {
    $sentencia = $pdo->prepare("SELECT existencias FROM productos WHERE id = ?");
    $sentencia->execute([$id_producto]);
    $producto = $sentencia->fetch();

    if ($producto) {
        $nueva_cantidad = min($nueva_cantidad, (int)$producto['existencias']);
        $_SESSION['carrito'][$id_producto] = $nueva_cantidad;
    }
}

header('Location: carrito.php?msg=actualizado');
exit;