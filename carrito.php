<?php
require_once 'incluye/encabezado.php';
require_once 'configuracion/base_datos.php';

$carrito   = $_SESSION['carrito'];
$articulos = [];
$total     = 0;

if (!empty($carrito)) {
    $ids          = array_keys($carrito);
    $marcadores   = implode(',', array_fill(0, count($ids), '?'));
    $sentencia    = $pdo->prepare("SELECT id, nombre, precio FROM productos WHERE id IN ($marcadores)");
    $sentencia->execute($ids);
    $articulos = $sentencia->fetchAll();
}
?>

<h2>Mi Carrito</h2>

<?php if (isset($_GET['msg'])): ?>
    <?php if ($_GET['msg'] === 'actualizado'): ?>
        <div class="aviso">✅ Cantidad actualizada.</div>
    <?php elseif ($_GET['msg'] === 'eliminado'): ?>
        <div class="aviso">🗑️ Producto eliminado del carrito.</div>
    <?php endif; ?>
<?php endif; ?>

<?php if (empty($articulos)): ?>
    <p>Tu carrito está vacío. <a href="index.php" class="boton">Ir a la tienda</a></p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Precio Unitario</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($articulos as $item):
            $cantidad = $carrito[$item['id']];
            $subtotal = $item['precio'] * $cantidad;
            $total   += $subtotal;
        ?>
            <tr>
                <td><?= htmlspecialchars($item['nombre']) ?></td>
                <td>$<?= number_format($item['precio'], 2) ?></td>
                <td>
                    <form method="POST" action="actualizar_carrito.php" class="en-linea">
                        <input type="hidden" name="id_producto" value="<?= $item['id'] ?>">
                        <input type="number" name="cantidad" value="<?= $cantidad ?>" min="1">
                        <button type="submit" class="boton">Actualizar</button>
                    </form>
                </td>
                <td>$<?= number_format($subtotal, 2) ?></td>
                <td>
                    <a href="eliminar_del_carrito.php?id=<?= $item['id'] ?>"
                       class="boton boton-peligro"
                       onclick="return confirm('¿Eliminar este producto del carrito?');">
                        Eliminar
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <div class="total">
        <strong>Total: $<?= number_format($total, 2) ?></strong>
    </div>
    <div style="text-align:right; margin-top:15px;">
        <a href="index.php" class="boton">Seguir comprando</a>
        <a href="#" class="boton boton-exito"
           onclick="alert('Compra finalizada (demostración)'); return false;">Finalizar compra</a>
    </div>
<?php endif; ?>

<?php require_once 'incluye/pie.php'; ?>