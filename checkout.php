<?php
$connect = new PDO('mysql:host=localhost;dbname=mi_primera_web;charset=utf8', 'root', 'sa');
require './include/ElCaminas/Carrito.php';
require './include/ElCaminas/Producto.php';
require './include/ElCaminas/Productos.php';
use ElCaminas\Carrito;
use ElCaminas\Productos;
$productos = new Productos();
$carrito = new Carrito();

  $nameTitle = "Checkout";
  include("./funciones/login_functions.php");
  include("./include/header.php");

?>
<div class="col-md-12">
  <div class="panel panel-default col-md-4 col-md-offset-4">
    <div class="panel-body">
      <h4>Proceso de pago</h4>
      <div class="row" style="padding: 15px; padding-bottom: 0px;">
        <?php
        if (isset($_GET["redirect"])){
          $redirect =  htmlspecialchars($_SERVER['PHP_SELF']) . "?redirect=" . $_GET["redirect"];
        }
        else{
          $redirect = htmlspecialchars($_SERVER['PHP_SELF']);
        }
        if(isset($_SESSION['username'])){
          echo "El total de tu compra es: <br>";
          echo $carrito->getTotal();
          include("./include/paypal.php");
        }
        else{
          echo "<p>Necesitas estar registrado para realizar el proceso de pago.</p>";
          echo "<a href='login_completo.php?redirect=" . $_SERVER['REQUEST_URI'] . "'>Inciar sesión</a>";
        }
        ?>

      </div>
    </div>
  </div>
</div>
</div>
</div>
  <?php
include("./include/footer.php");
?>
