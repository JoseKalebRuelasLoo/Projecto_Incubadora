<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro De Distribuidores</title>
    <link rel="stylesheet" href="Style.css">
    <script src="Crear_Dis.js"></script>

</head>

<body>
    <div class="container">
        <section>
            <form class="contact_form" action="" method="post" name="contact_form">
                <ul>
                    <li>
                        <h2>Registro de Distribuidor</h2>
                        <span class="required_notification">* Campos Obligatorios</span>
                    </li>
                    <li>
                        <label for="nombre">Nombres:</label>
                        <input class="registro" type="text" name="nombre" id="nombre" required />
                    </li>
                    <li>
                        <label for="apellido">Apellidos:</label>
                        <input class="registro" type="text" name="apellido" id="apellido" required />
                    </li>
                    <li>
                        <label for="telefono">Telefono:</label>
                        <input class="registro" type="text" name="telefono" id="telefono" required />
                    </li>
                    <li>
                        <label for="domicilio">Ciudad:</label>
                        <input class="registro" type="text" name="domicilio" id="domicilio" required />
                    </li>
                    <li>
                        <label for="Correo">Correo:</label>
                        <input class="registro" type="text" name="Correo" id="correo" required />
                    </li>
                    <li>
                        <label for="contraseña1">Contraseña:</label>
                        <input class="registro" type="password" name="contraseña1" id="contraseña1" required />
                    </li>
                    <li>
                        <label for="contraseña2">Escribe Nuevamente Tu Contraseña:</label>
                        <input class="registro" type="password" name="contraseña2" id="contraseña2" required />
                    </li>
                    <li>
                        <button id="registrarse" class="submit" type="button">Registrarse</button>
                    </li>
                </ul>
            </form>
        </section>
        <footer>
            <dialog id="msg">
                <h2 id="msg_titulo">Titulo</h2>
                <p id="msg_cuerpo"></p>
                <button id="msg_cerrar">Cerrar</button>
            </dialog>
        </footer>
    </div>
</body>

</html>