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
        <li><a href='misVales.php'>Mis Vales</a></li> 
            <!--SELECT Tipo, FechaIn, FechaFin, NumQuin, PagoQuin, Inter, PagoTot from Vales where IdC = IdC-->
            <li><a href='ContactarDistri.php'>Contactar Distribuidores</a></li>
            <!--SELECT Nombre, Tel, Dom from Distribuidores-->
            <li><a href='sesion.php'>Cerrar Sesion</a></li>
        </ul>
    </nav>
    </div>
</body>

</html>