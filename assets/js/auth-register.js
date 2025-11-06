document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector("form");

    form.addEventListener("submit", (e) => {
        e.preventDefault(); 

        const nombre = document.getElementById("nombre_Completo").value.trim();
        const email = document.getElementById("email").value.trim();
        const usuario = document.getElementById("usuario").value.trim();
        const contrasena = document.getElementById("contrasena").value.trim();
        const confirmar = document.getElementById("confirm_contrasena").value.trim();
        const fechaNac = document.getElementById("fechaNac").value;
        const genero = document.querySelector('input[name="genero"]:checked');

        
        if (nombre.length < 5 || nombre.length > 50) {
            return Swal.fire({
                icon: 'error',
                title: 'Debe ingresar su nombre completo',
                text: 'Su nombre debe tener entre 5 y 50 carácteres.',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true
            });
        }

        const validarEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!validarEmail.test(email)) {
            return Swal.fire({
                icon: 'error',
                title: 'Su correo es inválido',
                text: 'Por favor ingrese un correo electrónico válido.',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true
            });
        }
        
        /*Basicamente usamos una expresion regular para estar seguro que no hayan espacios en blanco
        como un espacio, tab, etc y lo evaluamos con .test(usuario)*/
        if (usuario.length < 5 || /\s/.test(usuario)) {
            return Swal.fire({
                icon: 'error',
                title: 'Su usuario es inválido',
                text: 'El usuario debe tener al menos 5 carácteres y no contener espacios.',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true
            });
        }

        /*
        Usamos otra expresion regular que se utiliza para validar la contrasena y 
        que tenga al menos 1 caracter, Minus, Mayus, Numeros, Caracteres especiales, minimo 8 catacteres
        */
        const validarContrasena = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;
        if (!validarContrasena.test(contrasena)) {
            return Swal.fire({
                icon: 'error',
                title: 'Debe utilizar una contraseña más segura',
                html: 'Debe tener al menos 8 caracteres, una mayúscula, una minúscula, un número y un caracter especial !@#$%&.',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true
            });
        }

        if (confirmar !== contrasena) {
            return Swal.fire({
                icon: 'error',
                title: 'La contraseña no coincide',
                text: 'Por favor, verifique que ambas contraseñas sean iguales.',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true
            });
        }

        if (!fechaNac) {
            return Swal.fire({
                icon: 'error',
                title: 'La fecha de nacimiento es requerida',
                text: 'Debe ingresar su fecha de nacimiento.',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true
            });
        }

        if (!genero) {
            return Swal.fire({
                icon: 'error',
                title: 'Seleccione un gérnero.',
                text: 'Debe elegir una opción de género.',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true
            });
        }

        
        Swal.fire({
            icon: 'success',
            title: 'El registro es exitoso',
            text: 'Su cuenta ha sido creada correctamente.',
            showConfirmButton: false,
            timer: 2500,
            position: 'center'
        }).then(() => {
            
            window.location.href = "login.html";
        });
    });
});