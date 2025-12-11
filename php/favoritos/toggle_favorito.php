<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../conexionBD.php';
require '../helpers/auth.php';

requerirLogin('../../login.php');

$mysqli = abrirConexion();
$usuarioId = obtenerUsuarioId();

if (!$usuarioId) {
    header('Location: ../../login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar_centro_id'])) {
    $centroIdEliminar = intval($_POST['eliminar_centro_id']);

    $stmtDel = $mysqli->prepare(
        "DELETE FROM favoritos 
         WHERE usuario_id = ? AND centro_id = ?"
    );

    if ($stmtDel) {
        $stmtDel->bind_param("ii", $usuarioId, $centroIdEliminar);
        $stmtDel->execute();
        $stmtDel->close();
    }

    header("Location: toggle_favorito.php?status=eliminado");
    exit();
}

$sql = "SELECT c.id,
               c.nombre,
               c.codigo,
               c.provincia,
               c.canton,
               c.nivel,
               c.direccion,
               c.telefono,
               c.correo
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

<body style="background:#ece9df;">

    <?php include '../componentes/navbar.php'; ?>

    <main class="container my-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h4 mb-0">Mis Colegios Favoritos</h1>
                <p class="small text-muted mb-0">
                    Centros educativos que has marcado como favoritos.
                </p>
            </div>
        </div>

        <div class="row g-3">
            <?php if ($resultado && $resultado->num_rows > 0): ?>
                <?php while ($fila = $resultado->fetch_assoc()): ?>
                    <div class="col-md-4 mep-card">
                        <div class="card-min h-100 d-flex flex-column">
                            <h5 class="mb-1 text-truncate"
                                title="<?php echo htmlspecialchars($fila['nombre']); ?>">
                                <?php echo htmlspecialchars($fila['nombre']); ?>
                            </h5>

                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge-soft">
                                    Código: <?php echo htmlspecialchars($fila['codigo']); ?>
                                </span>
                                <span class="small text-muted">
                                    <?php echo htmlspecialchars($fila['nivel'] ?: 'Nivel no especificado'); ?>
                                </span>
                            </div>

                            <p class="small text-muted mb-1">
                                <?php
                                $ubicacion = [];
                                if (!empty($fila['provincia'])) {
                                    $ubicacion[] = $fila['provincia'];
                                }
                                if (!empty($fila['canton'])) {
                                    $ubicacion[] = $fila['canton'];
                                }
                                echo htmlspecialchars(implode(', ', $ubicacion) ?: 'Ubicación no registrada');
                                ?>
                            </p>

                            <?php if (!empty($fila['direccion'])): ?>
                                <p class="small text-muted mb-1">
                                    <?php echo htmlspecialchars($fila['direccion']); ?>
                                </p>
                            <?php endif; ?>

                            <p class="small text-muted mb-3">
                                <?php if (!empty($fila['telefono'])): ?>
                                    Tel: <?php echo htmlspecialchars($fila['telefono']); ?>
                                <?php endif; ?>
                                <?php if (!empty($fila['correo'])): ?>
                                    <?php if (!empty($fila['telefono'])) echo ' · '; ?>
                                    Correo: <?php echo htmlspecialchars($fila['correo']); ?>
                                <?php endif; ?>
                            </p>

                            <div class="mt-auto d-flex justify-content-between gap-2">
                                <a href="../../centro.php?id=<?php echo $fila['id']; ?>"
                                   class="btn btn-sm btn-brand flex-grow-1">
                                    Ver centro
                                </a>

                                <form method="post" class="m-0">
                                    <input type="hidden" name="eliminar_centro_id"
                                           value="<?php echo $fila['id']; ?>">
                                    <button type="submit"
                                            class="btn btn-sm btn-outline-danger">
                                        Quitar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info mb-0">
                        Todavía no has agregado colegios a tus favoritos.
                    </div>
                </div>
            <?php endif; ?>
        </div>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../../assets/js/navbar.js"></script>

    <script>
        (function () {
            const params = new URLSearchParams(window.location.search);
            if (params.get('status') === 'eliminado') {
                Swal.fire({
                    icon: 'success',
                    title: 'Favorito eliminado',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true
                });
            }
        })();
    </script>
</body>

</html>
<?php
$stmt->close();
cerrarConexion($mysqli);
?>
