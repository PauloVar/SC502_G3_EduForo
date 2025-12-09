document.getElementById("loginForm").addEventListener('submit', function (e) {

    //Previene el comportamiento por defecto del componente, en este caso, loginForm
    e.preventDefault();

    

    const username = document.getElementById("usuario").value.trim();
    const password = document.getElementById("contrasenna").value.trim();

    if (username.length == 0) {
        

        Swal.fire({
            icon: 'error',
            title: 'Ingrese su usuario',
            text: 'Debe ingresar un usuario válido.',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true
        })

        return;
    }

    if (!password) {
        Swal.fire({
            icon: 'error',
            title: 'Ingrese su contraseña',
            text: 'Debe ingresar una contraseña válida.',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true
        })
        return;
    }

    Swal.fire({
        icon: 'success',
        title: 'Éxito',
        text: 'Inicio de sesión exitoso. Bienvenido a EduForo: ' + username,
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 5000,
        timerProgressBar: true
    })

    setTimeout(() => {
        window.location.href = "Home.php"
    }, 3000)

});