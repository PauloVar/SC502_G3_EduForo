<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'php/conexionBD.php';

$mysqli = abrirConexion();

$sql = "SELECT id, nombre, codigo, provincia, canton, nivel, direccion, telefono, correo 
        FROM centros
        ORDER BY id DESC";

$resultado = $mysqli->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduForo</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/admin.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <header class="topbar">
        <a class="logo-container" href="Home.php" aria-label="Ir al inicio de EduForo">
            <img src="assets/img/logo-eduforo.svg" alt="EduForo Logo" class="logo">
            <span class="logo-text-group">
                <span class="logo-title">EduForo</span>
                <span class="logo-subtitle">Panel de administración</span>
            </span>
        </a>
        <div class="dropdown">
            <button type="button" class="dropbtn">
                <span class="user-avatar" aria-hidden="true">U</span>
                <span class="user-name">Usuario</span>
                <span class="user-caret" aria-hidden="true">▾</span>
            </button>
            <div class="dropdown-content">
                <a href="perfil.php">Perfil</a>
                <a href="adminPublicaciones.php">Panel de admin</a>
                <a href="#" data-action="logout">Cerrar sesión</a>
            </div>
        </div>
    </header>

    <nav class="navBar">
        <ul>
            <li><a href="/adminPublicaciones.php" class="active">Publicaciones</a></li>
            <li><a href="/adminColegios.php" class="active">Colegios</a></li>
        </ul>
    </nav>

    <div class="form-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h4 mb-0">Gestión de Centros de educación: Colegios</h1>
                <p class="small text-muted mb-0">Listado de centros del colegio</p>
            </div>
            <a href="php/centros/agregar_centro.php" class="btn btn-brand">+ Nuevo colegio</a>
        </div>

        <div class="row g-3">
             <?php if ($resultado->num_rows > 0): ?>
                <?php while ($fila = $resultado->fetch_assoc()): ?>
                    <div class="col-md-4 card px-0">
                        <div class="card-gestion h-100 d-flex flex-column p-4 m-0" style="background: #f1e7c1ff;">
                            <h5 class="mb-1 text-truncate" title="<?php echo htmlspecialchars($fila['nombre']); ?>">
                                <?php echo htmlspecialchars($fila['nombre']); ?>
                            </h5>

                            <p class="small text-muted-90 mb-3 flex-grow-1">
                                <?php echo htmlspecialchars(mb_strimwidth($fila['provincia'], 0, 100, "...")); ?>
                            </p>

                            <span class="badge-soft mb-2 align-self-start">
                                <?php echo htmlspecialchars($fila['nivel']); ?>
                            </span>

                            <div class="d-flex gap-2 mt-auto">
                                <a href="php/centros/editar_centro.php?id=<?php echo $fila['id']; ?>"
                                    class="btn btn-brand btn-submit">Editar</a>

                                <a href="php/centros/eliminar_centro.php?id=<?php echo $fila['id']; ?>"
                                    class="btn btn-brand">Eliminar</a>
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
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="assets/js/navbar.js"></script>
    <script src="assets/js/adminColegios.js"></script>

    

</body>


</html>