<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$esRutaAdmin = (strpos($_SERVER['PHP_SELF'], '/admin/') !== false);
$basePath = $esRutaAdmin ? '..' : '.';


$estaLogueado = isset($_SESSION['usuario_id']);
$esAdmin = $estaLogueado && !empty($_SESSION['es_admin']) && $_SESSION['es_admin'] == 1;
$nombreUsuario = $estaLogueado ? ($_SESSION['usuario'] ?? 'Usuario') : null;
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?php echo $basePath; ?>/home.php">
            EduForo
        </a>

        <div class="collapse navbar-collapse" id="navbarEduforo">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $basePath; ?>/home.php">
                        Inicio
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $basePath; ?>/mep-avisos.php">
                        Avisos MEP
                    </a>
                </li>

                <?php if ($esAdmin): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarAdminDropdown" role="button"
                           data-bs-toggle="dropdown" aria-expanded="false">
                            Administración
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarAdminDropdown">
                            <li>
                                <a class="dropdown-item" href="<?php echo $basePath; ?>/admin/centros.php">
                                    Gestión de centros
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?php echo $basePath; ?>/admin/publicaciones.php">
                                    Publicaciones de centros
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?php echo $basePath; ?>/admin/mep-avisos.php">
                                    Avisos del MEP
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>

            <ul class="navbar-nav mb-2 mb-lg-0">
                <?php if ($estaLogueado): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $basePath; ?>/perfil.php">
                            <?php echo htmlspecialchars($nombreUsuario); ?>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $basePath; ?>/php/login/logout.php">
                            Cerrar sesión
                        </a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $basePath; ?>/login.php">
                            Iniciar sesión
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $basePath; ?>/register.php">
                            Crear cuenta
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
