window.addEventListener("load", function () {
    let obj_datos = document.getElementById('contenedor');
    let tr = document.createElement("tr");

    let td = document.createElement("td");
    input = document.createElement('input');
    input.setAttribute("id", "Nombre");
    td.appendChild(input);
    tr.appendChild(td);

    td = document.createElement("td");
    input = document.createElement('input');
    input.setAttribute("id", "Apellido");
    td.appendChild(input);
    tr.appendChild(td);

    td = document.createElement("td");
    input = document.createElement('input');
    input.setAttribute("id", "Correo");
    td.appendChild(input);
    tr.appendChild(td);

    td = document.createElement("td");
    input = document.createElement('input');
    input.setAttribute("id", "Contraseña");
    td.appendChild(input);
    tr.appendChild(td);

    td = document.createElement("td");
    boton1 = document.createElement("button");
    boton1.type = 'button';
    boton1.innerText = 'Añadir';
    td.appendChild(boton1);
    tr.appendChild(td);

    boton1.addEventListener("click", () => {
        let Nombre = document.getElementById("Nombre").value;
        let Apellido = document.getElementById("Apellido").value;
        let Correo = document.getElementById("Correo").value;
        let Contraseña = document.getElementById("Contraseña").value;
        if (Nombre != "" && Apellido != "" && Correo != "" && Contraseña != "") {
            let url = "AñadirAdmin.php";
            datos = {
                Nombre: Nombre,
                Apellido: Apellido,
                Correo: Correo,
                Pass: Contraseña
            }
            fetch(url, {
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
                    limpiar();
                })
                .catch(error => {
                    console.log(error);
                })
        } else {
            msg_cuerpo.innerHTML = "Llene todos los campos, porfavor uwu";
            msg_titulo.innerHTML = 'Error';
            msg.showModal();
        }
    });

    let msg = document.getElementById('msg');
    let msg_titulo = document.getElementById('msg_titulo');
    let msg_cuerpo = document.getElementById('msg_cuerpo');
    let btn_mensaje = document.getElementById('msg_cerrar');
    btn_mensaje.addEventListener("click", function () {
        document.getElementById('msg').close()
    });
    obj_datos.appendChild(tr);
}, true);

function limpiar() {
    document.getElementById("Nombre").value = "";
    document.getElementById("Apellido").value = "";
    document.getElementById("Correo").value = "";
    document.getElementById("Contraseña").value = "";
}
