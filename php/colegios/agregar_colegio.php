<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


include '../conexionBD.php';
$mysqli = abrirConexion();

$errors  = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre = trim($_POST['nombre'] ?? '');
    $codigo = trim($_POST['codigo'] ?? '');
    $provincia = trim($_POST['provincia'] ?? '');
    $canton = trim($_POST['canton'] ?? '');
    $nivel = trim($_POST['nivel'] ?? '');
    $direccion = trim($_POST['direccion'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $correo = trim($_POST['correo'] ?? '');

    $errors = [];

    if ($nombre === '') {
        $errors[] = "El nombre es obligatorio.";
    }

    if (mb_strlen($nombre) > 100) {
        $errors[] = "El nombre no puede superar los 100 caracteres.";
    }

    if ($codigo === '') {
        $errors[] = "El codigo es obligatorio.";
    }

    if (mb_strlen($codigo) > 6) {
        $errors[] = "El codigo no puede superar los 6 caracteres.";
    }

    if ($provincia === '') {
        $errors[] = "La provincia es obligatorio.";
    }

    if (mb_strlen($provincia) > 25) {
        $errors[] = "El codigo no puede superar los 25 caracteres.";
    }

    if ($canton === '') {
        $errors[] = "El canton es obligatorio.";
    }

    if (mb_strlen($canton) > 25) {
        $errors[] = "El canton no puede superar los 25 caracteres.";
    }

    if ($nivel === '') {
        $errors[] = "El canton es obligatorio.";
    }

    if (mb_strlen($nivel) > 25) {
        $errors[] = "El nivel no puede superar los 25 caracteres.";
    }

    if ($nivel === '') {
        $errors[] = "El canton es obligatorio.";
    }

    if (mb_strlen($nivel) > 25) {
        $errors[] = "El nivel no puede superar los 25 caracteres.";
    }

    if ($direccion === '') {
        $errors[] = "La direccion es obligatorio.";
    }

    if (mb_strlen($direccion) > 255) {
        $errors[] = "La direccion no puede superar los 25 caracteres.";
    }

    if ($telefono === '') {
        $errors[] = "La telefono es obligatorio.";
    }

    if (mb_strlen($telefono) > 8) {
        $errors[] = "La telefono no puede superar los 25 caracteres.";
    }

    if ($correo === '') {
        $errors[] = "La correo es obligatorio.";
    }

    if (mb_strlen($correo) > 100) {
        $errors[] = "La correo no puede superar los 25 caracteres.";
    }

    if (empty($errors)) {
        $sql = "INSERT INTO avisos_mep 
                (nombre, codigo, provincia, canton, nivel, direccion, telefono, correo)
                VALUES (?, ?, ?, ?, ?, ?, ?, ? NOW())";

        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param(
            "ssssssss",
            $nombre,
            $codigo, 
            $provincia, 
            $canton,
            $nivel,
            $direccion, 
            $telefono, 
            $correo 
        );

        if ($stmt->execute()) {
            header("Location: listar_avisos.php");
            exit();
        } else {
            $errors[] = "No se pudo guardar el aviso.";
        }

        $stmt->close();
    }
}
?>
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Centro Educativo</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/Home.css">
    <link rel="stylesheet" href="../../assets/css/public.css">
</head>

<body>

    <?php include '../componentes/navbar.php'; ?>

    <div class="container form-page-container my-4">
        <div class="card card-form">
            <div>
                <h3>Agregar Centro Educativo</h3>
            </div>
            <div class="card-body">

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
                        <input type="text"
                            class="form-control"
                            id="nombre"
                            name="nombre"
                            value="<?php echo htmlspecialchars($nombre ?? ''); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="codigo" class="form-label">Codigo</label>
                        <input type="text"
                            class="form-control"
                            id="codigo"
                            name="codigo"
                            value="<?php echo htmlspecialchars($codigo ?? ''); ?>">
                    </div>
                
                    <div class="mb-3">
                        <label for="provincia" class="form-label">provincia</label>
                        <input type="text"
                            class="form-control"
                            id="provincia"
                            name="provincia"
                            value="<?php echo htmlspecialchars($provincia ?? ''); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="canton" class="form-label">canton</label>
                        <input type="text"
                            class="form-control"
                            id="canton"
                            name="canton"
                            value="<?php echo htmlspecialchars($canton ?? ''); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="nivel" class="form-label">nivel</label>
                        <input type="text"
                            class="form-control"
                            id="nivel"
                            name="nivel"
                            value="<?php echo htmlspecialchars($nivel ?? ''); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="direccion" class="form-label">direccion</label>
                        <input type="text"
                            class="form-control"
                            id="direccion"
                            name="direccion"
                            value="<?php echo htmlspecialchars($direccion ?? ''); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="telefono" class="form-label">telefono</label>
                        <input type="text"
                            class="form-control"
                            id="telefono"
                            name="telefono"
                            value="<?php echo htmlspecialchars($telefono ?? ''); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="correo" class="form-label">correo</label>
                        <input type="text"
                            class="form-control"
                            id="correo"
                            name="correo"
                            value="<?php echo htmlspecialchars($correo ?? ''); ?>">
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            Agregar centro educativo
                        </button>
                        <a href="listar_colegio.php" class="btn btn-secondary">
                            Volver al listado
                        </a>
                    </div>


                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
</body>

</html>
<?php cerrarConexion($mysqli); ?>