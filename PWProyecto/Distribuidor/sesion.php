<?php
session_start();
$_SESSION = array();
session_destroy();
header("Location: ../Inicio_de_sesion.html");