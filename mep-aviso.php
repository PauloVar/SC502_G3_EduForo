<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Aviso del MEP — EduForo</title>
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
    <a href="mep-avisos.php" class="page-linkback">Volver a Avisos del MEP</a>
    <article class="panel mt-3">
      <h1 class="h4 mb-1 page-title">Proceso de matrícula 2026</h1>
      <p class="small text-muted-90 mb-2">Publicado: 05/11/2025 — Etiqueta: Matrícula</p>
      <p>Se habilitan los periodos y requisitos oficiales para matrícula del curso lectivo 2026...</p>

      <h2 class="h6 mt-3">Adjuntos</h2>
      <ul class="small">
        <li><a href="#" class="text-decoration-none">Guía de matrícula (PDF)</a></li>
        <li><a href="#" class="text-decoration-none">Requisitos (PDF)</a></li>
      </ul>
      
    </article>
  </main>
  
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="assets/js/navbar.js"></script>

</body>
</html>
