window.addEventListener("load", function () {

    //Campos (Individuales)
    let r_nombre = document.getElementById('nombre');
    let r_apellido = document.getElementById('apellido');
    let r_telefono = document.getElementById('telefono');
    let r_domicilio = document.getElementById('domicilio');
    let r_ocupacion = document.getElementById('ocupacion');
    let r_genero = document.getElementById('genero');
    let r_correo = document.getElementById('correo');
    let r_contraseña1 = document.getElementById('contraseña1');
    let r_contraseña2 = document.getElementById('contraseña2');

    //Divs
    let divCorreo = r_correo.parentNode;
    let divDomicilio = r_domicilio.parentNode;
    let divGenero = r_genero.parentNode;
    let divOcupacion = r_ocupacion.parentNode;
    let divTelefono = r_telefono.parentNode;
    let divApellido = r_apellido.parentNode;
    let divNombre = r_nombre.parentNode;
    let divContra1 = r_contraseña1.parentNode;
    let divContra2 = r_contraseña2.parentNode;

    //Boton
    let botonR = document.getElementById('bregistrarse');

    //Campos (Conjunto)
    let inputs = document.getElementById('registrarse');


    //Reinicia el formulario
    //document.getElementById("formulario").reset();

    // Se comprueba si los datos ingresados en los inputs estan vacios
    function validarDatos() {
        document.getElementById("msg").innerHTML = '';
        let nombre = r_nombre.value.trim();
        let apellido = r_apellido.value.trim();
        let telefono = r_telefono.value.trim();
        let domicilio = r_domicilio.value.trim();
        let ocupacion = r_ocupacion.value.trim();
        let genero = r_genero.value.trim();
        if (genero == "Otro") {
            genero = document.getElementById('otro').value.trim();
        }
        let correo = r_correo.value.trim();

        let error = 0;

        if (nombre == "") {
            error = 1;
            divNombre.style.boxShadow = "0 0 0.1em red";
        }
        if (apellido == "") {
            error = 1;
            divApellido.style.boxShadow = "0 0 0.1em red";
        }
        if (telefono == "") {
            error = 1;
            divTelefono.style.boxShadow = "0 0 0.1em red";
        }
        if (domicilio == "") {
            error = 1;
            divDomicilio.style.boxShadow = "0 0 0.1em red";
        }
        if (ocupacion == "") {
            error = 1;
            divOcupacion.style.boxShadow = "0 0 0.1em red";
        }
        if (genero == "") {
            divGenero.style.boxShadow = "0 0 0.1em red";
        }
        if (correo == "") {
            error = 1;
            divCorreo.style.boxShadow = "0 0 0.1em red";
        }
        if (validarContraseña() != "True") {
            error = 1;
            divContra2.style.boxShadow = "0 0 0.1em red";
            divContra1.style.boxShadow = "0 0 0.1em red";
        }
        return error;
    }

    //Funcion que valida si las contraseñas se escribieron correctamente 
    function validarContraseña() {
        let contraseña1 = r_contraseña1.value.trim();
        let contraseña2 = r_contraseña2.value.trim();
        var espacios = false;
        var cont = 0;
        var validacion = "True";

        while (!espacios && (cont < contraseña1.length)) {
            if (contraseña1.charAt(cont) == " ")
                espacios = true;
            cont++;
        }

        if (espacios) {
            validacion = "false1";
        } else if (contraseña1.length == 0 || contraseña2.length == 0) {
            validacion = "false2";
        } else if (contraseña1 != contraseña2) {
            validacion = "false3";
        } else {
            validacion = "True";
        }
        return validacion;
    }

    //Evento que comprueba si las contraseñas se escribieron correctamente
    r_contraseña1.addEventListener("keyup", function (e) {
        divContra2.style.boxShadow = "0 0 2em #e6e9f9";
        divContra1.style.boxShadow = "0 0 2em #e6e9f9";
        if (validarContraseña() == "false3") {
            divContra2.style.boxShadow = "0 0 0.1em red";
        }else if (validarContraseña() == "false1"){
            divContra1.style.boxShadow = "0 0 0.1em red";
            divContra2.style.boxShadow = "0 0 0.1em red";
        }
    });

    r_contraseña2.addEventListener("keyup", function (e) {
        divContra2.style.boxShadow = "0 0 2em #e6e9f9";
        divContra1.style.boxShadow = "0 0 2em #e6e9f9";
        if (validarContraseña() == "false3") {
            divContra2.style.boxShadow = "0 0 0.1em red";
        }else if (validarContraseña() == "false1"){
            divContra1.style.boxShadow = "0 0 0.1em red";
            divContra2.style.boxShadow = "0 0 0.1em red";
        }
    });

    //Evento, al pulsar el boton de "registrarse" se toman los datos, se crea un JSON con ellos 
    //y se envia a php para procesarlos
    botonR.addEventListener("click", function () {
        let errorCte = validarDatos();
        if (errorCte == 0) {
            let nombre = r_nombre.value.trim();
            let apellido = r_apellido.value.trim();
            let telefono = r_telefono.value.trim();
            let domicilio = r_domicilio.value.trim();
            let ocupacion = r_ocupacion.value.trim();
            let genero = r_genero.value.trim();
            if (genero == "Otro") {
                genero = document.getElementById('otro').value.trim();
            }
            let correo = r_correo.value.trim();
            let contraseña1 = r_contraseña1.value.trim();

            datos = {
                nombre: nombre,
                apellido: apellido,
                telefono: telefono,
                domicilio: domicilio,
                ocupacion: ocupacion,
                genero: genero,
                correo: correo,
                pass: contraseña1
            }

            console.log(datos);
            fetch("Registro/nuevo.php", {
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
                    console.log(datos);
                    var error = datos.error;
                    if (error == 2) {
                        document.getElementById("msg").innerHTML = 'Error en la transferencia de los datos';
                    } else if (error == 3) {
                        document.getElementById("msg").innerHTML = 'Error en las sentencias sql';
                    } else if (error == 4) {
                        let divCorreo = r_correo.parentNode;
                        divCorreo.style.boxShadow = "0 0 0.1em red";
                        document.getElementById("msg").innerHTML = 'Ya se encuentra en uso el correo';
                    } else if (error == 0) {
                        window.location = "../Login.html";
                    }
                })
                .catch(error => {
                    console.log(error);
                });
        }
    });


    //Evento pulsar tecla (al levantar) para cambiar la clase de los labels
    inputs.addEventListener("keyup", function (e) {
        let id = e.target.getAttribute("id");
        let valor = document.getElementById(id).value;
        let div = e.target.parentNode;
        let label = document.getElementById('label_' + id);
        if (valor == "") {
            label.classList.remove("active");
        } else {
            label.classList.add("active");
            div.style.boxShadow = "0 0 2em #e6e9f9";
        }
    });

    //Evento desenfocar para cambiar la clase de los labels
    inputs.addEventListener("blur", function (e) {
        let id = e.target.getAttribute("id");
        let valor = document.getElementById(id).value;
        let label = document.getElementById('label_' + id);
        if (valor == "") {
            label.classList.remove("active");
        }
    });


    inputs.addEventListener("load", function (e) {
        let id = e.target.getAttribute("id");
        let valor = document.getElementById(id).value;
        let label = document.getElementById('label_' + id);
        if (valor == "") {
            label.classList.remove("active");
        } else {
            label.classList.add("active");
        }
    });

    //Evento para el selection (al seleccionar "Otro" aparece un input)
    r_genero.addEventListener("click", function (e) {
        let genero = r_genero.options[r_genero.selectedIndex].value;
        let otro = document.getElementById('otro');
        document.getElementById("label_genero").style.visibility = "visible";
        if (genero != "") {
            r_genero.parentNode.style.boxShadow = "0 0 2em #e6e9f9";
            document.getElementById("label_genero").classList.add("active");
        } else {
            document.getElementById("label_genero").classList.remove("active");
        }
        if (genero == "Otro") {
            otro.style.visibility = "visible";
            otro.disabled = false;
            document.getElementById("label_genero").style.visibility = "hidden";
        } else {
            otro.style.visibility = "hidden";
            otro.disabled = true;
            otro.value = "";
        }
    });

}, true);