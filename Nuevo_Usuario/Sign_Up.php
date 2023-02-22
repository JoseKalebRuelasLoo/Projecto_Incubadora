<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro de usuario</title>
    <link rel="stylesheet" href="Style/Style.css">
    <script src="Registro/Crear_cliente.js"></script>

</head>

<body>
    <div class="contenedor-formularios">
        <div id="registrarse">
            <h1>Registrarse</h1>
            <form action="#" method="post" id="formulario">
                <div class="fila-arriba">
                    <div class="contenedor-input">
                        <label id="label_nombre">
                            Nombre<span class="req">*</span>
                        </label>
                        <input type="text" id="nombre" required>
                    </div>

                    <div class="contenedor-input">
                        <label id="label_apellido">
                            Apellido<span class="req">*</span>
                        </label>
                        <input type="text" id="apellido" required>
                    </div>
                </div>
                <div class="contenedor-input">
                    <label id="label_correo">
                        Correo<span class="req">*</span>
                    </label>
                    <input type="email" id="correo" required>
                </div>

                <div class="contenedor-input">
                    <label id="label_telefono">
                        Telefono<span class="req">*</span>
                    </label>
                    <input type="text" id="telefono" required>
                </div>

                <div class="contenedor-input">
                    <label id="label_domicilio">
                        Ciudad<span class="req">*</span>
                    </label>
                    <input type="text" id="domicilio" required>
                </div>

                <div class="contenedor-input">
                    <label id="label_ocupacion">
                        Ocupacion<span class="req">*</span>
                    </label>
                    <input type="text" id="ocupacion" required>
                </div>


                <div class="contenedor-input">
                    <label id="label_genero">
                        Seleccione su genero<span class="req">*</span>
                    </label>
                    <select id="genero" required>
                        <option disabled selected value=""></option>
                        <option value="Hombre">Hombre</option>
                        <option value="Mujer">Mujer</option>
                        <option value="Otro">Otro</option>
                        <option value="Prefiero no decirlo">Prefiero No Decirlo</option>
                    </select>
                    <input type="text" id="otro" disabled style="visibility: hidden;" placeholder="Escriba su genero">
                </div>

                <div class="contenedor-input">
                    <label id="label_contraseña1">
                        Contraseña <span class="req">*</span>
                    </label>
                    <input type="password" id="contraseña1" required>
                </div>

                <div class="contenedor-input">
                    <label id="label_contraseña2">
                        Repetir Contraseña <span class="req">*</span>
                    </label>
                    <input type="password" id="contraseña2" required>
                </div>
                <label id="msg"></label>
                <button id="bregistrarse" class="button button-block" type="button">Registrarse</button>
            </form>
        </div>
    </div>
</body>

</html>