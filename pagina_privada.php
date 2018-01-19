<?php
  $nameTitle = "Pagina privada";
  $tituloEj = "Pagina privada";
  $descEj = "Esta web será solo visible si estás logeado.";
  include("funciones/login_functions.php");

  if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "Para acceder a esta página, debes iniciar sesión primero";
    header('location: login_completo.php?redirect=pagina_privada.php');
  }
  include("../php/header.php");
  include("../php/headerEj.php");
  ?>

  <h1>Pagina privada</h1>
  <p>Esta web solo será visible si estamos registrados, si no, nos hará  un redirect a la web de login.</p>

  <?php
  include("../php/footerEj.php");
  include("../php/footer.php");
?>
