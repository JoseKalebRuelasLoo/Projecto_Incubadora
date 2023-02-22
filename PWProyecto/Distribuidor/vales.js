window.addEventListener("load", function () {
    let obj_datos = document.getElementById('contenedor');
    let urlVales = "consultaVales.php";
    fetch(urlVales, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        }
    })
        .then(respuesta => {
            return respuesta.json();
        })
        .then(datos => {
            tablaVales(datos, obj_datos)
        })
        .catch(error => {
            console.log(error);
        })
}, true);

function tablaVales(datos, obj_datos) {
    var e = 0;
    for (fila of Object.entries(datos)) {
        var i = `${datos[e].IdV}`;
        let tr = document.createElement("tr");
        let td = document.createElement("td");
        let input = document.createElement('input');
        input.value = (`${datos[e].Tipo}`);
        input.disabled = "true";
        input.setAttribute("id", "a" + i);
        td.appendChild(input);
        tr.appendChild(td);

        td = document.createElement("td");
        input = document.createElement('input');
        input.value = (`${datos[e].FechaIn}`);
        input.disabled = "true";
        input.setAttribute("id", "b" + i);
        td.appendChild(input);
        tr.appendChild(td);

        td = document.createElement("td");
        input = document.createElement('input');
        input.value = (`${datos[e].FechaFin}`);
        input.disabled = "true";
        input.setAttribute("id", "c" + i);
        td.appendChild(input);
        tr.appendChild(td);

        td = document.createElement("td");
        input = document.createElement('input');
        input.value = (`${datos[e].MontoSol}`);
        input.disabled = "true";
        input.setAttribute("id", "d" + i);
        td.appendChild(input);
        tr.appendChild(td);

        td = document.createElement("td");
        input = document.createElement('input');
        input.value = (`${datos[e].NumQuin}`);
        input.disabled = "true";
        input.setAttribute("id", "e" + i);
        td.appendChild(input);
        tr.appendChild(td);

        td = document.createElement("td");
        input = document.createElement('input');
        input.value = (`${datos[e].PagoQuin}`);
        input.disabled = "true";
        input.setAttribute("id", "f" + i);
        td.appendChild(input);
        tr.appendChild(td);

        td = document.createElement("td");
        input = document.createElement('input');
        input.value = (`${datos[e].Inter}`);
        input.disabled = "true";
        input.setAttribute("id", "g" + i);
        td.appendChild(input);
        tr.appendChild(td);

        td = document.createElement("td");
        input = document.createElement('input');
        input.value = (`${datos[e].PagoTot}`);
        input.disabled = "true";
        input.setAttribute("id", "h" + i);
        td.appendChild(input);
        tr.appendChild(td);

        td = document.createElement("td");
        input = document.createElement('input');
        input.value = (`${datos[e].Nombres}`);
        input.disabled = "true";
        input.setAttribute("id", "i" + i);
        td.appendChild(input);
        tr.appendChild(td);

        td = document.createElement("td");
        boton = document.createElement("button");
        boton.setAttribute("id", "bo" + i);
        boton.type = 'button';
        boton.innerText = 'Modificar';
        td.appendChild(boton);
        tr.appendChild(td);

        boton.addEventListener("click", () => {
            botonP = document.getElementById(event.target.id);
            id = botonP.id.charAt(2);
            if (botonP.innerText == 'Guardar') {
                botonP.innerText = 'Modificar';
                desabilitar(id);
                guardar(id);
            } else if (botonP.innerText == 'Modificar') {
                botonP.innerText = 'Guardar';
                habilitar(id);
            }

        });

        td = document.createElement("td");
        boton2 = document.createElement("button");
        boton2.setAttribute("id", "b1" + i);
        boton2.type = 'button';
        boton2.innerText = 'Liberar';
        td.appendChild(boton2);
        tr.appendChild(td);

        boton2.addEventListener("click", () => {
            botonP2 = document.getElementById(event.target.id);
            id = botonP2.id.charAt(2);
            liberar(id);
        });
        obj_datos.appendChild(tr);
        e++;
    }

}

function habilitar(id) {
    document.getElementById('f' + id).disabled = false;
    document.getElementById('g' + id).disabled = false;
    document.getElementById('h' + id).disabled = false;
}

function desabilitar(id) {
    document.getElementById('f' + id).disabled = true;
    document.getElementById('g' + id).disabled = true;
    document.getElementById('h' + id).disabled = true;
}

function guardar(id) {
    let PagoQuin = document.getElementById('f' + id).value;
    let Inter = document.getElementById('g' + id).value;
    let PagoTot = document.getElementById('h' + id).value;
    let url = "modificar.php";
    if (PagoQuin != "" && Inter != "" && PagoTot != "") {
        datos1 = {
            IdV: id,
            PagoQuin: PagoQuin,
            Inter: Inter,
            PagoTot: PagoTot,
        }
        fetch(url, {
            method: 'POST',
            body: JSON.stringify(datos1),
            headers: {
                'Content-Type': 'application/json'
            }
        })
            .then(respuesta => {
                console.log();
                return respuesta.json();
            })
            .then(datos => {
                window.location = "ReporteVales.php";
            })
            .catch(error => {
                console.log(error);
            })
    } else {
        let boton = document.getElementById("bo"+id);
        boton.innerText = 'Guardar';
        habilitar(id);
        let msg = document.getElementById('msg');
        let msg_titulo = document.getElementById('msg_titulo');
        let msg_cuerpo = document.getElementById('msg_cuerpo');
        let btn_mensaje = document.getElementById('msg_cerrar');
        btn_mensaje.addEventListener("click", function () {
            document.getElementById('msg').close()
        });
        msg_cuerpo.innerHTML = "Llene los campos, porfavor";
        msg_titulo.innerHTML = 'Error';
        msg.showModal();
    }

}

function liberar(id) {
    let url = "liberar.php";
    datos1 = {
        IdV: id,
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
            window.location = "ReporteVales.php";
        })
        .catch(error => {
            console.log(error);
        })
}

