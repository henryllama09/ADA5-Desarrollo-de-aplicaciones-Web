<?php
session_start();

$id_producto = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id_producto > 0 && isset($_SESSION['carrito'][$id_producto])) {
    unset($_SESSION['carrito'][$id_producto]);
}

header('Location: carrito.php?msg=eliminado');
exit;