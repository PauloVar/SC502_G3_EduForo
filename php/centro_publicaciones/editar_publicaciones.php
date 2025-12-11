<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../conexionBD.php';
require '../helpers/auth.php';

if (!usuarioEstaAutenticado() || !usuarioEsAdmin()) {
    header('Location: ../../login.php');
    exit;
}

require '../conexionBD.php';
$mysqli = abrirConexion();

$errores = [];
$exito   = false;

$id = intval($_GET['id'] ?? 0);

if ($id <= 0) {
    header('Location: listar_publicaciones.php');
    exit;
}

$sqlPub = "SELECT id, centro_id, titulo, resumen, cuerpo, fecha_publicacion 
           FROM publicaciones
           WHERE id = ?";
$stmtPub = $mysqli->prepare($sqlPub);
if (!$stmtPub) {
    die("Error al preparar la consulta de publicación.");
}
$stmtPub->bind_param('i', $id);
$stmtPub->execute();
$resPub = $stmtPub->get_result();

if (!$resPub || $resPub->num_rows === 0) {
    $stmtPub->close();
    cerrarConexion($mysqli);
    header('Location: listar_publicaciones.php');
    exit;
}

$publicacion = $resPub->fetch_assoc();
$stmtPub->close();

$titulo  = $publicacion['titulo'];
$resumen = $publicacion['resumen'];
$cuerpo  = $publicacion['cuerpo'];
$centroId = $publicacion['centro_id'];
$fechaPublicacion = $publicacion['fecha_publicacion'] ? 
                    date('Y-m-d\TH:i', strtotime($publicacion['fecha_publicacion'])) : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $titulo  = trim($_POST['titulo'] ?? '');
    $resumen = trim($_POST['resumen'] ?? '');
    $cuerpo  = trim($_POST['cuerpo'] ?? '');
    $centroId = intval($_POST['centro_id'] ?? 0);
    $fechaPublicacion = trim($_POST['fecha_publicacion'] ?? '');

    if ($titulo === '') {
        $errores[] = "El título es obligatorio.";
    } elseif (mb_strlen($titulo) > 100) {
        $errores[] = "El título no puede superar los 100 caracteres.";
    }

    if ($resumen !== '' && mb_strlen($resumen) > 255) {
        $errores[] = "El resumen no puede superar los 255 caracteres.";
    }

    if ($cuerpo === '') {
        $errores[] = "El cuerpo de la publicación es obligatorio.";
    } elseif (mb_strlen($cuerpo) > 2000) {
        $errores[] = "El cuerpo no puede superar los 2000 caracteres.";
    }

    if ($centroId <= 0) {
        $errores[] = "Debe seleccionar un centro educativo.";
    }

    if (empty($errores)) {

        if ($fechaPublicacion === '') {
            $sqlUpdate = "UPDATE publicaciones
                          SET centro_id = ?, titulo = ?, resumen = ?, cuerpo = ?, fecha_publicacion = NOW()
                          WHERE id = ?";
            $stmtUp = $mysqli->prepare($sqlUpdate);
            if ($stmtUp) {
                $stmtUp->bind_param('isssi', $centroId, $titulo, $resumen, $cuerpo, $id);
            }
        } else {
            $sqlUpdate = "UPDATE publicaciones
                          SET centro_id = ?, titulo = ?, resumen = ?, cuerpo = ?, fecha_publicacion = ?
                          WHERE id = ?";
            $stmtUp = $mysqli->prepare($sqlUpdate);
            if ($stmtUp) {
                $stmtUp->bind_param('issssi', $centroId, $titulo, $resumen, $cuerpo, $fechaPublicacion, $id);
            }
        }

        if (!$stmtUp) {
            $errores[] = "Error al preparar la actualización.";
        } else {
            if ($stmtUp->execute()) {
                $exito = true;
            } else {
                $errores[] = "Error al actualizar la publicación.";
            }

            $stmtUp->close();
        }
    }
}

$centros = [];
$resCentros = $mysqli->query("SELECT id, nombre FROM centros ORDER BY nombre ASC");
if ($resCentros && $resCentros->num_rows > 0) {
    while ($fila = $resCentros->fetch_assoc()) {
        $centros[] = $fila;
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar publicación - EduForo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/admin.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

<header class="topbar">
    <a class="logo-container" href="../../Home.php" aria-label="Ir al inicio de EduForo">
        <img src="../../assets/img/logo-eduforo.svg" alt="EduForo Logo" class="logo">
        <span class="logo-text-group">
            <span class="logo-title">EduForo</span>
            <span class="logo-subtitle">Panel de administración</span>
        </span>
    </a>
</header>

<nav class="navBar">
    <ul>
        <li><a href="listar_publicaciones.php" class="active">Publicaciones</a></li>
        <li><a href="../../adminColegios.php">Colegios</a></li>
    </ul>
</nav>

<div class="container my-4">
    <h1 class="h4 mb-3">Editar publicación</h1>

    <?php if ($exito): ?>
        <div class="alert alert-success">
            La publicación se actualizó correctamente.
        </div>
    <?php endif; ?>

    <?php if (!empty($errores)): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($errores as $err): ?>
                    <li><?php echo htmlspecialchars($err); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" class="card card-body shadow-sm">
        <div class="mb-3">
            <label for="centro_id" class="form-label">Centro educativo</label>
            <select name="centro_id" id="centro_id" class="form-select" required>
                <option value="">Seleccione un centro...</option>
                <?php foreach ($centros as $c): ?>
                    <option value="<?php echo $c['id']; ?>"
                        <?php echo ($c['id'] == $centroId) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($c['nombre']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" name="titulo" id="titulo" class="form-control"
                   maxlength="100"
                   value="<?php echo htmlspecialchars($titulo); ?>" required>
        </div>

        <div class="mb-3">
            <label for="resumen" class="form-label">Resumen (opcional)</label>
            <textarea name="resumen" id="resumen" class="form-control" rows="3" maxlength="255"><?php 
                echo htmlspecialchars($resumen); ?></textarea>
        </div>

        <div class="mb-3">
            <label for "cuerpo" class="form-label">Cuerpo de la publicación</label>
            <textarea name="cuerpo" id="cuerpo" class="form-control" rows="6" maxlength="2000" required><?php 
                echo htmlspecialchars($cuerpo); ?></textarea>
        </div>

        <div class="mb-3">
            <label for="fecha_publicacion" class="form-label">Fecha de publicación</label>
            <input type="datetime-local" name="fecha_publicacion" id="fecha_publicacion" 
                   class="form-control"
                   value="<?php echo htmlspecialchars($fechaPublicacion); ?>">
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-brand btn-submit">Guardar cambios</button>
            <a href="listar_publicaciones.php" class="btn btn-secondary">Volver al listado</a>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../../assets/js/navbar.js"></script>
</body>
</html>
<?php cerrarConexion($mysqli); ?>
