<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Publicaciones del Centro — EduForo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/Home.css">
  <link rel="stylesheet" href="assets/css/public.css">
</head>

<body style="background:#ece9df;">
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
    <a href="centro.php" class="page-linkback">Volver al centro</a>
    <h1 class="h4 mt-3 page-title">Publicaciones — Colegio Técnico San José</h1>

    <div id="listaCentro" class="row g-3 mt-1">
      <div class="col-md-4 pub" data-visible="1">
        <div class="card-min h-100">
          <h5>Inscripción a talleres</h5>
          <p class="small text-muted-90 mb-2">Publicado: 20/10/2025</p>
          <p class="small mb-2">Talleres de robótica y redes — cupo limitado.</p>
          <a href="publicacion.php" class="btn btn-brand-outline btn-sm">Ver</a>
        </div>
      </div>

      <div class="col-md-4 pub" data-visible="1">
        <div class="card-min h-100">
          <h5>Entrega de notas</h5>
          <p class="small text-muted-90 mb-2">Publicado: 05/10/2025</p>
          <p class="small mb-2">Cronograma y salones asignados...</p>
          <a href="publicacion.php" class="btn btn-brand-outline btn-sm">Ver</a>
        </div>
      </div>

      <div class="col-md-4 pub" data-visible="0" style="display:none;">
        <div class="card-min h-100">
          <h5>Feria vocacional</h5>
          <p class="small text-muted-90 mb-2">Publicado: 15/09/2025</p>
          <p class="small mb-2">Universidades invitadas y charlas programadas.</p>
          <a href="publicacion.php" class="btn btn-brand-outline btn-sm">Ver</a>
        </div>
      </div>

      <div class="col-md-4 pub" data-visible="0" style="display:none;">
        <div class="card-min h-100">
          <h5>Convocatoria equipo deportivo</h5>
          <p class="small text-muted-90 mb-2">Publicado: 01/09/2025</p>
          <p class="small mb-2">Fútbol sala masculino y femenino.</p>
          <a href="publicacion.php" class="btn btn-brand-outline btn-sm">Ver</a>
        </div>
      </div>
    </div>

    <div class="text-center mt-3">
      <button id="btnMas" class="btn btn-brand">Mostrar más</button>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="assets/js/navbar.js"></script>
  <script src="assets/js/centro-publicaciones.js"></script>

</body>

</html>