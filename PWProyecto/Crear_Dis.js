window.addEventListener("load", function () {
    let r_nombre = document.getElementById('nombre');
    let r_apellido = document.getElementById('apellido');
    let r_telefono = document.getElementById('telefono');
    let r_domicilio = document.getElementById('domicilio');
    //domicilioarchivo
    let r_correo = document.getElementById('correo');
    let r_contraseña1 = document.getElementById('contraseña1');
    let r_contraseña2 = document.getElementById('contraseña2');

    function validarDatos() {
        let nombre = r_nombre.value.trim();
        let apellido = r_apellido.value.trim();
        let telefono = r_telefono.value.trim();
        let domicilio = r_domicilio.value.trim();
        //domicilioarchivo
        let correo = r_correo.value.trim();
        let contraseña1 = r_contraseña1.value.trim();
        let contraseña2 = r_contraseña2.value.trim();

        let error = 0;
        let mensaje = "<ul>";

        if (nombre == "") {
            error = 1;
            mensaje += "<li>Nombre vacio";
        }
        if (apellido == "") {
            error = 1;
            mensaje += "<li>Apellido vacio";
        }
        if (telefono == "") {
            error = 1;
            mensaje += "<li>Telefono vacio";
        }
        if (domicilio == "") {
            error = 1;
            mensaje += "<li>Domicilio vacio";
        }
        if (correo == "") {
            error = 1;
            mensaje += "<li>Correo vacio";
        }
        if (contraseña1 != contraseña2) {
            error = 1;
            mensaje += "<li>Las contraseñas no concuerdan";
        }
        if (error == 1) {
            mensaje += "</ul>";
            msg_cuerpo.innerHTML = mensaje;
            msg_titulo.innerHTML = 'Error en los datos';
            msg.showModal();
        }
        return error;
    }

    let botonR = document.getElementById('registrarse');
    botonR.addEventListener("click", function () {
        let errorCte = validarDatos();
        if (errorCte == 0) {
            let nombre = r_nombre.value.trim();
            let apellido = r_apellido.value.trim();
            let telefono = r_telefono.value.trim();
            let domicilio = r_domicilio.value.trim();
            let correo = r_correo.value.trim();
            let contraseña1 = r_contraseña1.value.trim();

            //let url = "";

            datos = {
                nombre: nombre,
                apellido: apellido,
                telefono: telefono,
                domicilio: domicilio,
                correo: correo,
                pass: contraseña1
            }

            console.log(datos);
            fetch("nuevoDis.php", {
                method: 'POST',
                body: JSON.stringify(datos),
                headers: {
                    'Content-Type': 'application/json'
                }
            })
                .then(respuesta => {
                    return respuesta.json();
                })
                .then(datos => {
                    var error = datos.error;
                    var mensaje = datos.mensaje;
                    if (error == 1) {
                        msg_cuerpo.innerHTML = mensaje;
                        msg_titulo.innerHTML = 'Error 1';
                        msg.showModal();
                    } else if (error == 2) {
                        msg_cuerpo.innerHTML = mensaje;
                        msg_titulo.innerHTML = 'Error 2';
                        msg.showModal();
                    } else if (error == 3) {
                        msg_cuerpo.innerHTML = mensaje;
                        msg_titulo.innerHTML = 'Error en las sentencias sql';
                        msg.showModal();
                    } else if (error == 4) {
                        msg_cuerpo.innerHTML = mensaje;
                        msg_titulo.innerHTML = 'Ya se encuentra en uso el correo';
                        msg.showModal();
                    } else if (error == 0) {
                        window.location = "Inicio_de_sesion.html";
                    }
                })
                .catch(error => {
                    console.log(error);
                });
        }
    });
    let msg = document.getElementById('msg');
    let msg_titulo = document.getElementById('msg_titulo');
    let msg_cuerpo = document.getElementById('msg_cuerpo');
    let btn_mensaje = document.getElementById('msg_cerrar');
    btn_mensaje.addEventListener("click", function () {
        document.getElementById('msg').close()
    });
}, true);


