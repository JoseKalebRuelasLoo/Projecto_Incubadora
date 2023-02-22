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
        let txtnode = document.createTextNode(`${datos[i].Tipo}`);
        td.appendChild(txtnode);
        tr.appendChild(td);

        td = document.createElement("td");
        txtnode = document.createTextNode(`${datos[i].FechaIn}`);
        td.appendChild(txtnode);
        tr.appendChild(td);

        td = document.createElement("td");
        txtnode = document.createTextNode(`${datos[i].FechaFin}`);
        td.appendChild(txtnode);
        tr.appendChild(td);

        td = document.createElement("td");
        txtnode = document.createTextNode(`${datos[i].NumQuin}`);
        td.appendChild(txtnode);
        tr.appendChild(td);

        td = document.createElement("td");
        txtnode = document.createTextNode(`${datos[i].PagoQuin}`);
        td.appendChild(txtnode);
        tr.appendChild(td);

        td = document.createElement("td");
        txtnode = document.createTextNode(`${datos[i].Inter}`);
        td.appendChild(txtnode);
        tr.appendChild(td);

        td = document.createElement("td");
        txtnode = document.createTextNode(`${datos[i].PagoTot}`);
        td.appendChild(txtnode);
        tr.appendChild(td);

        obj_datos.appendChild(tr);
        i++;
    }

}