function tabla(datos, contenedor) {
    for (fila of datos) {
        let tr = document.createElement("tr");
        let td = document.createElement("td");
        let txt_node = document.createTextNode('${fila.Usu}');
        td.appendChild(txt_node);
        tr.appendChild(td);

        td = document.createElement("td");
        //////
        td.appendChild(txt_node);
        tr.appendChild(td);

        contenedor.appendChild(tr);
    }
}

window.addEventListener("load", function () {
    let h2 = document.getElementById('h2');
    let tipo;
    if (h2.classList == "clientes") {
        tipo = 1;
    }
    if (h2.classList == "administradores") {
        tipo = 3;
    }
    if (h2.classList == "distribuidor") {
        tipo = 2;
    }
    let obj_datos = document.getElementById('contenedor');

    datos = {
        tipo: tipo
    }
    console.log(datos);
    fetch("Alta/Consulta.php", {
        method: 'POST',
        //body: JSON.stringify(datos),
        headers: {
            'Content-Type': 'application/json'
        }
    })
        .then(respuesta => {
            console.log(respuesta);
            return respuesta.json();
        })
        .then(datos => {
            tabla(datos, obj_datos)
        })
        .catch(error => {
            console.log(error);
        });

}, true);