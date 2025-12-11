<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'php/conexionBD.php';
require 'php/helpers/auth.php';

$mysqli = abrirConexion();

$centroId = intval($_GET['id'] ?? ($_GET['centro_id'] ?? 0));

if ($centroId <= 0) {
    header('Location: Home.php');
    exit;
}

$sqlCentro = "SELECT id, nombre, codigo, provincia, canton, nivel, direccion, telefono, correo
              FROM centros
              WHERE id = ?";

$stmtCentro = $mysqli->prepare($sqlCentro);
if (!$stmtCentro) {
    header('Location: Home.php');
    exit;
}

$stmtCentro->bind_param("i", $centroId);
$stmtCentro->execute();
$resCentro = $stmtCentro->get_result();

if (!$resCentro || $resCentro->num_rows === 0) {
    $stmtCentro->close();
    header('Location: Home.php');
    exit;
}

$centro = $resCentro->fetch_assoc();
$stmtCentro->close();

$sqlPub = "SELECT id, titulo, resumen, cuerpo, fecha_publicacion
           FROM publicaciones
           WHERE centro_id = ?
           ORDER BY fecha_publicacion DESC, id DESC";

$stmtPub = $mysqli->prepare($sqlPub);
$stmtPub->bind_param("i", $centroId);
$stmtPub->execute();
$resPub = $stmtPub->get_result();

$publicaciones = [];
if ($resPub) {
    while ($fila = $resPub->fetch_assoc()) {
        $publicaciones[] = $fila;
    }
}

$stmtPub->close();
cerrarConexion($mysqli);

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        Publicaciones de <?php echo htmlspecialchars($centro['nombre']); ?> — EduForo
    </title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/public.css?v=<?php echo time(); ?>">
</head>

<body style="background:#ece9df;">

    <?php include 'php/componentes/navbar.php'; ?>

    <main class="container my-4">

        <a href="centro.php?id=<?php echo $centro['id']; ?>" class="page-linkback">
            ← Volver al perfil del centro
        </a>

        <section class="mt-3 mb-4">
            <h1 class="h4 mb-1">
                Publicaciones de <?php echo htmlspecialchars($centro['nombre']); ?>
            </h1>
            <p class="small text-muted mb-0">
                Nivel:
                <strong><?php echo htmlspecialchars($centro['nivel'] ?: 'No especificado'); ?></strong>
                |
                Ubicación:
                <?php
                $ubicacion = [];
                if (!empty($centro['provincia'])) {
                    $ubicacion[] = $centro['provincia'];
                }
                if (!empty($centro['canton'])) {
                    $ubicacion[] = $centro['canton'];
                }
                echo htmlspecialchars(implode(', ', $ubicacion) ?: 'No especificada');
                ?>
            </p>
        </section>

        <section class="mt-4">

    <?php if (empty($publicaciones)): ?>

        <div class="alert alert-info">
            Este centro no tiene publicaciones registradas todavía.
        </div>

    <?php else: ?>

        <div class="row g-3">

            <?php foreach ($publicaciones as $pub): ?>
                <div class="col-md-6 mep-card" id="pub-<?php echo $pub['id']; ?>">
                    <div class="card-min h-100 d-flex flex-column">

                        <h5 class="mb-1 text-truncate"
                            title="<?php echo htmlspecialchars($pub['titulo']); ?>">
                            <?php echo htmlspecialchars($pub['titulo']); ?>
                        </h5>

                        <span class="badge-soft mb-2">
                            Publicado:
                            <?php
                                echo !empty($pub['fecha_publicacion'])
                                    ? date("d/m/Y H:i", strtotime($pub['fecha_publicacion']))
                                    : "Sin fecha";
                            ?>
                        </span>

                        <p class="small text-muted-90 mb-3 flex-grow-1">
                            <?php
                                $texto = $pub['resumen'] ?: $pub['cuerpo'];
                                echo htmlspecialchars(mb_strimwidth($texto, 0, 150, "..."));
                            ?>
                        </p>

                        <a href="publicacion.php?id=<?php echo $pub['id']; ?>"
                           class="btn btn-brand-outline btn-sm mt-auto align-self-start">
                            Ver detalle
                        </a>

                    </div>
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
