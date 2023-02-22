<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../Style.css">
</head>

<body>
    <div class="container">
        <nav id='menu'>
            <input type='checkbox' id='responsive-menu'><label></label>
            <ul>
                <li><a class='descendente' href=#>Alta de Usuarios</a>
                    <ul class='sub-menus'>
                        <li><a href='AltaCliente.php'>Cliente</a></li>
                        <!--SELECT * FROM Clientes WHERE Activo = 0-->
                        <li><a href='AltaDistri.php'>Distribuidor</a></li>
                        <!--SELECT * FROM Distribuidores WHERE Activo = 0-->
                        <li><a href='AltaAdmin.php'>Administrador</a></li>
                        <!--Aqui va un formulario como tal para agregar Admins-->
                    </ul>
                </li>
                <li><a href='RegistroComp.php'>Registro de Compañias</a></li>
                <!--Formulario para añadir compañias-->
                <li><a href='RegistroVentas.php'>Registro de Ventas</a></li>
                <!--Aqui van 2 cosas, la consulta: SELECT Ventas.IdVE, Distribuidores.Nombre, Usuarios.Usu, Ventas.Pago FROM Ventas INNER JOIN Distribuidores ON Distribuidores.IdD = Ventas.IdD INNER JOIN Usuarios ON Usuarios.Usu = Distribuidores.Correo-->
                <!--Y lo que es el formulario para hacer el update del pago-->
                <li><a href='sesion.php'>Cerrar Sesion</a></li>
            </ul>
        </nav>
    </div>
</body>

</html>