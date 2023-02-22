<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../Style.css">
</head>

<body>
  <div class="container">
    <header class="hijos">
      <h1 id='titulo'>Página Principal</h1>
    </header>
    <?php
    session_start();
    require_once('../seguridad.php');
    sanitizar($_SESSION);
    if (isset($_SESSION['auntentificado']) && $_SESSION['auntentificado'] == "Muy_bien") {
      $tipo_id = $_SESSION['tipo_id'];
      $tipoPag = 2;
      if (!Seguridad_Tipo($tipo_id, $tipoPag)) {
        $home = $_SESSION['url'];
        header("Location: ../$home/Inicio.php");
      }
    } else {
      header("Location: ../Inicio_de_sesion.html");
    }
    ?>
    <?php
    require_once('menu.php');
    ?>
    <section class="hijos">
      <h2>Bienvenido</h2>

      <p>
        Como distribuidor tiene acceso a nuevas funciones, por lo que se le recomiendar echarles un vistazo,
        por lo que tan solo debe dirigirse a la barra de navegación.
      </p>
      <img class="ImgInC" src="../media/dist.gif">
    </section>
    <footer class="hijos">
      <h4 id="FootFin">ITCHII / Grupo A / ISC / 5to Semestre / Programación Web</h4>
    </footer>
  </div>
</body>

</html>