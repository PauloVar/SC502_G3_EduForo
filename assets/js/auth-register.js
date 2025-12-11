document.getElementById("frmRegister").addEventListener("submit", async function (e) {

    e.preventDefault();

    const nombre = document.getElementById("nombre").value.trim();
    const email = document.getElementById("email").value.trim();
    const usuario = document.getElementById("usuario").value.trim();
    const contrasenna = document.getElementById("contrasenna").value.trim();
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
            toast.addEventListener("mouseenter", Swal.stopTimer);
            toast.addEventListener("mouseleave", Swal.resumeTimer);
        }
    });

    if (!nombre || !email || !usuario || !contrasenna || !confirmar || !fechaNac || !genero) {
        Toast.fire({
            icon: "warning",
            title: "Debe completar todos los campos."
        });
        return;
    }

    if (contrasenna !== confirmar) {
        Toast.fire({
            icon: "error",
            title: "Las contraseñas no coinciden."
        });
        return;
    }

    const datos = new FormData();
    datos.append("nombre", nombre);
    datos.append("correo", email);
    datos.append("usuario", usuario);
    datos.append("contrasenna", contrasenna);
    datos.append("confirmar", confirmar);
    datos.append("fecha_nacimiento", fechaNac);
    datos.append("genero", genero);

    try {
        const response = await fetch("php/registro/registro.php", {
            method: "POST",
            body: datos
        });

        const result = (await response.text()).trim();
        console.log("Respuesta registro:", result);

        if (result === "ok" || result.includes("ok")) {
            Toast.fire({
                icon: "success",
                title: "Usuario registrado con éxito"
            });

            setTimeout(() => {
                window.location.href = "login.php";
            }, 2000);

        } else if (result.startsWith("error:")) {
            Toast.fire({
                icon: "error",
                title: result.replace("error:", "").trim()
            });

        } else {
            Toast.fire({
                icon: "error",
                title: "Ocurrió un error inesperado al registrar el usuario."
            });
        }

    } catch (error) {
        console.error(error);

        Toast.fire({
            icon: "error",
            title: "Error de conexión con el servidor."
        });
    }
});
