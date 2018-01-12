<?php
  $title = "Plantas el Caminàs -> ";
  $connect = new PDO('mysql:host=localhost;dbname=mi_primera_web;charset=utf8', 'root', 'sa');
  require './include/ElCaminas/Carrito.php';
  require './include/ElCaminas/Producto.php';
  require './include/ElCaminas/Productos.php';
  use ElCaminas\Carrito;
  use ElCaminas\Productos;
  use ElCaminas\Producto;
  $productos = new Productos();
  $carrito = new Carrito();
  $conMenu=true;
  include("./include/header.php");

  if (isset($_GET["action"])){
    if ($_GET["action"] == "empty"){
      $carrito->empty();
    }
    if ($_GET["action"] == "delete"){
      $carrito->deleteItem($_GET["id"]);
    }
    if ($_GET["action"] == "add"){
      if (isset($_GET["id"])){
        $carrito->addItem($_GET["id"], 1);
      }
    }
  }
?>

      <div class="col-md-9">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title"><b>Carrito de la compra </b></h3>
          </div>
          <div class="panel-body">
            <?php  echo $carrito->toHtmlConObjetos();?>
          </div>
          <div style="clear: both;"></div>
        </div>
    </div>
  </div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Detalle del producto</h4>
      </div>
      <div class="modal-body">
        <iframe src='#' width="100%" height="600px" frameborder=0 style='padding:8px'></iframe>
      </div>
    </div>
  </div>
</div>
<?php
include("./include/footer.php");
?>
