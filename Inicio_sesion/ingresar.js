window.addEventListener("load", function () {
    var boton_ingresar = document.getElementById('ingresar');
    boton_ingresar.addEventListener("click", () => {
        let usuario = document.getElementById("usuario").value;
        let pass = document.getElementById("password").value;
        let url = "Inicio_sesion/logueo.php";
        datos1 = {
            usuario: usuario,
            pass: pass
        }
        fetch(url, {
            method: 'POST',
            body: JSON.stringify(datos1),
            headers: {
                'Content-Type': 'application/json'
            }
        })
            .then(respuesta => {
                return respuesta.json();
            })
            .then(datos => {
                var error = datos.error;
                if (error == 2) {
                    msg_contra.innerHTML = 'La contraseña que ingresaste es incorrecta.';
                    con_contraseña.style.boxShadow = "0 0 0.1em red"; 
                }
                if (error == 3) {
                    msg_correo.innerHTML = 'El correo electrónico que se ingreso no está conectado a una cuenta.';
                    con_correo.style.boxShadow = "0 0 0.1em red"; 
                }
                if (error == 4) {
                    msg_contra.innerHTML = 'Porfavor rellene los campos';
                    con_contraseña.style.boxShadow = "0 0 0.1em red"; 
                    con_correo.style.boxShadow = "0 0 0.1em red"; 
                }
                if (error == 100) {
                    msg_contra.innerHTML = 'Error de conexion';
                }
                if (error == 0) {
                    let url = datos.url;
                    window.location = "../huevos/Usuarios/" + url + "/algo.html";
                }

            })
            .catch(error => {
                console.log(error);
            });
    });

    var boton_Nuevo = document.getElementById('crear');
    boton_Nuevo.addEventListener("click", () => {
        window.location = "Nuevo_Usuario/Sign_Up.php";
    });

    var boton_recuperar = document.getElementById('recuperar');
    boton_recuperar.addEventListener("click", () => {
        window.location = "Nuevo_Usuario/Sign_Up.php";
    });

    let correo = document.getElementById("usuario");
    let con_correo = document.getElementById("con_correo");
    correo.addEventListener("click", () => {
        msg_correo.innerHTML = '';
        con_correo.style.boxShadow = "0 0 2em #e6e9f9"; 
    });

    let contraseña = document.getElementById("password");
    let con_contraseña = document.getElementById("con_contraseña");
    contraseña.addEventListener("click", () => {
        msg_contra.innerHTML = '';
        con_contraseña.style.boxShadow = "0 0 2em #e6e9f9"; 

    });

    let msg_correo = document.getElementById('msg_correo');
    let msg_contra = document.getElementById('msg_contra');

}, true)