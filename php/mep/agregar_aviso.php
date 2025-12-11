<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../conexionBD.php';
$mysqli = abrirConexion();

$errors  = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $titulo  = trim($_POST['titulo'] ?? '');
    $resumen = trim($_POST['resumen'] ?? '');
    $cuerpo  = trim($_POST['cuerpo'] ?? '');
    $enlace  = trim($_POST['enlace'] ?? '');

    $errors = [];

    if ($titulo === '') {
        $errors[] = "El título es obligatorio.";
    }

    if (mb_strlen($titulo) > 50) {
        $errors[] = "El título no puede superar los 100 caracteres.";
    }

    if (mb_strlen($resumen) > 100) {
        $errors[] = "El resumen no puede superar los 255 caracteres.";
    }

    if ($cuerpo === '') {
        $errors[] = "El cuerpo del aviso es obligatorio.";
    }

    if (mb_strlen($cuerpo) > 2000) {
        $errors[] = "El cuerpo no puede superar los 2000 caracteres.";
    }

    if (mb_strlen($enlace) > 255) {
        $errors[] = "El enlace no puede superar los 255 caracteres.";
    }

    if (empty($errors)) {
        $sql = "INSERT INTO avisos_mep 
                (titulo, resumen, cuerpo, enlace, fecha_publicacion)
                VALUES (?, ?, ?, ?, NOW())";

        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param(
            "ssss",
            $titulo,
            $resumen,
            $cuerpo,
            $enlace
        );

        if ($stmt->execute()) {
            header("Location: listar_avisos.php");
            exit();
        } else {
            $errors[] = "No se pudo guardar el aviso.";
        }

        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Aviso MEP</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/Home.css">
    <link rel="stylesheet" href="../../assets/css/public.css">
</head>

<body>

    <div class="container form-page-container my-4">
        <div class="card card-form">
            <div>
                <h3>Agregar Aviso MEP</h3>
            </div>
            <div class="card-body">
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach ($errors as $e): ?>
                                <li><?php echo htmlspecialchars($e ?? ''); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="post">

                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título</label>
                        <input type="text"
                            class="form-control"
                            id="titulo"
                            name="titulo"
                            value="<?php echo htmlspecialchars($titulo ?? ''); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="resumen" class="form-label">Resumen (Opcional)</label>
                        <textarea class="form-control"
                            id="resumen"
                            name="resumen"
                            rows="2"><?php echo htmlspecialchars($resumen ?? ''); ?></textarea>

                    </div>

                    <div class="mb-3">
                        <label for="cuerpo" class="form-label">Cuerpo del aviso</label>
                        <textarea class="form-control"
                            id="cuerpo"
                            name="cuerpo"
                            rows="6"><?php echo htmlspecialchars($cuerpo ?? ''); ?></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="enlace" class="form-label">Enlace externo (Opcional)</label>
                        <input type="text"
                            class="form-control"
                            id="enlace"
                            name="enlace"
                            placeholder="https://..."
                            value="<?php echo htmlspecialchars($enlace ?? ''); ?>">
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            Publicar aviso
                        </button>
                        <a href="listar_avisos.php" class="btn btn-secondary">
                            Volver al listado
                        </a>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
</body>

</html>
<?php cerrarConexion($mysqli); ?>