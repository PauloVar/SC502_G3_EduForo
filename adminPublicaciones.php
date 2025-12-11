<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'php/conexionBD.php';
require 'php/helpers/auth.php';

if (!usuarioEstaAutenticado() || !usuarioEsAdmin()) {
    header('Location: login.php');
    exit;
}

$conexion = abrirConexion();

$sqlCentros = "SELECT id, nombre FROM centros ORDER BY nombre ASC";
$resCentros = $conexion->query($sqlCentros);

$centros = [];
if ($resCentros && $resCentros->num_rows > 0) {
    while ($fila = $resCentros->fetch_assoc()) {
        $centros[] = $fila;
    }
}

$centroSeleccionado = isset($_GET['centro_id']) ? (int)$_GET['centro_id'] : 0;

$sqlPub = "SELECT  p.id,
                   p.titulo,
                   p.resumen,
                   p.fecha_publicacion,
                   c.id        AS centro_id,
                   c.nombre    AS centro_nombre,
                   c.nivel,
                   c.provincia,
                   c.canton
           FROM publicaciones p
           INNER JOIN centros c ON p.centro_id = c.id";

if ($centroSeleccionado > 0) {
    $sqlPub .= " WHERE c.id = ?";
}

$sqlPub .= " ORDER BY p.fecha_publicacion DESC";

$publicaciones = [];

if ($centroSeleccionado > 0) {
    $stmt = $conexion->prepare($sqlPub);
    $stmt->bind_param("i", $centroSeleccionado);
    $stmt->execute();
    $resPub = $stmt->get_result();
} else {
    $resPub = $conexion->query($sqlPub);
}

if ($resPub && $resPub->num_rows > 0) {
    while ($fila = $resPub->fetch_assoc()) {
        $publicaciones[] = $fila;
    }
}

if (isset($stmt)) {
    $stmt->close();
}

cerrarConexion($conexion);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de publicaciones</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/admin.css">
</head>

<body>

<?php include 'php/componentes/navbar.php'; ?>

<main class="container my-4">

    <section class="admin-panel-card">
        <div class="d-flex justify-content-between align-items-start mb-3">
            <div>
                <h1 class="h4 mb-1">Gestión de publicaciones</h1>
                <p class="small text-muted mb-0">
                    Publicaciones creadas por los centros educativos registrados.
                </p>
            </div>

            <a href="php/centro_publicaciones/crear_publicaciones.php"
               class="btn btn-brand">
                + Nueva publicación
            </a>
        </div>

        <form method="get" class="row g-2 mb-3">
            <div class="col-md-8 col-lg-6">
                <select name="centro_id" class="form-select">
                    <option value="0">Todas las publicaciones</option>
                    <?php foreach ($centros as $c): ?>
                        <option
                            value="<?php echo $c['id']; ?>"
                            <?php echo $centroSeleccionado == $c['id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($c['nombre']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4 col-lg-2 d-grid">
                <button class="btn btn-brand-outline" type="submit">Filtrar</button>
            </div>
        </form>

        <?php if (empty($publicaciones)): ?>

    <div class="alert alert-info mb-0">
        No hay publicaciones registradas para el filtro seleccionado.
    </div>

<?php else: ?>

    <div class="row g-3">
        <?php foreach ($publicaciones as $pub): ?>
            <div class="col-md-4">
                <article class="admin-item-card">
                    
                    <h2 class="h6 mb-1">
                        <?php echo htmlspecialchars($pub['titulo']); ?>
                    </h2>

                    <p class="small mb-0">
                        <?php echo htmlspecialchars($pub['centro_nombre']); ?>
                    </p>

                    <p class="small text-muted mb-1">
                        <?php
                            $ubic = [];
                            if (!empty($pub['nivel']))     $ubic[] = $pub['nivel'];
                            if (!empty($pub['provincia'])) $ubic[] = $pub['provincia'];
                            if (!empty($pub['canton']))    $ubic[] = $pub['canton'];
                            echo htmlspecialchars(implode(' · ', $ubic));
                        ?>
                    </p>

                    <p class="small text-muted mb-2">
                        <?php
                            $texto = $pub['resumen'] ?: '';
                            echo htmlspecialchars(mb_strimwidth($texto, 0, 120, '...'));
                        ?>
                    </p>

                    <p class="small text-muted mb-3">
                        Publicado:
                        <?php
                            echo !empty($pub['fecha_publicacion'])
                                ? date('d/m/Y H:i', strtotime($pub['fecha_publicacion']))
                                : 'Sin fecha';
                        ?>
                    </p>

                    <div class="d-flex gap-2">
                        <a href="php/centro_publicaciones/editar_publicaciones.php?id=<?php echo $pub['id']; ?>"
                           class="btn btn-brand-outline flex-fill">
                            Editar
                        </a>

                        <a href="php/centro_publicaciones/eliminar_publicaciones.php?id=<?php echo $pub['id']; ?>"
                           class="btn btn-danger-outline flex-fill">
                            Eliminar
                        </a>
                    </div>
                </article>
            </div>
        <?php endforeach; ?>
    </div>

<?php endif; ?>

    </section>

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/navbar.js"></script>
</body>

</html>
