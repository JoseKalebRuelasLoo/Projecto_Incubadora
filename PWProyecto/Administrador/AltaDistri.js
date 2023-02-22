window.addEventListener("load", function () {
    let obj_datos = document.getElementById('contenedor');
    let url = "consultaDistri.php";
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        }
    })
        .then(respuesta => {
            return respuesta.json();
        })
        .then(datos => {
            tablaclientes(datos, obj_datos)
        })
        .catch(error => {
            console.log(error);
        })
}, true);

function tablaclientes(datos, obj_datos) {
    var e = 0;
    for (fila of Object.entries(datos)) {
        var i = `${datos[e].Usu}`;
        let tr = document.createElement("tr");
        let td = document.createElement("td");
        let input = document.createElement('input');
        input.value = (`${datos[e].Usu}`);
        input.disabled = "true";
        input.setAttribute("id", "u" + i);
        td.appendChild(input);
        tr.appendChild(td);

        td = document.createElement("td");
        boton = document.createElement("button");
        boton.setAttribute("id", i);
        boton.type = 'button';
        boton.innerText = 'Activar';
        td.appendChild(boton);
        tr.appendChild(td);

        boton.addEventListener("click", () => {
            boton = document.getElementById(event.target.id);
            let id = boton.id;
            activar(id);
        });
        obj_datos.appendChild(tr);
        e++;
    }

}

function activar(id) {
    let url = "activarDistri.php";
    datos = {
        Usu: id,
    }
    console.log(datos);
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
            window.location = "Altacliente.php";
        })
        .catch(error => {
            console.log(error);
        })
}

