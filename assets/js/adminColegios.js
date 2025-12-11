document.getElementById("contactForm").addEventListener('submit', function (e) {
    e.preventDefault();

    const nombre    = document.getElementById("nombre").value.trim();
    const codigo    = document.getElementById("codigo").value.trim();
    const provincia = document.getElementById("provincia").value;
    const canton    = document.getElementById("canton").value;
    const nivel     = document.getElementById("nivel").value;
    const direccion = document.getElementById("direccion").value.trim();
    const telefono  = document.getElementById("telefono").value.trim();
    const email     = document.getElementById("email").value.trim();

    if (nombre.length === 0) {
        Swal.fire({
            icon: 'error',
            title: 'Datos faltantes',
            text: 'Debe ingresar el nombre de la institución.',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true
        });
        return;
    }

    if (codigo.length === 0) {
        Swal.fire({
            icon: 'error',
            title: 'Datos faltantes',
            text: 'Debe ingresar un código válido.',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true
        });
        return;
    }

    if (!provincia) {
        Swal.fire({
            icon: 'error',
            title: 'Datos faltantes',
            text: 'Debe seleccionar una provincia.',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true
        });
        return;
    }

    if (!canton) {
        Swal.fire({
            icon: 'error',
            title: 'Datos faltantes',
            text: 'Debe seleccionar un cantón.',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true
        });
        return;
    }

    if (nivel.length === 0) {
        Swal.fire({
            icon: 'error',
            title: 'Datos faltantes',
            text: 'Debe ingresar un código válido.',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true
        });
        return;
    }

    if (direccion.length === 0) {
        Swal.fire({
            icon: 'error',
            title: 'Datos faltantes',
            text: 'Debe ingresar una dirección válida.',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true
        });
        return;
    }

    if (telefono.length === 0) {
        Swal.fire({
            icon: 'error',
            title: 'Datos faltantes',
            text: 'Debe ingresar un número de teléfono válido.',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true
        });
        return;
    }

    if (email.length === 0) {
        Swal.fire({
            icon: 'error',
            title: 'Datos faltantes',
            text: 'Debe ingresar un correo electrónico válido.',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true
        });
        return;
    }

    Swal.fire({
        icon: 'success',
        title: 'Éxito',
        text: 'Institución registrada correctamente.',
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 5000,
        timerProgressBar: true
    });

    setTimeout(() => {
        document.getElementById("contactForm").reset();
        document.getElementById("contador").textContent = "0/300";
    }, 3000);
});

document.getElementById("direccion").addEventListener("input", function () {
    const max    = 300;
    const actual = this.value.length;
    document.getElementById("contador").textContent = `${actual}/${max}`;
});