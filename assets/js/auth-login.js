document.getElementById("loginForm").addEventListener('submit', async function (e) {

    //Previene el comportamiento por defecto del componente, en este caso, loginForm
    e.preventDefault();

    

    const usuario = document.getElementById("usuario").value.trim();
    const contrasenna = document.getElementById("contrasenna").value.trim();

    if (usuario.length == 0) {
        

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

    if (!contrasenna) {
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

    //Hace login


    try {

        const respuesta = await fetch('php/login/login.php', {
            method: 'POST',
            header: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ usuario, contrasenna })
        })

        const texto = await respuesta.text()
        let data;

        data = JSON.parse(texto)


        if (data.status === 'ok') {

            //Redirigir a home
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: 'Inicio de sesión exitoso. Bienvenido a EduForo: ' + data.nombre,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true
            })

            setTimeout(() => {
                window.location.href = "Home.php"
            }, 3000)

        } else {


            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.mensaje,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true
            })

        }


    } catch (error) {

        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se logró contactar al servidor. Error: ' + error,
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true
        })
    }






    /*
    //Redirige a Home
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
    }, 3000)*/

});