<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'php/helpers/auth.php';
require 'php/conexionBD.php';

$conexion = abrirConexion();

$sqlAvisos = "SELECT id, titulo, resumen, cuerpo, fecha_publicacion
              FROM avisos_mep
              ORDER BY fecha_publicacion DESC
              LIMIT 3";

$resAvisos = $conexion->query($sqlAvisos);

$avisosMep = [];
if ($resAvisos && $resAvisos->num_rows > 0) {
    while ($fila = $resAvisos->fetch_assoc()) {
        $avisosMep[] = $fila;
    }
}

$filtroCentro = trim($_GET['centro'] ?? '');
$centros = [];

if ($filtroCentro !== '') {
    $sqlCentros = "SELECT id, nombre, codigo, provincia, canton, nivel, direccion, telefono, correo
                   FROM centros
                   WHERE nombre LIKE ? OR codigo LIKE ?
                   ORDER BY nombre ASC
                   LIMIT 50";

    $stmt = $conexion->prepare($sqlCentros);
    $like = '%' . $filtroCentro . '%';
    $stmt->bind_param("ss", $like, $like);
    $stmt->execute();
    $resultadoCentros = $stmt->get_result();

    if ($resultadoCentros && $resultadoCentros->num_rows > 0) {
        while ($fila = $resultadoCentros->fetch_assoc()) {
            $centros[] = $fila;
        }
    }

    $stmt->close();

} else {
    $sqlTodos = "SELECT id, nombre, codigo, provincia, canton, nivel, direccion, telefono, correo
                 FROM centros
                 ORDER BY nombre ASC
                 LIMIT 50";

    $resTodos = $conexion->query($sqlTodos);

    if ($resTodos && $resTodos->num_rows > 0) {
        while ($fila = $resTodos->fetch_assoc()) {
            $centros[] = $fila;
        }
    }
}

cerrarConexion($conexion);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduForo - Inicio</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/Home.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/public.css?v=<?php echo time(); ?>">
</head>

<body style="background:#ece9df;">

    <?php include 'php/componentes/navbar.php'; ?>

    <main class="container my-4">

        <section class="mb-4">
            <h1 class="h4 mb-2">Bienvenido a EduForo</h1>
            <p class="small text-muted mb-0">
                Plataforma para consultar información de centros educativos, avisos del MEP
                y publicaciones de los colegios.
            </p>
        </section>

        <section class="mb-4">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h2 class="h5 mb-0">Últimos avisos del MEP</h2>
                <a href="mep-avisos.php" class="btn btn-sm btn-primary">
                    Ver todos los avisos
                </a>
            </div>

            <?php if (empty($avisosMep)): ?>
                <div class="alert alert-info mb-0">
                    No hay avisos registrados por el momento.
                </div>
            <?php else: ?>
                <div class="row g-3">
                    <?php foreach ($avisosMep as $aviso): ?>
                        <div class="col-md-4 mep-card" id="aviso-<?php echo $aviso['id']; ?>">
                            <div class="card-min h-100 d-flex flex-column">

                                <h5 class="mb-1 text-truncate"
                                    title="<?php echo htmlspecialchars($aviso['titulo']); ?>">
                                    <?php echo htmlspecialchars($aviso['titulo']); ?>
                                </h5>

                                <span class="badge-soft mb-2">
                                    <?php
                                        if (!empty($aviso['fecha_publicacion'])) {
                                            echo date('d/m/Y', strtotime($aviso['fecha_publicacion']));
                                        } else {
                                            echo 'Aviso MEP';
                                        }
                                    ?>
                                </span>

                                <p class="small text-muted-90 mb-2 flex-grow-1">
                                    <?php
                                        $texto = $aviso['resumen'] ?: $aviso['cuerpo'];
                                        echo htmlspecialchars(mb_strimwidth($texto, 0, 120, '...'));
                                    ?>
                                </p>

                                <a href="mep-avisos.php#aviso-<?php echo $aviso['id']; ?>"
                                   class="btn btn-brand-outline btn-sm mt-auto align-self-start">
                                    Ver detalle
                                </a>

                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>

        <section class="mb-4">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h2 class="h5 mb-0">Centros educativos</h2>
    </div>

    <form class="row g-2 mb-3" method="get" action="Home.php">
        <div class="col-md-9">
            <input
                type="text"
                name="centro"
                class="form-control"
                placeholder="Buscar por nombre o código del centro..."
                value="<?php echo htmlspecialchars($filtroCentro); ?>">
        </div>
        <div class="col-md-3 d-grid d-md-flex">
            <button type="submit" class="btn btn-brand w-100">
                Buscar centro
            </button>
        </div>
    </form>

    <?php if (empty($centros)): ?>
        <div class="alert alert-info mb-0">
            <?php if ($filtroCentro === ''): ?>
                No hay centros registrados en el sistema.
            <?php else: ?>
                No se encontraron centros que coincidan con "<?php echo htmlspecialchars($filtroCentro); ?>".
            <?php endif; ?>
        </div>

    <?php else: ?>
        <div class="row g-3">
            <?php foreach ($centros as $centro): ?>
                <div class="col-md-4 mep-card">
                    <div class="card-min h-100 d-flex flex-column">

                        <h5 class="mb-1 text-truncate"
                            title="<?php echo htmlspecialchars($centro['nombre']); ?>">
                            <?php echo htmlspecialchars($centro['nombre']); ?>
                        </h5>

                        <span class="badge-soft mb-2">
                            Código: <?php echo htmlspecialchars($centro['codigo']); ?>
                        </span>

                        <p class="small text-muted mb-1">
                            <?php
                                $ubicacion = [];
                                if (!empty($centro['provincia'])) $ubicacion[] = $centro['provincia'];
                                if (!empty($centro['canton']))    $ubicacion[] = $centro['canton'];
                                echo htmlspecialchars(implode(', ', $ubicacion) ?: 'Ubicación no registrada');
                            ?>
                        </p>

                        <?php if (!empty($centro['nivel'])): ?>
                            <p class="small text-muted mb-1">
                                Nivel: <?php echo htmlspecialchars($centro['nivel']); ?>
                            </p>
                        <?php endif; ?>

                        <p class="small text-muted mb-3">
                            <?php if (!empty($centro['telefono'])): ?>
                                Tel: <?php echo htmlspecialchars($centro['telefono']); ?>
                            <?php endif; ?>
                            <?php if (!empty($centro['correo'])): ?>
                                <?php if (!empty($centro['telefono'])) echo ' · '; ?>
                                Correo: <?php echo htmlspecialchars($centro['correo']); ?>
                            <?php endif; ?>
                        </p>

                        <div class="mt-auto d-flex gap-2">
                            <a href="centro.php?id=<?php echo $centro['id']; ?>"
                               class="btn btn-brand-outline btn-sm flex-grow-1">
                                Ver centro
                            </a>
                            <a href="centro-publicaciones.php?centro_id=<?php echo $centro['id']; ?>"
                               class="btn btn-brand btn-sm flex-grow-1">
                                Ver avisos
                            </a>
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>


    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
