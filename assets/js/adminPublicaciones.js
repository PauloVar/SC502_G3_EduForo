document.getElementById("contactForm").addEventListener('submit', function (e) {
    e.preventDefault();

    const titulo = document.getElementById("titulo").value.trim();
    const mensaje = document.getElementById("mensaje").value.trim();
    const fecha = document.getElementById("fecha").value.trim();
    const colegio = document.getElementById("colegio").value;

    if (titulo.length === 0) {
        Swal.fire({
            icon: 'error',
            title: 'Datos faltantes',
            text: 'Debe ingresar un título válido.',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true
        });
        return;
    }

    if (mensaje.length === 0) {
        Swal.fire({
            icon: 'error',
            title: 'Datos faltantes',
            text: 'Debe ingresar una descripción válida.',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true
        });
        return;
    }

    if (!fecha) {
        Swal.fire({
            icon: 'error',
            title: 'Datos faltantes',
            text: 'Debe seleccionar una fecha.',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true
        });
        return;
    }

    if (!colegio) {
        Swal.fire({
            icon: 'error',
            title: 'Datos faltantes',
            text: 'Debe seleccionar una institución.',
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
        text: 'Publicación subida correctamente.',
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

document.getElementById("mensaje").addEventListener("input", function () {
    const max = 300;
    const actual = this.value.length;
    document.getElementById("contador").textContent = `${actual}/${max}`;
});