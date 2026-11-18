<?php
require_once 'incluye/encabezado.php';
require_once 'configuracion/base_datos.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo     = trim($_POST['correo'] ?? '');
    $contrasena = $_POST['contrasena'] ?? '';

    if ($correo === '' || $contrasena === '') {
        $error = 'Debes completar todos los campos.';
    } else {
        $sentencia = $pdo->prepare("SELECT id, nombre, contrasena FROM usuarios WHERE correo = ?");
        $sentencia->execute([$correo]);
        $usuario = $sentencia->fetch();

        if (!$usuario) {
            $error = 'No existe una cuenta con ese correo.';
        } else {
            $hash_guardado = $usuario['contrasena'];

            // Diagnóstico del formato del hash
            if (!preg_match('~^\$2[aby]\$\d{2}\$[./A-Za-z0-9]{53}$~', $hash_guardado)) {
                $error = '⚠️ El hash almacenado no tiene formato bcrypt válido. '
                       . 'Ejecuta <strong>crear_usuarios.php</strong> para regenerar los hashes.';
            } else {
                if (password_verify($contrasena, $hash_guardado)) {
                    // Actualizar el hash si PHP lo recomienda
                    if (password_needs_rehash($hash_guardado, PASSWORD_DEFAULT)) {
                        $nuevo_hash = password_hash($contrasena, PASSWORD_DEFAULT);
                        $actualizar = $pdo->prepare("UPDATE usuarios SET contrasena = ? WHERE id = ?");
                        $actualizar->execute([$nuevo_hash, $usuario['id']]);
                    }

                    $_SESSION['usuario_id']     = $usuario['id'];
                    $_SESSION['usuario_nombre'] = $usuario['nombre'];

                    header('Location: index.php');
                    exit;
                } else {
                    $error = 'Contraseña incorrecta.';
                }
            }
        }
    }
}
?>

<h2>Iniciar Sesión</h2>

<?php if ($error): ?>
    <div class="aviso" style="background:#fee2e2; color:#991b1b;"><?= $error ?></div>
<?php endif; ?>

<?php if (isset($_GET['msg']) && $_GET['msg'] === 'requiere_login'): ?>
    <div class="aviso" style="background:#fef3c7; color:#92400e;">
        Debes iniciar sesión para realizar esta acción.
    </div>
<?php endif; ?>

<form method="POST"
      style="max-width:400px; background:#fff; padding:20px; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,.08);">
    <label for="correo">Correo electrónico</label>
    <input type="email" id="correo" name="correo" required
           value="<?= htmlspecialchars($_POST['correo'] ?? '') ?>"
           style="width:100%; padding:8px; margin:6px 0 12px; border:1px solid #ccc; border-radius:4px;">

    <label for="contrasena">Contraseña</label>
    <input type="password" id="contrasena" name="contrasena" required
           style="width:100%; padding:8px; margin:6px 0 12px; border:1px solid #ccc; border-radius:4px;">

    <button type="submit" class="boton">Entrar</button>
</form>

<div style="max-width:400px; margin-top:20px; font-size:13px; color:#555;">
    <strong>Credenciales de prueba:</strong><br>
    📧 ana@example.com · 🔑 123456<br>
    📧 carlos@example.com · 🔑 123456<br>
    📧 maria@example.com · 🔑 admin123
</div>

<?php require_once 'incluye/pie.php'; ?>