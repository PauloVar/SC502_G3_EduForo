<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'php/conexionBD.php';
require 'php/helpers/auth.php';

$conexion = abrirConexion();

$sql = "SELECT id, titulo, resumen, cuerpo, enlace, fecha_publicacion
        FROM avisos_mep
        ORDER BY fecha_publicacion DESC";

$resultado = $conexion->query($sql);

$avisos = [];
if ($resultado && $resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $avisos[] = $fila;
    }
}

cerrarConexion($conexion);
?>
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

<body style="background:#ece9df;">

  <?php include 'php/componentes/navbar.php'; ?>

  <main class="container my-4">

    <div class="mb-3">
      <a href="Home.php" class="small text-muted text-decoration-none">
        ← Volver a inicio
      </a>
    </div>

    <header class="mb-3">
      <h1 class="h4 mb-1">Avisos del MEP</h1>
      <p class="small text-muted mb-0">
        Consulta los avisos generales publicados por el Ministerio de Educación Pública.
      </p>
    </header>

    <div id="listaAvisos" class="row g-3">
      <?php if (empty($avisos)): ?>
        <div class="col-12">
          <p class="text-muted mt-3">No hay avisos registrados.</p>
        </div>
      <?php else: ?>
        <?php foreach ($avisos as $aviso): ?>
          <div class="col-md-4 mep-card" id="aviso-<?php echo $aviso['id']; ?>">
            <div class="card-min h-100 d-flex flex-column">

              <h5 class="mb-1 text-truncate" title="<?php echo htmlspecialchars($aviso['titulo']); ?>">
                <?php echo htmlspecialchars($aviso['titulo']); ?>
              </h5>

              <span class="badge-soft mb-2">
                <?php
                  if (!empty($aviso['fecha_publicacion'])) {
                      echo date('d/m/Y', strtotime($aviso['fecha_publicacion']));
                  } else {
                      echo 'Aviso MEP';
                  }
                ?>
              </span>

              <p class="small text-muted-90 mb-2 flex-grow-1">
                <?php
                  $texto = $aviso['resumen'] ?: $aviso['cuerpo'];
                  echo htmlspecialchars(mb_strimwidth($texto, 0, 120, '...'));
                ?>
              </p>

              <button
                type="button"
                class="btn btn-brand-outline btn-sm mt-auto align-self-start btn-ver-detalle"
                data-aviso-id="<?php echo $aviso['id']; ?>">
                Ver detalle
              </button>

              <div
                class="aviso-detalle mt-2"
                id="detalle-<?php echo $aviso['id']; ?>"
                style="display:none;">

                <p class="small mb-2">
                  <?php echo nl2br(htmlspecialchars($aviso['cuerpo'])); ?>
                </p>

                <?php if (!empty($aviso['enlace'])): ?>
                  <p class="small mb-0">
                    Más información:
                    <a href="<?php echo htmlspecialchars($aviso['enlace']); ?>" target="_blank">
                      <?php echo htmlspecialchars($aviso['enlace']); ?>
                    </a>
                  </p>
                <?php endif; ?>
              </div>

            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('click', function (e) {
      if (e.target.classList.contains('btn-ver-detalle')) {
        const id = e.target.getAttribute('data-aviso-id');
        const detalle = document.getElementById('detalle-' + id);
        if (!detalle) return;

        if (detalle.style.display === 'none' || detalle.style.display === '') {
          detalle.style.display = 'block';
          e.target.textContent = 'Ocultar detalle';
        } else {
          detalle.style.display = 'none';
          e.target.textContent = 'Ver detalle';
        }
      }
    });

    window.addEventListener('DOMContentLoaded', function () {
      const hash = window.location.hash;
      if (!hash || !hash.startsWith('#aviso-')) return;

      const card = document.querySelector(hash);
      if (!card) return;

      const btn = card.querySelector('.btn-ver-detalle');
      const detalle = card.querySelector('.aviso-detalle');

      if (btn && detalle) {
        detalle.style.display = 'block';
        btn.textContent = 'Ocultar detalle';
        card.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  </script>
</body>

</html>
