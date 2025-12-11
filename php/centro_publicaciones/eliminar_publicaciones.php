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

$conexion = abrirConexion();

$pubId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$publicacion = null;

if ($pubId > 0) {
    $sql = "SELECT p.id,
                   p.titulo,
                   c.nombre AS centro_nombre
            FROM publicaciones p
            INNER JOIN centros c ON p.centro_id = c.id
            WHERE p.id = ?";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $pubId);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado && $resultado->num_rows === 1) {
        $publicacion = $resultado->fetch_assoc();
    }

    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $publicacion) {

    $sqlDel = "DELETE FROM publicaciones WHERE id = ?";
    $stmtDel = $conexion->prepare($sqlDel);
    $stmtDel->bind_param("i", $pubId);

    if ($stmtDel->execute()) {
        $stmtDel->close();
        cerrarConexion($conexion);
        header('Location: ../../adminPublicaciones.php');
        exit;
    }

    $stmtDel->close();
}

cerrarConexion($conexion);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar publicación</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/admin.css">
</head>

<body>

<?php include '../componentes/navbar.php'; ?>

<main class="container my-4">
    <section class="delete-card">
        <?php if (!$publicacion): ?>

            <h1 class="h5 mb-3 text-danger">Publicación no encontrada</h1>
            <p class="mb-3">No se pudo encontrar la publicación solicitada.</p>
            <a href="../../adminPublicaciones.php" class="btn btn-brand-outline">Volver al listado</a>

        <?php else: ?>

            <h1 class="h4 mb-3 text-danger">Eliminar publicación</h1>

            <p class="mb-2">
                ¿Está seguro de eliminar la publicación?
            </p>

            <p class="fw-bold mb-1">
                <?php echo htmlspecialchars($publicacion['titulo']); ?>
            </p>

            <p class="small text-muted mb-3">
                Centro: <?php echo htmlspecialchars($publicacion['centro_nombre']); ?>
            </p>

            <div class="alert alert-danger mb-4">
                Esta acción es irreversible.
            </div>

            <form method="post" class="d-flex gap-2">
                <button type="submit" class="btn btn-danger">Eliminar</button>
                <a href="../../adminPublicaciones.php" class="btn btn-brand-outline">Cancelar</a>
            </form>

        <?php endif; ?>
    </section>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
