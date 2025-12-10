document.getElementById("frmRegister").addEventListener("submit", async function (e) {

    e.preventDefault();

        const nombre = document.getElementById("nombre_Completo").value.trim();
        const email = document.getElementById("email").value.trim();
        const usuario = document.getElementById("usuario").value.trim();
        const contrasena = document.getElementById("contrasena").value.trim();
        const confirmar = document.getElementById("confirm_contrasena").value.trim();
        const fechaNac = document.getElementById("fechaNac").value;
        const genero = document.querySelector('input[name="genero"]:checked')?.value;

        const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        background: "#fff",
        color: "#000",
        didOpen: (toast) => {
            toast.addEventListener("mouseenter", Swal.stopTimer)
            toast.addEventListener("mouseleave", Swal.resumeTimer)
        }
    });

    if (!nombre || !email || !usuario || !contrasena || !confirmar || !fechaNac || !genero) {

        Toast.fire({
            icon: "warning",
            title: "Debe completar todos los campos."
        })

        return;
    }

    if (contrasena !== confirmar) {
        Toast.fire({
            icon: "error",
            title: "Las contraseñas no coinciden."
        })

        return;
    }

    const datos = new FormData();

    datos.append("nombre_Completo", nombre);
    datos.append("email", email);
    datos.append("usuario", usuario);
    datos.append("contrasena", contrasena);
    datos.append("confirm_contrasena", confirmar);
    datos.append("fechaNac", fechaNac);
    datos.append("genero", genero);


    try {

        //Intenta todo lo que hay dentro del try

        const response = await fetch("php/registro/registro.php", {
            method: "POST",
            body: datos
        })

        const result = await response.text();

        if (result.includes("ok")) {
            Toast.fire({
                icon: "success",
                title: "Usuario registrado con éxito"
            })

            setTimeout(() => {
                 window.location.href="login.php"
            }, 4000)

           

        } else if (result.includes("error:")) {
            Toast.fire({
                icon: "error",
                title: result.replace("error:", "").trim()

            })
        }else{
            Toast.fire({
                icon: "error",
                title: "Ocurrió un error inesperado al registrar un usuario."

            })
        }



    } catch (error) {

        //Si algo del try falla de forma inesperada o controlada, entonces cae aca.
        console.log(error)

        Toast.fire({
            icon: "error",
            title: "Error de conexión con el servidor. ".error
        })


    }

})



        /*
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
});*/