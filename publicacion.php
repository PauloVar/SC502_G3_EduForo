<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'php/conexionBD.php';
require 'php/helpers/auth.php';

$conexion = abrirConexion();

$pubId = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$publicacion = null;

if ($pubId > 0) {
    $sql = "SELECT  p.id,
                    p.titulo,
                    p.resumen,
                    p.cuerpo,
                    p.fecha_publicacion,
                    c.id       AS centro_id,
                    c.nombre   AS centro_nombre,
                    c.provincia,
                    c.canton,
                    c.nivel
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

cerrarConexion($conexion);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo $publicacion
            ? htmlspecialchars($publicacion['titulo']) . ' — EduForo'
            : 'Publicación — EduForo'; ?>
    </title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/Home.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/public.css?v=<?php echo time(); ?>">
</head>

<body style="background:#ece9df;">

<?php include 'php/componentes/navbar.php'; ?>

<main class="container my-4">

    <?php if (!$publicacion): ?>

        <div class="mb-3">
            <a href="Home.php" class="small text-muted text-decoration-none">
                ← Volver al inicio
            </a>
        </div>

        <div class="alert alert-warning">
            No se encontró la publicación solicitada.
        </div>

    <?php else: ?>

        <div class="mb-3">
            <a href="centro-publicaciones.php?centro_id=<?php echo $publicacion['centro_id']; ?>"
               class="small text-muted text-decoration-none">
                ← Volver a publicaciones de <?php echo htmlspecialchars($publicacion['centro_nombre']); ?>
            </a>
        </div>

        <header class="mb-3">
            <h1 class="h4 mb-1">
                <?php echo htmlspecialchars($publicacion['titulo']); ?>
            </h1>

            <p class="small mb-0">
                Centro:
                <a href="centro.php?id=<?php echo $publicacion['centro_id']; ?>">
                    <?php echo htmlspecialchars($publicacion['centro_nombre']); ?>
                </a>
            </p>

            <p class="small text-muted mb-0">
                Publicado:
                <?php
                    echo !empty($publicacion['fecha_publicacion'])
                        ? date('d/m/Y H:i', strtotime($publicacion['fecha_publicacion']))
                        : 'Sin fecha';
                ?>
            </p>

            <p class="small text-muted mb-0">
                Nivel:
                <strong><?php echo htmlspecialchars($publicacion['nivel'] ?: 'No registrado'); ?></strong>
                <?php if (!empty($publicacion['provincia']) || !empty($publicacion['canton'])): ?>
                    &nbsp;|&nbsp;Ubicación:
                    <?php
                        $ubic = [];
                        if (!empty($publicacion['provincia'])) $ubic[] = $publicacion['provincia'];
                        if (!empty($publicacion['canton']))    $ubic[] = $publicacion['canton'];
                        echo htmlspecialchars(implode(', ', $ubic));
                    ?>
                <?php endif; ?>
            </p>
        </header>

        <section class="panel-publicacion">

            <?php if (!empty($publicacion['resumen'])): ?>
                <div class="publicacion-resumen mb-3">
                    <?php echo htmlspecialchars($publicacion['resumen']); ?>
                </div>
            <?php endif; ?>

            <div class="publicacion-cuerpo">
                <?php
                    echo nl2br(htmlspecialchars($publicacion['cuerpo']));
                ?>
            </div>

        </section>

    <?php endif; ?>

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
