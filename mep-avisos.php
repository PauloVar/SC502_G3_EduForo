<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Avisos del MEP — EduForo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/Home.css">
  <link rel="stylesheet" href="assets/css/public.css">
</head>

<body>

  <header class="topbar">
    <a class="logo-container" href="Home.php" aria-label="Ir al inicio de EduForo">
      <img src="assets/img/logo-eduforo.svg" class="logo" alt="EduForo">
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

  <main class="container my-4">
    <a href="home.php" class="page-linkback">Volver a inicio</a>
    <h1 class="h4 page-title mt-2 mb-3">Avisos del MEP</h1>

    <form class="row g-2 panel mb-3" id="filtroMep">
      <div class="col-md-6">
        <input id="qMep" type="text" class="form-control" placeholder="Buscar por título...">
      </div>
      <div class="col-md-3">
        <select id="tagMep" class="form-select">
          <option value="">Todas las etiquetas</option>
          <option value="matrícula">Matrícula</option>
          <option value="eventos">Eventos</option>
          <option value="circulares">Circulares</option>
        </select>
      </div>
      <div class="col-md-3">
        <button class="btn btn-brand w-100" type="submit">Filtrar</button>
      </div>
    </form>

    <div id="listaAvisos" class="row g-3">
      <div class="col-md-4 mep-card" data-tags="matrícula">
        <div class="card-min h-100">
          <h5 class="mb-1">Proceso de matrícula 2026</h5>
          <span class="badge-soft mb-2">Matrícula</span>
          <p class="small text-muted-90 mb-2">Fechas y requisitos oficiales para matrícula...</p>
          <a href="mep-aviso.php" class="btn btn-brand-outline btn-sm">Ver detalle</a>
        </div>
      </div>
      <div class="col-md-4 mep-card" data-tags="eventos">
        <div class="card-min h-100">
          <h5 class="mb-1">Feria Nacional de Ciencia</h5>
          <span class="badge-soft mb-2">Eventos</span>
          <p class="small text-muted-90 mb-2">Convocatoria y lineamientos para la feria...</p>
          <a href="mep-aviso.php" class="btn btn-brand-outline btn-sm">Ver detalle</a>
        </div>
      </div>
      <div class="col-md-4 mep-card" data-tags="circulares">
        <div class="card-min h-100">
          <h5 class="mb-1">Circular 15-2025: Protocolos</h5>
          <span class="badge-soft mb-2">Circulares</span>
          <p class="small text-muted-90 mb-2">Actualización de protocolos institucionales...</p>
          <a href="mep-aviso.php" class="btn btn-brand-outline btn-sm">Ver detalle</a>
        </div>
      </div>
    </div>

    <p id="sinResultados" class="text-muted mt-3" style="display:none;">No hay avisos con ese criterio.</p>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="assets/js/navbar.js"></script>
  <script src="assets/js/mep-avisos.js"></script>

  <footer class="footer">
        <p>© 2025 EduForo. Todos los derechos reservados.</p>
    </footer>
  
</body>

</html>