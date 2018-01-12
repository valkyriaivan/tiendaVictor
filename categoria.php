<?php
if (!isset($_GET["id_cat"])){
  header("location: /index/");
}

require './include/JasonGrimes/Paginator.php';

$connect = new PDO('mysql:host=localhost;dbname=mi_primera_web;charset=utf8', 'root', 'sa');
require './include/ElCaminas/Carrito.php';
require './include/ElCaminas/Producto.php';
require './include/ElCaminas/Productos.php';
use ElCaminas\Carrito;
use ElCaminas\Productos;
use ElCaminas\Producto;
$productos = new Productos();
$carrito = new Carrito();

$conMenu = true;
include "./include/header.php";


use JasonGrimes\Paginator;

$query = "SELECT * FROM productos WHERE id_categoria = :idCat";
$statement = $connect->prepare($query);
$statement->bindParam(':idCat', $_GET["id_cat"], PDO::PARAM_INT);
$statement->execute();
$cuenta = $statement->rowCount();
$totalItems = $cuenta;

//En principio este parámetro no estaría en producción. Lo usamos para ir probando el paginador con distintos tamaños
// $itemsPerPage = 3;
$itemsPerPage = (isset($_GET["itemsPerPage"]) ? $_GET["itemsPerPage"] : 3);

$currentPage = (isset($_GET["currentPage"]) ? $_GET["currentPage"] : 1);
// $urlPattern = "/categoria/" . "(:num)/" . $itemsPerPage . "/" . $_GET["id_cat"];
$urlPattern = "/categoria.php?id_cat=" . $_GET["id_cat"] . "&itemsPerPage=$itemsPerPage&currentPage=(:num)";
$paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);

?>

            <div class="col-md-9">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <?php
                  $query = " SELECT * FROM categorias WHERE id = :idCat";
                  $statement = $connect->prepare($query);
                  $statement->bindParam(':idCat', $_GET["id_cat"], PDO::PARAM_INT);
                  $statement->execute();
                  $count = $statement->rowCount();
                  if($count > 0){
                    $result = $statement->fetchAll();
                    foreach($result as $row) {
                      echo "<h3 class='panel-title'><b>" . $row["nombre"] . "</b></h3>";
                    }
                  }?>
                </div>
                <div class="panel-body">
                  <div class="row">
                    <?php
                      foreach($productos->getProductosByCategoria($_GET["id_cat"], $itemsPerPage, $currentPage) as $producto){
                         echo $producto->getThumbnailHtml();
                      }
                  // echo $paginator;
                  ?>
                  </div>
                  <div style="position:relative; float:right;">
                  <?php
                  include './include/JasonGrimes/examples/pager.phtml';
                  ?>
                  </div>
                </div>
            </div>
          </div>
  </div>
    <!-- /.container -->

<?php
include("./include/modalDomProducto.phtml");
$bottomScripts = array();
$bottomScripts[] = "modalDomProducto.js";
include "./include/footer.php";
?>
