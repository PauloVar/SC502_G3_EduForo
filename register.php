<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creación de Cuenta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="register-page">
    <div class="create-account-card">
        <h3>Crear Cuenta</h3>

        <form>

            <div class="mb-3">
                <label for="usuario" class="form-label">Nombre Completo</label>
                <input type="text" minlength="5" maxlength="50" class="form-control" name="nombre_Completo"  placeholder="Ingrese su nombre" id="nombre_Completo">
            </div>

            <div class="mb-3">
            <label for="email" class="form-label">Correo Eléctronico</label> <br>
            <input type="email" class="form-control"  name="email" placeholder="Ejemplo@correo.com" id="email">
            </div>

            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario</label>
                <input type="text" class="form-control" name="usuario" placeholder="Elija un nombre de usuario" id="usuario">
            </div>

            <div class="mb-3">
                <label for="contrasena" class="form-label">Contraseña</label>
                <input type="text" class="form-control" name="contrasena" placeholder="Cree una contraseña" id="contrasena">
            </div>

            <div class="mb-3">
                <label for="confirm_contrasena" class="form-label">Confirmar Contraseña</label>
                <input type="text" class="form-control" name="confirm_contrasena" placeholder="Confirme su contraseña" id="confirm_contrasena">
            </div>

            <div class="mb-3">
            <label for="fechaNac" class="form-label">Fecha Nacimiento:</label> <br>
            <input type="date" class="form-control" name="fechaNac" id="fechaNac">
            </div>
         
            <div class="mb-3">
            <label class="form-label">Género</label><br>

            <input type="radio" id="masculino" name="genero" value="masculino">
            <label for="masculino" class="form-link">Masculino</label>

            <input type="radio" id="femenino" name="genero" value="femenino">
            <label for="femenino" class="form-link">Femenino</label>

            <input type="radio" id="otro" name="genero" value="otro">
            <label for="otro" class="form-link">Otro</label>
            </div>

            <button type="submit" class="btn btn-brand btn-register">Registrarse</button>

            
            <div class="enlaces">
                <p class="form-link">
                ¿Ya tienes cuenta? <a href="login.php">Inicia Sesión</a>
                </p>
            </div>
        </form>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="assets/js/auth-register.js"></script>
</body>

</html>