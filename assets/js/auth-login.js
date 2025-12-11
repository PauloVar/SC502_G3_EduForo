document.getElementById("loginForm").addEventListener('submit', async function (e) {
    e.preventDefault();

    const usuario = document.getElementById("usuario").value.trim();
    const contrasenna = document.getElementById("contrasenna").value.trim();

    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true,
    });

    if (usuario.length === 0 || contrasenna.length === 0) {
        Toast.fire({
            icon: "warning",
            title: "Debe ingresar usuario y contraseña."
        });
        return;
    }

    try {
        const respuesta = await fetch('php/login/login.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                usuario: usuario,
                contrasenna: contrasenna
            })
        });

        const data = await respuesta.json();
        console.log("Respuesta login:", data);

        if (data.status === 'ok') {
            const msg = data.mensaje || 'Inicio de sesión exitoso';

            Toast.fire({
                icon: 'success',
                title: msg
            });

            setTimeout(function () {
                window.location.href = 'Home.php';
            }, 1200);

        } else {
            const msg = data.mensaje || 'No se pudo iniciar sesión. Revise sus datos.';
            Toast.fire({
                icon: 'error',
                title: msg
            });
        }

    } catch (error) {
        console.error(error);
        Toast.fire({
            icon: 'error',
            title: 'Error de conexión con el servidor.'
        });
    }
});
