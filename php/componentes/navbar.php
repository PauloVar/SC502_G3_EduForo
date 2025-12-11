<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../helpers/auth.php';


$baseUrl = '/SC502_G3_EduForo';

$estaLogueado  = usuarioEstaAutenticado();
$esAdmin       = usuarioEsAdmin();
$nombreUsuario = obtenerNombreUsuario();

?>
<header class="encabezado">
    <div class="encabezado-contenido">

        <div class="encabezado-marca">
            <img src="<?php echo $baseUrl; ?>/assets/img/logo-eduforo.svg" alt="Logo" class="logo-icono">
            <div class="marca-texto">
                <span class="marca-titulo">EduForo</span>
                <?php if ($esAdmin): ?>
                    <span class="marca-subtitulo">Panel de administración</span>
                <?php endif; ?>
            </div>
        </div>

        <nav class="encabezado-nav">
            <a href="<?php echo $baseUrl; ?>/Home.php" class="nav-item">Inicio</a>

            <a href="<?php echo $baseUrl; ?>/mep-avisos.php" class="nav-item">Avisos MEP</a>

            <?php if ($esAdmin): ?>
            <div class="nav-item dropdown">
                <span class="dropdown-toggle">Administración ▾</span>
                <div class="dropdown-menu">
                    <a href="<?php echo $baseUrl; ?>/adminColegios.php">Gestión de centros</a>
                    <a href="<?php echo $baseUrl; ?>/adminPublicaciones.php">Publicaciones de centros</a>

                    <a href="<?php echo $baseUrl; ?>/php/mep/listar_avisos.php">Avisos del MEP</a>
                </div>
            </div>
            <?php endif; ?>
        </nav>

        <div class="encabezado-usuario">
            <?php if ($estaLogueado): ?>
                <div class="usuario-dropdown">
                    <button class="usuario-btn">
                        <span class="usuario-avatar"><?php echo strtoupper($nombreUsuario[0]); ?></span>
                        <span><?php echo htmlspecialchars($nombreUsuario); ?></span>
                        <span class="flecha">▾</span>
                    </button>
                    <div class="usuario-menu">
                        <a href="<?php echo $baseUrl; ?>/perfil.php">Mi perfil</a>
                        <a href="<?php echo $baseUrl; ?>/php/login/logout.php">Cerrar sesión</a>
                    </div>
                </div>
            <?php else: ?>
                <a href="<?php echo $baseUrl; ?>/login.php" class="btn-login">Iniciar sesión</a>
                <a href="<?php echo $baseUrl; ?>/register.php" class="btn-register">Crear cuenta</a>
            <?php endif; ?>
        </div>

    </div>
</header>
