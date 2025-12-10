<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../conexionBD.php';

$mysqli = abrirConexion();

$sql = "SELECT id, titulo, resumen, cuerpo, enlace, fecha_publicacion 
        FROM avisos_mep 
        ORDER BY fecha_publicacion DESC";

$resultado = $mysqli->query($sql);

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Avisos MEP</title>
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
                <h1 class="h4 mb-0">Gestión de Avisos MEP</h1>
                <p class="small text-muted mb-0">Administra los avisos del MEP</p>
            </div>
            <a href="agregar_aviso.php" class="btn btn-brand">+ Nuevo Aviso</a>
        </div>

        <div class="row g-3">
            <?php if ($resultado->num_rows > 0): ?>
                <?php while ($fila = $resultado->fetch_assoc()): ?>
                    <div class="col-md-4 mep-card">
                        <div class="card-min h-100 d-flex flex-column">
                            <h5 class="mb-1 text-truncate" title="<?php echo htmlspecialchars($fila['titulo']); ?>">
                                <?php echo htmlspecialchars($fila['titulo']); ?>
                            </h5>

                            <span class="badge-soft mb-2 align-self-start">
                                <?php echo date('d/m/Y', strtotime($fila['fecha_publicacion'])); ?>
                            </span>

                            <?php if (!empty($fila['resumen'])): ?>
                                <p class="small fw-bold mb-1">
                                    <?php echo htmlspecialchars($fila['resumen']); ?>
                                </p>
                            <?php endif; ?>

                            <p class="small text-muted-90 mb-3 flex-grow-1">
                                <?php echo htmlspecialchars(mb_strimwidth($fila['cuerpo'], 0, 100, "...")); ?>
                            </p>

                            <?php if (!empty($fila['enlace'])): ?>
                                <div class="mb-3">
                                    <a href="<?php echo htmlspecialchars($fila['enlace']); ?>" target="_blank" class="small text-decoration-none text-truncate d-block" title="<?php echo htmlspecialchars($fila['enlace']); ?>">
                                        🔗 <?php echo htmlspecialchars($fila['enlace']); ?>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <div class="d-flex gap-2 mt-auto">
                                <a href="editar_aviso.php?id=<?php echo $fila['id']; ?>"
                                    class="btn btn-primary">Editar</a>
                                <a href="eliminar_aviso.php?id=<?php echo $fila['id']; ?>"
                                    class="btn btn-danger">Eliminar</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12">
                    <p class="text-muted text-center mt-4">No hay avisos registrados.</p>
                </div>
            <?php endif; ?>
        </div>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php
$resultado->free();
cerrarConexion($mysqli);
?>