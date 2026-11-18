<?php
require_once 'incluye/encabezado.php';
require_once 'configuracion/base_datos.php';

$productos = $pdo->query("SELECT * FROM productos ORDER BY id")->fetchAll();
?>

<?php if (isset($_GET['msg']) && $_GET['msg'] === 'agregado'): ?>
    <div class="aviso">✅ Producto agregado al carrito correctamente.</div>
<?php endif; ?>

<h2>Catálogo de Productos</h2>
<div class="productos">
    <?php foreach ($productos as $p): ?>
        <div class="tarjeta">
            <h3><?= htmlspecialchars($p['nombre']) ?></h3>
            <p><?= htmlspecialchars($p['descripcion']) ?></p>
            <p class="precio">$<?= number_format($p['precio'], 2) ?></p>
            <p>Existencias: <?= $p['existencias'] ?></p>
            <?php if ($p['existencias'] > 0): ?>
                <form method="POST" action="agregar_al_carrito.php">
                    <input type="hidden" name="id_producto" value="<?= $p['id'] ?>">
                    <input type="number" name="cantidad" value="1" min="1" max="<?= $p['existencias'] ?>">
                    <button type="submit" class="boton">Añadir al carrito</button>
                </form>
            <?php else: ?>
                <p style="color:#dc2626;">Sin existencias</p>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>

<?php require_once 'incluye/pie.php'; ?>