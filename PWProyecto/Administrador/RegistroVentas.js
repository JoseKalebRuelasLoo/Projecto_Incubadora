window.addEventListener("load", function () {
    let obj_datos = document.getElementById('contenedor');
    let url = "ConsultasVentas.php";
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
            tabla(datos, obj_datos)
        })
        .catch(error => {
            console.log(error);
        })
}, true);

function tabla(datos, obj_datos) {
    var e = 0;
    for (fila of Object.entries(datos)) {
        var i = `${datos[e].IdVE}`;

        let tr = document.createElement("tr");

        let td = document.createElement("td");
        let txtnode = document.createTextNode(`${datos[e].Nombre}`);
        td.appendChild(txtnode);
        tr.appendChild(td);

        td = document.createElement("td");
        txtnode = document.createTextNode(`${datos[e].Usu}`);
        td.appendChild(txtnode);
        tr.appendChild(td);

        td = document.createElement("td");
        txtnode = document.createTextNode(`${datos[e].Pago}`);
        td.appendChild(txtnode);
        tr.appendChild(td);

        td = document.createElement("td");
        boton = document.createElement("button");
        boton.setAttribute("id", i);
        boton.type = 'button';
        boton.innerText = 'Pagado';
        td.appendChild(boton);
        tr.appendChild(td);

        boton.addEventListener("click", () => {
            boton = document.getElementById(event.target.id);
            var id = boton.id;
            activar(id);
        });
        obj_datos.appendChild(tr);
        e++;
    }

}

function activar(IdVE) {
    let url = "Ventapagada.php";
    datos = {
        a: IdVE,
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
            window.location = "RegistroVentas.php";
        })
        .catch(error => {
            console.log(error);
        })
}

