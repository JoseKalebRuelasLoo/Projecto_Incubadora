window.addEventListener("load", function () {
    let obj_datos = document.getElementById('contenedor');

    let tr = document.createElement("tr");
    let td = document.createElement("td");
    let select = document.createElement('select');

    fetch("comboBox.php", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        }
    })
        .then(respuesta => {
            return respuesta.json();
        })
        .then(datos => {
            var i = 0;
            for (fila of Object.entries(datos)) {
                let option = document.createElement('option');
                let txtnode = document.createTextNode(`${datos[i].Nombre}`);
                option.value = `${datos[i].Nombre}`;
                option.appendChild(txtnode);
                select.appendChild(option);
                i++;
            }
        })
        .catch(error => {
            console.log(error);
        })
    select.setAttribute("id", "empresa");
    td.appendChild(select);
    tr.appendChild(td);

    td = document.createElement("td");
    input = document.createElement('input');
    input.setAttribute("id", "fechaFin");
    input.placeholder = "Año-Mes-Dia";
    td.appendChild(input);
    tr.appendChild(td);

    td = document.createElement("td");
    input = document.createElement('input');
    input.setAttribute("id", "monto");
    td.appendChild(input);
    tr.appendChild(td);

    td = document.createElement("td");
    input = document.createElement('input');
    input.setAttribute("id", "quincena");
    td.appendChild(input);
    tr.appendChild(td);

    td = document.createElement("td");
    input = document.createElement('input');
    input.setAttribute("id", "pagoquincena");
    td.appendChild(input);
    tr.appendChild(td);

    td = document.createElement("td");
    input = document.createElement('input');
    input.setAttribute("id", "intereses");
    td.appendChild(input);
    tr.appendChild(td);

    td = document.createElement("td");
    input = document.createElement('input');
    input.setAttribute("id", "pagototal");
    td.appendChild(input);
    tr.appendChild(td);

    td = document.createElement("td");
    input = document.createElement('input');
    input.setAttribute("id", "nombre");
    td.appendChild(input);
    tr.appendChild(td);

    td = document.createElement("td");
    input = document.createElement('input');
    input.setAttribute("id", "apellido");
    td.appendChild(input);
    tr.appendChild(td);

    obj_datos.appendChild(tr);

    let msg = document.getElementById('msg');
    let msg_titulo = document.getElementById('msg_titulo');
    let msg_cuerpo = document.getElementById('msg_cuerpo');
    let btn_mensaje = document.getElementById('msg_cerrar');
    btn_mensaje.addEventListener("click", function () {
        document.getElementById('msg').close();
    });

    var botonAñadir = document.getElementById("añadir");

    botonAñadir.addEventListener("click", function () {
        var empresa = document.getElementById("empresa").value;
        var fechaFin = document.getElementById("fechaFin").value;
        var monto = document.getElementById("monto").value;
        var quincena = document.getElementById("quincena").value;
        var pagoquincena = document.getElementById("pagoquincena").value;
        var intereses = document.getElementById("intereses").value;
        var pagototal = document.getElementById("pagototal").value;
        var nombre = document.getElementById("nombre").value;
        var apellido = document.getElementById("apellido").value;
        let url = "añadirVale.php";

        if (fechaFin != "" && monto != "" && quincena != "" && pagoquincena != "" && intereses != "" && pagototal != "" && nombre != "" && apellido != "") {
            datos = {
                Tipo: empresa,
                FechaFin: fechaFin,
                MontoSol: monto,
                NumQuin: quincena,
                PagoQuin: pagoquincena,
                Inter: intereses,
                PagoTot: pagototal,
                Nombre: nombre,
                Apellido: apellido
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

    }, true);

}, true);

function limpiar() {
    document.getElementById("fechaFin").value= "";
    document.getElementById("monto").value= "";
    document.getElementById("quincena").value= "";
    document.getElementById("pagoquincena").value= "";
    document.getElementById("intereses").value= "";
    document.getElementById("pagototal").value= "";
    document.getElementById("nombre").value= "";
    document.getElementById("apellido").value= "";
}