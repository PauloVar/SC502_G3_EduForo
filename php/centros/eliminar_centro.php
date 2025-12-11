<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    header("Location: ../../adminColegios.php");
    exit();
}

$idCentro = (int) $_GET['id'];

include '../conexionBD.php';
$mysqli = abrirConexion();

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirmar']) && $_POST['confirmar'] == '1') {

    $sqlDel = "DELETE FROM centros WHERE id = ?";
    $stmtDel = $mysqli->prepare($sqlDel);

    if ($stmtDel) {
        $stmtDel->bind_param("i", $idCentro);
        if ($stmtDel->execute()) {
            $stmtDel->close();
            cerrarConexion($mysqli);
            header("Location: ../../adminColegios.php");
            exit();
        } else {
            $errors[] = "No se pudo eliminar el centro educativo.";
        }
        $stmtDel->close();
    } else {
        $errors[] = "Error al preparar la eliminación.";
    }
}


$sql = "SELECT nombre, codigo, provincia, canton, nivel, direccion, telefono, correo
        FROM centros
        WHERE id = ?
        LIMIT 1";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $idCentro);
$stmt->execute();
$resultado = $stmt->get_result();

if (!$resultado || $resultado->num_rows === 0) {
    $stmt->close();
    cerrarConexion($mysqli);
    header("Location: ../../adminColegios.php");
    exit();
}

$aviso = $resultado->fetch_assoc();
$stmt->close();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Centro educativo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/Home.css">
    <link rel="stylesheet" href="../../assets/css/public.css">
</head>

    <header class="topbar">
        <a class="logo-container" href="../../Home.php" aria-label="Ir al inicio de EduForo">
            <img src="../../assets/img/logo-eduforo.svg" alt="EduForo Logo" class="logo">
            <span class="logo-text-group">
                <span class="logo-title">EduForo</span>
                <span class="logo-subtitle">Panel de administración</span>
            </span>
        </a>
        <div class="dropdown">
            <button type="button" class="dropbtn">
                <span class="user-avatar" aria-hidden="true">U</span>
                <span class="user-name">Usuario</span>
                <span class="user-caret" aria-hidden="true">▾</span>
            </button>
            <div class="dropdown-content">
                <a href="../../perfil.php">Perfil</a>
                <a href="../../adminPublicaciones.php">Panel de admin</a>
                <a href="#" data-action="logout">Cerrar sesión</a>
            </div>
        </div>
    </header>
<body>
    <div class="container form-page-container my-5">
        <div class="card shadow-sm" style="max-width: 600px; margin: 0 auto;">
            <div class="card-body p-4 text-center">
                <div>
                    <h3 class="text-danger">Eliminar Centro educativo</h3>
                </div>
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger text-start">
                        <ul class="mb-0">
                            <?php foreach ($errors as $e): ?>
                                <li><?php echo htmlspecialchars($e ?? ''); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <div>
                    <h5>¿Está seguro de eliminar?</h5>
                </div>
                <p class="lead fw-bold">
                    <strong><?php echo htmlspecialchars($aviso['nombre'] ?? ''); ?></strong>
                </p>

                <?php if (!empty($aviso['resumen'])): ?>
                    <p class="text-muted small">
                        <em><?php echo htmlspecialchars($aviso['nivel'] ?? ''); ?></em>
                    </p>
                <?php endif; ?>

                <div class="alert alert-danger">
                    <small>Esta acción es irreversible.</small>
                </div>

                <form method="post" class="mt-4 d-flex justify-content-center gap-2">
                    <button type="submit" name="confirmar" value="1" class="btn btn-danger">
                        Eliminar
                    </button>
                    <a href="listar_avisos.php" class="btn btn-secondary">
                        Cancelar
                    </a>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../../assets/js/navbar.js"></script>
    <script src="../../assets/js/adminColegios.js"></script>

    <footer class="footer">
        <p>© 2025 EduForo. Todos los derechos reservados.</p>
    </footer>
</body>

</html>
<?php cerrarConexion($mysqli); ?>