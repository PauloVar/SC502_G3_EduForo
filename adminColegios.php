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

        <form id="contactForm" action="">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre de la institución</label>
                <input type="text" class="form-control" name="nombre" id="nombre">
            </div>

            <div class="mb-3">
                <label for="codigo" class="form-label">Código</label>
                <input type="text" class="form-control" name="codigo" id="codigo">
            </div>

            <div class="mb-3">
                <label for="provincia">Provincia</label>
                <select id="provincia" class="form-control" name="provincia">
                    <option value="" selected disabled>Seleccione una provincia</option>
                    <option value="sanJose">San José</option>
                    <option value="heredia">Heredia</option>
                    <option value="alajuela">Alajuela</option>
                    <option value="cartago">Cartago</option>
                    <option value="puntarenas">Puntarenas</option>
                    <option value="limon">Limón</option>
                    <option value="guanacaste">Guanacaste</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="canton">Cantón</label>
                <select id="canton" class="form-control" name="canton">
                    <option value="" selected disabled>Seleccion un cantón</option>
                    <option value="canton1">Escazú</option>
                    <option value="canton2">Desamparados</option>
                    <option value="canton3">Coronado</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="nivel" class="form-label">Nivel</label>
                <input type="text" class="form-control" name="nivel" id="nivel">
            </div>

            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección</label><br>
                <textarea id="direccion" class="form-control" name="direccion" rows="4" cols="50"
                    maxlength="300"></textarea>
                <p id="contador" class=>0/300</p>
            </div>

            <div class="mb-3">
                <label for="telefono" class="form-label">Número de Teléfono</label>
                <input type="text" class="form-control" name="telefono" id="telefono">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico</label>
                <input type="text" class="form-control" name="email" id="email">
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
    <script src="assets/js/adminColegios.js"></script>

    

</body>


</html>