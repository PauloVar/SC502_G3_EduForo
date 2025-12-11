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

$mysqli = abrirConexion();
$errors = [];

$centros = [];

$sqlCentros = "SELECT id, nombre FROM centros ORDER BY nombre ASC";
$resCentros = $mysqli->query($sqlCentros);

if ($resCentros) {
    while ($fila = $resCentros->fetch_assoc()) {
        $centros[] = $fila;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $centro_id = intval($_POST['centro_id'] ?? 0);
    $titulo    = trim($_POST['titulo'] ?? '');
    $resumen   = trim($_POST['resumen'] ?? '');
    $cuerpo    = trim($_POST['cuerpo'] ?? '');
    $fecha     = trim($_POST['fecha_publicacion'] ?? '');

    if ($centro_id <= 0) {
        $errors[] = "Debe seleccionar un centro educativo.";
    }

    if ($titulo === '') {
        $errors[] = "El título es obligatorio.";
    } elseif (mb_strlen($titulo) > 100) {
        $errors[] = "El título no puede superar los 100 caracteres.";
    }

    if ($resumen !== '' && mb_strlen($resumen) > 255) {
        $errors[] = "El resumen no puede superar los 255 caracteres.";
    }

    if ($cuerpo === '') {
        $errors[] = "El cuerpo de la publicación es obligatorio.";
    } elseif (mb_strlen($cuerpo) > 2000) {
        $errors[] = "El cuerpo no puede superar los 2000 caracteres.";
    }

    $fechaPublicacion = null;
    if ($fecha !== '') {
        $dt = DateTime::createFromFormat('Y-m-d\TH:i', $fecha);
        if ($dt) {
            $fechaPublicacion = $dt->format('Y-m-d H:i:s');
        } else {
            $errors[] = "La fecha de publicación no tiene un formato válido.";
        }
    }

    if (empty($errors)) {
        $sql = "INSERT INTO publicaciones (centro_id, titulo, resumen, cuerpo, fecha_publicacion)
                VALUES (?, ?, ?, ?, ?)";

        $stmt = $mysqli->prepare($sql);
        if ($stmt) {
            $stmt->bind_param(
                "issss",
                $centro_id,
                $titulo,
                $resumen,
                $cuerpo,
                $fechaPublicacion
            );

            if ($stmt->execute()) {
                header('Location: ../../adminPublicaciones.php');
                exit;
            } else {
                $errors[] = "No se pudo guardar la publicación.";
            }

            $stmt->close();
        } else {
            $errors[] = "No se pudo preparar la consulta.";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva publicación — EduForo</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/admin.css">
</head>

<body style="background:#ece9df;">

    <header class="topbar">
        <a class="logo-container" href="../../Home.php" aria-label="Ir al inicio de EduForo">
            <img src="../../assets/img/logo-eduforo.svg" class="logo" alt="EduForo">
            <span class="logo-title">EduForo</span>
        </a>
    </header>

    <main class="container my-4">
        <a href="../../adminPublicaciones.php" class="page-linkback">Volver al panel de publicaciones</a>

        <div class="form-card mt-3">
            <h1 class="h4 mb-3">Nueva publicación</h1>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="post">
                <div class="mb-3">
                    <label for="centro_id" class="form-label">Centro educativo</label>
                    <select name="centro_id" id="centro_id" class="form-select">
                        <option value="">Seleccione un centro</option>
                        <?php foreach ($centros as $centro): ?>
                            <option value="<?php echo $centro['id']; ?>"
                                <?php echo (isset($centro_id) && $centro_id == $centro['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($centro['nombre']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="titulo" class="form-label">Título</label>
                    <input type="text"
                           class="form-control"
                           id="titulo"
                           name="titulo"
                           value="<?php echo htmlspecialchars($titulo ?? ''); ?>">
                </div>

                <div class="mb-3">
                    <label for="resumen" class="form-label">Resumen (opcional)</label>
                    <textarea class="form-control"
                              id="resumen"
                              name="resumen"
                              rows="2"><?php echo htmlspecialchars($resumen ?? ''); ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="cuerpo" class="form-label">Cuerpo</label>
                    <textarea class="form-control"
                              id="cuerpo"
                              name="cuerpo"
                              rows="5"><?php echo htmlspecialchars($cuerpo ?? ''); ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="fecha_publicacion" class="form-label">
                        Fecha de publicación (opcional)
                    </label>
                    <input type="datetime-local"
                           class="form-control"
                           id="fecha_publicacion"
                           name="fecha_publicacion"
                           value="<?php echo htmlspecialchars($fecha ?? ''); ?>">
                </div>

                <button type="submit" class="btn btn-brand">Guardar</button>
                <a href="../../adminPublicaciones.php" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
