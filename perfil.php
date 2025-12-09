<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de usuario - EduForo</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/public.css">
</head>

<body style="background:#ece9df;">
    <header class="topbar">
        <a class="logo-container" href="Home.php" aria-label="Ir al inicio de EduForo">
            <div class="mx-auto mb-3" style="width:75px;">
                <img src="assets/img/logo-eduforo.svg" alt="EduForo Logo" class="logo">
            </div>
            <span class="logo-title">EduForo</span>
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

    <main class="container py-4">
        <section class="panel mb-4">
            <div class="d-flex align-items-center gap-3">
                <img src="assets/img/logo-eduforo.svg" alt="Avatar" style="width:72px;height:auto;">
                <div>
                    <h2 class="h4 mb-1">María Rodríguez</h2>
                    <p class="mb-0 text-muted">Administrador</p>
                </div>
            </div>
        </section>

        <section class="panel mb-4">
            <h3 class="h5 mb-3">Información de contacto</h3>
            <div class="row g-3">
                <div class="col-md-6">
                    <p class="mb-1 text-muted small">Correo electrónico</p>
                    <p class="mb-0">correo@eduforo.ed.cr</p>
                </div>
                <div class="col-md-6">
                    <p class="mb-1 text-muted small">Teléfono</p>
                    <p class="mb-0">+506 8888-8888</p>
                </div>
                <div class="col-md-6">
                    <p class="mb-1 text-muted small">Centro educativo</p>
                    <p class="mb-0"></p>
                </div>
                <div class="col-md-6">
                    <p class="mb-1 text-muted small">Rol</p>
                    <p class="mb-0">Administrador</p>
                </div>
            </div>
        </section>

    </main>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="assets/js/navbar.js"></script>
</body>

</html>