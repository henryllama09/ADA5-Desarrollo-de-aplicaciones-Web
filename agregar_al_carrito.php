<?php
session_start();
require_once 'configuracion/base_datos.php';

$id_producto = isset($_POST['id_producto']) ? (int)$_POST['id_producto'] : 0;
$cantidad    = isset($_POST['cantidad'])    ? (int)$_POST['cantidad']    : 1;

if ($id_producto <= 0 || $cantidad <= 0) {
    header('Location: index.php');
    exit;
}

$sentencia = $pdo->prepare("SELECT existencias FROM productos WHERE id = ?");
$sentencia->execute([$id_producto]);
$producto = $sentencia->fetch();

if (!$producto) {
    header('Location: index.php');
    exit;
}

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

$cantidad_actual = $_SESSION['carrito'][$id_producto] ?? 0;
$nueva_cantidad  = min($cantidad_actual + $cantidad, (int)$producto['existencias']);
$_SESSION['carrito'][$id_producto] = $nueva_cantidad;

header('Location: index.php?msg=agregado');
exit;