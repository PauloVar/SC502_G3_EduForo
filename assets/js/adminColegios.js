document.getElementById("contactForm").addEventListener('submit', function (e) {
    
    const nombre    = document.getElementById("nombre").value.trim();
    const codigo    = document.getElementById("codigo").value.trim();
    const provincia = document.getElementById("provincia").value;
    const canton    = document.getElementById("canton").value;
    const nivel     = document.getElementById("nivel").value;
    const direccion = document.getElementById("direccion").value.trim();
    const telefono  = document.getElementById("telefono").value.trim();
    const correo    = document.getElementById("correo").value.trim();

    
    if (nombre.length === 0) {
        e.preventDefault(); 
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

    if (provincia.length === 0) {
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

    if (canton.length === 0) {
        Swal.fire({
            icon: 'error',
            title: 'Datos faltantes',
            text: 'Debe ingresar un canton válido.',
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

    if (correo.length === 0) {
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