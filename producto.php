<?php
    $conMenu = true;
    $includes = false;
    $connect = new PDO('mysql:host=localhost;dbname=mi_primera_web;charset=utf8', 'root', 'sa');
    require './include/ElCaminas/Carrito.php';
    require './include/ElCaminas/Producto.php';
    require './include/ElCaminas/Productos.php';
    use ElCaminas\Carrito;
    use ElCaminas\Productos;
    use ElCaminas\Producto;
    $productos = new Productos();
    $carrito = new Carrito();

    if (isset($_GET["id"])){
      try {
        $producto = $productos->getProductoById($_GET["id"]);
      }catch(Exception $e){
        http_response_code(404);
        exit();
      }
    }
    $title = "Producto";
    $state = "normal";
    if (isset($_GET["state"])){
      $state = $_GET["state"];
    }
    if ("normal" == $state)
      include("./include/header.php");
    else if("popup" == $state){
      $urlCanonical = $producto->getUrl();
      include("./include/header-popup.php");
    } else if("json" == $state){
      echo $producto->getJson();
      exit();
    }
    // include "./include/header.php";

            if (isset($_GET["id"])){
              if ("exclusive" == $state){
                echo $producto->getHtml();
              }
              else{?>
              <div class="col-md-9">
                  <?php
                  if ("normal" == $state){
                    echo $producto->getHtml();
                  }
                  else{
                    echo $producto->getHtmlPopup();
                  }
                  ?>
                  <?php if ("normal" == $state):?>
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h3 class="panel-title"><b>Productos relacionados </b><small><b style="color: #f2f2f2;">Otros usuarios han visitado estos productos</b></small></h3>
                    </div>
                    <div class="panel-body">
                      <div class="row">
                        <?php
                        foreach($productos->getRelacionados($producto->getId(),  $producto->getIdCategoria()) as $producto){
                           echo $producto->getThumbnailHtml();
                        }
                        ?>
                      </div>
                    </div>
                  </div>
                <?php endif; ?>
              </div>
            <?php
            }
          }
          else{?>
            <div class="col-md-9">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h3 class="panel-title"><b>Todos los productos </b></h3>
                </div>
                <div class="panel-body">
                  <div class="row">
                    <?php
                    foreach($productos->getTodos() as $producto){
                       echo $producto->getThumbnailHtml();
                    }
                    ?>
                  </div>
                </div>
              </div>
            </div>
          <?php }?>
        </div>
    </div>
    <!-- /.container -->

<?php
include("./include/modalDomProducto.phtml");
$bottomScripts = array();
$bottomScripts[] = "modalDomProducto.js";

if ("normal" == $state){
  include("./include/footer.php");
}
else if ("popuip" == $state){
  include("./include/footer-popup.php");
}
?>
