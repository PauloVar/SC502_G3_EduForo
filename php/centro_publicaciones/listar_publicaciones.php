<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json; charset=utf-8');

require '../conexionBD.php';

$response = [
    'status' => 'error',
    'mensaje' => 'Error inesperado',
    'publicaciones' => []
];

try {
    $centroId = intval($_GET['centro_id'] ?? 0);

    if ($centroId <= 0) {
        $response['mensaje'] = 'Centro inválido.';
        echo json_encode($response);
        exit;
    }

    $mysqli = abrirConexion();

    $sql = "SELECT id, titulo, resumen, cuerpo, fecha_publicacion
            FROM publicaciones
            WHERE centro_id = ?
            ORDER BY fecha_publicacion DESC, id DESC";

    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        $response['mensaje'] = 'Error al preparar la consulta.';
        echo json_encode($response);
        exit;
    }

    $stmt->bind_param("i", $centroId);
    $stmt->execute();

    $resultado = $stmt->get_result();
    $data = [];

    while ($fila = $resultado->fetch_assoc()) {
        $data[] = $fila;
    }

    $response['status'] = 'ok';
    $response['mensaje'] = 'Consulta correcta';
    $response['publicaciones'] = $data;

    $stmt->close();
    cerrarConexion($mysqli);

} catch (Exception $e) {
    $response['mensaje'] = 'Excepción: ' . $e->getMessage();
}

echo json_encode($response);
exit;

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Publicaciones de colegios - Admin</title>
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

    <div class="topbar-right">
        <span class="small me-3">
            <?php echo htmlspecialchars(obtenerNombreUsuario()); ?>
        </span>
        <a href="../../adminColegios.php" class="btn btn-sm btn-outline-light me-2">Colegios</a>
        <a href="../../php/login/logout.php" class="btn btn-sm btn-light">Cerrar sesión</a>
    </div>
</header>

<nav class="navBar">
    <ul>
        <li><a href="../../adminPublicaciones.php" class="active">Publicaciones</a></li>
        <li><a href="../../adminColegios.php">Colegios</a></li>
    </ul>
</nav>

<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Publicaciones de colegios</h1>
        <a href="crear_publicaciones.php" class="btn btn-brand btn-sm">Nueva publicación</a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Centro</th>
                    <th>Título</th>
                    <th>Resumen</th>
                    <th>Fecha publicación</th>
                    <th style="width: 160px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($resultado && $resultado->num_rows > 0): ?>
                    <?php while ($fila = $resultado->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $fila['id']; ?></td>
                            <td><?php echo htmlspecialchars($fila['centro_nombre']); ?></td>
                            <td><?php echo htmlspecialchars($fila['titulo']); ?></td>
                            <td><?php echo htmlspecialchars($fila['resumen']); ?></td>
                            <td>
                                <?php 
                                if ($fila['fecha_publicacion']) {
                                    echo date('d/m/Y H:i', strtotime($fila['fecha_publicacion']));
                                } else {
                                    echo '-';
                                }
                                ?>
                            </td>
                            <td>
                                <a href="editar_publicaciones.php?id=<?php echo $fila['id']; ?>" 
                                   class="btn btn-sm btn-brand-outline">Editar</a>
                                <!-- Si luego quieres eliminar:
                                <a href="eliminar_publicacion.php?id=<?php echo $fila['id']; ?>"
                                   class="btn btn-sm btn-outline-danger"
                                   onclick="return confirm('¿Eliminar esta publicación?');">Eliminar</a>
                                -->
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            No hay publicaciones registradas.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <a href="../../adminPublicaciones.php" class="btn btn-secondary btn-sm">Volver al panel</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../../assets/js/navbar.js"></script>
</body>
</html>
<?php cerrarConexion($mysqli); ?>
