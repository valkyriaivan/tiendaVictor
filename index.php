    <?php
    $conMenu = true;
    $connect = new PDO('mysql:host=localhost;dbname=mi_primera_web;charset=utf8', 'root', 'sa');
    require './include/ElCaminas/Carrito.php';
    require './include/ElCaminas/Producto.php';
    require './include/ElCaminas/Productos.php';
    use ElCaminas\Carrito;
    use ElCaminas\Productos;
    use ElCaminas\Producto;
    $productos = new Productos();
    $carrito = new Carrito();
    include "./include/header.php";
    ?>
            <div class="col-md-9">

                <div class="row carousel-holder">

                    <div class="col-md-12">
                        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                                <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                                <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                            </ol>
                            <div class="carousel-inner">
                                <?php
                                	$query = " SELECT * FROM productos WHERE carrusel IS NOT NULL LIMIT 3";
                                	$statement = $connect->prepare($query);
                                	$statement->execute();
                                	$count = $statement->rowCount();

                                	if($count > 0){
                                		$result = $statement->fetchAll();
                                    $primero = 1;
                                		foreach($result as $row){
                                      ?>
                                      <div class='item <?php if ($primero == 1){echo "active"; $primero = 0;}?>'>
                                        <a href='/basededatos/img/<?php echo $row["carrusel"]?>'><img class='slide-image' src='/basededatos/img/<?php echo $row["carrusel"];?>'></a>
                                  		</div>
                                      <?php
                                		}
                                	}
                                ?>
                            </div>
                            <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left"></span>
                            </a>
                            <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right"></span>
                            </a>
                        </div>
                    </div>

                </div>
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h3 class="panel-title"><b>Destacados </b><small><b style="color: #f2f2f2;">Lo más destacado</b></small></h3>
                  </div>
                  <div class="panel-body">
                    <div class="row">
                      <?php
                        foreach($productos->getDestacados() as $producto){
                           echo $producto->getThumbnailHtml();
                        }
                        ?>
                    </div>
                  </div>
                </div>

                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h3 class="panel-title"><b>Novedades </b><small><b style="color: #f2f2f2;">Lo más nuevo en nuestra tienda</b></small></h3>
                  </div>
                  <div class="panel-body">
                    <div class="row">
                      <?php
                      foreach($productos->getNovedades() as $producto){
                         echo $producto->getThumbnailHtml();
                      }
                      ?>
                    </div>
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
