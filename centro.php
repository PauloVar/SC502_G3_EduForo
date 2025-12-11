<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'php/conexionBD.php';
require 'php/helpers/auth.php';

$conexion = abrirConexion();

$centroId = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$centro = null;

if ($centroId > 0) {
    $sql = "SELECT id, nombre, codigo, provincia, canton, nivel, direccion, telefono, correo
            FROM centros
            WHERE id = ?";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $centroId);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado && $resultado->num_rows === 1) {
        $centro = $resultado->fetch_assoc();
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
        <?php echo $centro ? htmlspecialchars($centro['nombre']) . ' — EduForo' : 'Centro educativo — EduForo'; ?>
    </title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/Home.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/public.css?v=<?php echo time(); ?>">
</head>

<body style="background:#ece9df;">

    <?php include 'php/componentes/navbar.php'; ?>

    <main class="container my-4">

        <div class="mb-3">
            <a href="Home.php#centros" class="small text-muted text-decoration-none">
                ← Volver al buscador
            </a>
        </div>

        <?php if (!$centro): ?>

            <div class="alert alert-warning">
                No se encontró información para el centro solicitado.
            </div>

        <?php else: ?>

            <article class="panel panel-centro">

                <div class="d-flex align-items-start gap-3 mb-2">
                    <div class="centro-icono">
                        <img src="assets/img/logo-eduforo.svg" alt="Centro" class="centro-icono-img">
                    </div>

                    <div>
                        <h1 class="h4 mb-1">
                            <?php echo htmlspecialchars($centro['nombre']); ?>
                        </h1>

                        <p class="small text-muted mb-1">
                            <?php
                                $ubicacion = [];
                                if (!empty($centro['provincia'])) $ubicacion[] = $centro['provincia'];
                                if (!empty($centro['canton']))    $ubicacion[] = $centro['canton'];
                                if (!empty($centro['nivel']))     $ubicacion[] = $centro['nivel'];

                                echo htmlspecialchars(implode(' — ', $ubicacion));
                            ?>
                        </p>

                        <p class="small text-muted mb-0">
                            <?php if (!empty($centro['telefono'])): ?>
                                Tel: <?php echo htmlspecialchars($centro['telefono']); ?>
                            <?php endif; ?>

                            <?php if (!empty($centro['correo'])): ?>
                                <?php if (!empty($centro['telefono'])) echo ' — '; ?>
                                Email: <?php echo htmlspecialchars($centro['correo']); ?>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>

                <hr class="my-3">

                <p class="small mb-4">
                    <?php
                        if (!empty($centro['direccion'])) {
                            echo htmlspecialchars($centro['direccion']);
                        } else {
                            echo 'Centro educativo registrado en la plataforma.';
                        }
                    ?>
                </p>

                <a href="centro-publicaciones.php?centro_id=<?php echo $centro['id']; ?>"
                   class="btn btn-brand">
                    Ver publicaciones
                </a>

            </article>

        <?php endif; ?>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
