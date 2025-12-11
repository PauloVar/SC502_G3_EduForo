<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../conexionBD.php';
require '../helpers/auth.php';

if (!usuarioEsAdmin()) {
    header('Location: ../../Home.php');
    exit;
}

$conexion = abrirConexion();

$centroId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
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
    <title>Editar Centro Educativo</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/admin.css">
</head>


<body>

    <?php include '../componentes/navbar.php'; ?>

<div class="form-card">
            <div class="container form-page-container my-4">
                <div>
                    <h3>Editar Centro Educativo</h3>
                </div>
            
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach ($errors as $e): ?>
                                <li><?php echo htmlspecialchars($e ?? ''); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="post">

                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input
                        type="text"
                        name="nombre"
                        id="nombre"
                        class="form-control"
                        value="<?php echo htmlspecialchars($centro['nombre'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="codigo" class="form-label">Codigo</label>
                        <input
                        type="text"
                        name="codigo"
                        id="codigo"
                        class="form-control"
                        value="<?php echo htmlspecialchars($centro['codigo'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                    </div>
                
                    <div class="mb-3">
                        <label for="provincia" class="form-label">provincia</label>
                        <input
                        type="text"
                        name="provincia"
                        id="provincia"
                        class="form-control"
                        value="<?php echo htmlspecialchars($centro['provincia'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="canton" class="form-label">canton</label>
                        <input
                        type="text"
                        name="canton"
                        id="canton"
                        class="form-control"
                        value="<?php echo htmlspecialchars($centro['canton'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="nivel" class="form-label">nivel</label>
                        <input
                        type="text"
                        name="nivel"
                        id="nivel"
                        class="form-control"
                        value="<?php echo htmlspecialchars($centro['nivel'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="direccion" class="form-label">direccion</label>
                        <input
                        type="text"
                        name="direccion"
                        id="direccion"
                        class="form-control"
                        value="<?php echo htmlspecialchars($centro['direccion'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="telefono" class="form-label">telefono</label>
                        <input
                        type="text"
                        name="telefono"
                        id="telefono"
                        class="form-control"
                        value="<?php echo htmlspecialchars($centro['telefono'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="correo" class="form-label">correo</label>
                        <input
                        type="email"
                        name="correo"
                        id="correo"
                        class="form-control"
                        value="<?php echo htmlspecialchars($centro['correo'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                    </div>
                    
                    <button type="reset" class="btn btn-brand-outline btn-clean" id="btn-clean">Limpiar</button>
                    <button type="submit" class="btn btn-brand btn-submit">Publicar</button>
                    <a href="../../adminColegios.php" class="btn btn-brand-outline btn-clean">Volver al listado</a>
                </form>
            </div>
        
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../../assets/js/navbar.js"></script>
    <script src="../../assets/js/adminColegios.js"></script>
</body>

</html>