window.addEventListener("load", function () {
    let obj_datos = document.getElementById('contenedor');
    let urlVales = "consultaDistribuidores.php";
    fetch(urlVales, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        }
    })
        .then(respuesta => {
            return respuesta.json();
        })
        .then(datos1 => {
            tablaVales(datos1, obj_datos)
        })
        .catch(error => {
            console.log(error);
        })
}, true);

function tablaVales(datos, obj_datos) {
    var i = 0;
    for (fila of Object.entries(datos)) {
        let tr = document.createElement("tr");
        let td = document.createElement("td");
        let txtnode = document.createTextNode(`${datos[i].Nombre}`);
        td.appendChild(txtnode);
        tr.appendChild(td);

        td = document.createElement("td");
        txtnode = document.createTextNode(`${datos[i].Tel}`);
        td.appendChild(txtnode);
        tr.appendChild(td);

        td = document.createElement("td");
        txtnode = document.createTextNode(`${datos[i].Dom}`);
        td.appendChild(txtnode);
        tr.appendChild(td);

        obj_datos.appendChild(tr);
        i++;
    }

}