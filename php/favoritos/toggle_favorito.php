<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

include '../conexionBD.php';
$mysqli = abrirConexion();

$usuarioId = 1;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar_centro_id'])) {
    $centroIdEliminar = intval($_POST['eliminar_centro_id']);

    $stmtDel = $mysqli->prepare("DELETE FROM favoritos WHERE usuario_id = ? AND centro_id = ?");
    $stmtDel->bind_param("ii", $usuarioId, $centroIdEliminar);
    $stmtDel->execute();
    $stmtDel->close();

    header("Location: toggle_favorito.php");
    exit();
}

$sql = "SELECT c.id, c.nombre, c.codigo, c.provincia, c.canton, c.nivel, c.direccion, c.telefono, c.correo
        FROM centros c
        INNER JOIN favoritos f ON c.id = f.centro_id
        WHERE f.usuario_id = ?
        ORDER BY c.nombre ASC";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $usuarioId);
$stmt->execute();
$resultado = $stmt->get_result();

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Colegios Favoritos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../../assets/css/Home.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../../assets/css/public.css?v=<?php echo time(); ?>">
</head>

<body>

    <?php include '../componentes/navbar.php'; ?>

    <main class="container my-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h4 mb-0">Mis Colegios Favoritos</h1>
            </div>
        </div>

        <div class="row g-3">
            <?php if ($resultado->num_rows > 0): ?>
                <?php while ($fila = $resultado->fetch_assoc()): ?>
                    <div class="col-md-4 mep-card">
                        <div class="card-min h-100 d-flex flex-column">
                            <h5 class="mb-1 text-truncate" title="<?php echo htmlspecialchars($fila['nombre']); ?>">
                                <?php echo htmlspecialchars($fila['nombre']); ?>
                            </h5>

                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge-soft">
                                    Código: <?php echo htmlspecialchars($fila['codigo']); ?>
                                </span>
                                <span class="badge-soft">
                                    <?php echo htmlspecialchars($fila['nivel'] ?? 'N/A'); ?>
                                </span>
                            </div>

                            <p class="small text-muted-90 mb-1">
                                <strong>Ubicación:</strong> <?php echo htmlspecialchars($fila['provincia'] . ', ' . $fila['canton']); ?>
                            </p>

                            <p class="small text-muted-90 mb-1 text-truncate" title="<?php echo htmlspecialchars($fila['direccion']); ?>">
                                <strong>Dirección:</strong> <?php echo htmlspecialchars($fila['direccion']); ?>
                            </p>

                            <?php if (!empty($fila['telefono'])): ?>
                                <p class="small text-muted-90 mb-1">
                                    📞: <?php echo htmlspecialchars($fila['telefono']); ?>
                                </p>
                            <?php endif; ?>

                            <?php if (!empty($fila['correo'])): ?>
                                <p class="small text-muted-90 mb-3 text-truncate" title="<?php echo htmlspecialchars($fila['correo']); ?>">
                                    📧: <a href="mailto:<?php echo htmlspecialchars($fila['correo']); ?>" class="text-decoration-none text-muted-90">
                                        <?php echo htmlspecialchars($fila['correo']); ?>
                                    </a>
                                </p>
                            <?php else: ?>
                                <div class="mb-3"></div>
                            <?php endif; ?>

                            <div class="mt-auto">
                                <form method="post" class="w-100" onsubmit="return confirm('¿Quitar de favoritos?');">
                                    <input type="hidden" name="eliminar_centro_id" value="<?php echo $fila['id']; ?>">
                                    <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                                        💔 Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-light text-center border shadow-sm p-5" role="alert">
                        <h4 class="alert-heading mb-3">No tienes favoritos aún</h4>
                        <p class="text-muted">Explora la lista de centros educativos y agrega los que te interesen aquí.</p>
                        <hr>
                        <a href="lista_centros.php" class="btn btn-brand mt-2">Explorar Centros</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php
$stmt->close();
cerrarConexion($mysqli);
?>