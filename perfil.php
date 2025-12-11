<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'php/conexionBD.php';
require 'php/helpers/auth.php';

if (!usuarioEstaAutenticado()) {
    header('Location: login.php');
    exit;
}

$conexion = abrirConexion();

$usuarioId = (int)$_SESSION['id'];

$sql = "SELECT id, nombre, correo, usuario, fecha_nacimiento, genero, es_admin
        FROM usuarios
        WHERE id = ?";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $usuarioId);
$stmt->execute();
$resultado = $stmt->get_result();

$usuario = $resultado && $resultado->num_rows === 1
    ? $resultado->fetch_assoc()
    : null;

$stmt->close();
cerrarConexion($conexion);

if (!$usuario) {
    $usuario = [
        'nombre'           => $_SESSION['nombre'] ?? 'Usuario',
        'correo'           => '',
        'usuario'          => $_SESSION['usuario'] ?? '',
        'fecha_nacimiento' => null,
        'genero'           => null,
        'es_admin'         => $_SESSION['es_admin'] ?? 0,
    ];
}

$rol    = !empty($usuario['es_admin']) ? 'Administrador' : 'Usuario';
$inicial = strtoupper(mb_substr($usuario['nombre'], 0, 1, 'UTF-8'));

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi perfil — EduForo</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/Home.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/public.css?v=<?php echo time(); ?>">
</head>

<body style="background:#ece9df;">

<?php include 'php/componentes/navbar.php'; ?>

<main class="container my-4">

    <section class="perfil-card mb-3">
        <div class="d-flex align-items-center gap-3">
            <div class="perfil-avatar">
                <span><?php echo htmlspecialchars($inicial); ?></span>
            </div>
            <div>
                <h1 class="h5 mb-1">
                    <?php echo htmlspecialchars($usuario['nombre']); ?>
                </h1>
                <p class="small text-muted mb-0">
                    <?php echo htmlspecialchars($rol); ?>
                </p>
            </div>
        </div>
    </section>

    <section class="perfil-card">
        <h2 class="h6 text-center mb-3">Información de cuenta</h2>

        <div class="row">
            <div class="col-md-6 mb-3 mb-md-0">
                <p class="small text-muted mb-1">Correo electrónico</p>
                <p class="mb-3">
                    <?php echo htmlspecialchars($usuario['correo'] ?: 'No registrado'); ?>
                </p>

                <p class="small text-muted mb-1">Nombre de usuario</p>
                <p class="mb-0">
                    <?php echo htmlspecialchars($usuario['usuario']); ?>
                </p>
            </div>

            <div class="col-md-6">
                <p class="small text-muted mb-1">Fecha de nacimiento</p>
                <p class="mb-3">
                    <?php
                        if (!empty($usuario['fecha_nacimiento'])) {
                            echo date('d/m/Y', strtotime($usuario['fecha_nacimiento']));
                        } else {
                            echo 'No registrada';
                        }
                    ?>
                </p>

                <p class="small text-muted mb-1">Género</p>
                <p class="mb-3">
                    <?php
                        $genero = $usuario['genero'];
                        if ($genero === 'masculino') {
                            echo 'Masculino';
                        } elseif ($genero === 'femenino') {
                            echo 'Femenino';
                        } elseif ($genero === 'otro') {
                            echo 'Otro';
                        } else {
                            echo 'No especificado';
                        }
                    ?>
                </p>

                <p class="small text-muted mb-1">Rol</p>
                <p class="mb-0">
                    <?php echo htmlspecialchars($rol); ?>
                </p>
            </div>
        </div>
    </section>

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
