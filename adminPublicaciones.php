<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Educativo</title>

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
            <li><a href="adminPublicaciones.php" class="active">Publicaciones</a></li>
            <li><a href="adminColegios.php">Colegios</a></li>
        </ul>
    </nav>

    <div class="form-card">

        <form id="contactForm" action="">
            <div class="mb-3">
                <label for="titulo" class="form-label">Titulo de la Publicación</label>
                <input type="text" class="form-control" name="titulo" id="titulo">
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label><br>
                <textarea id="mensaje" class="form-control" name="mensaje" rows="4" cols="50"
                    maxlength="300"></textarea>
                <p id="contador" class=>0/300</p>
            </div>

            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha</label> <br>
                <input type="date" class="form-control" name="fecha" id="fecha">
            </div>


            <div class="mb-3">
                <label for="colegio">Institución</label>
                <select id="colegio" class="form-control" name="colegio">
                    <option value="" selected disabled>Seleccione una institución</option>
                    <option value="colegio1">Colegio Técnico de Heredia</option>
                    <option value="colegio2">Liceo de Alajuela</option>
                    <option value="colegio3">CTP Dos Cercas</option>
                </select>
            </div>

            <button type="reset" class="btn btn-brand-outline btn-clean" id="btn-clean">Limpiar</button>
            <button type="submit" class="btn btn-brand btn-submit">Publicar</button>

        </form>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="assets/js/navbar.js"></script>
    <script src="assets/js/adminPublicaciones.js"></script>

    <footer class="footer">
        <p>© 2025 EduForo. Todos los derechos reservados.</p>

    </footer>
</body>

</html>