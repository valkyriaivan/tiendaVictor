<?php
session_start();
// $connect = new PDO('mysql:host=localhost;dbname=mi_primera_web;charset=utf8', 'root', 'sa');
// require './include/ElCaminas/Carrito.php';
// require './include/ElCaminas/Producto.php';
// require './include/ElCaminas/Productos.php';
// use ElCaminas\Carrito;
// use ElCaminas\Productos;
// use ElCaminas\Producto;
// $carrito = new Carrito();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Shop Homepage - Start Bootstrap Template</title>

    <!-- Bootstrap Core CSS -->
    <!-- <link href="/css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="/css/bootstrap.css" rel="stylesheet">


    <!-- Custom CSS -->
    <link href="/css/shop-homepage.css" rel="stylesheet">
	  <link href="/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type='text/css'>
      /* CSS used here will be applied after bootstrap.css */
      .menu-ico-collapse {
          margin-left: 4px;
      }

      .list-group-submenu .list-group-item:first-child {
           border-top-right-radius: 0;
           border-top-left-radius: 0;
      }

      .list-group-submenu .list-group-item:last-child {
           margin-bottom: -1px;
           border-bottom-right-radius: 0;
           border-bottom-left-radius: 0;
      }

      .panel-default > .panel-heading {
        color: #ffffff;
        background-color: #ff6100;
      }
      .panel-default > .panel-body {
        background-color: #f5f5f5;
      }

      .list-group-item.active{
        border-color: #ed5a00;
        background-color: #ff6100;
      }
      .list-group-item.active:hover{
        background-color: #ff6100;
        border-color: #ed5a00;
      }
      .producto{
        margin-top: 0px;
        padding-left: 18px;
      }
      .tituloProduc{
        font-size: 18px;
        font-family: inherit;
        font-weight: 500;
        line-height: 1.1;
        color: inherit;
      }
      #total {
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 20%;
        align: center;
        text-align:center;
        vertical-align:middle;
        float: right;
        border-collapse: separate;
        border-radius:6px;
        -moz-border-radius:6px;
      }

      #total td{
        border: 1px solid #ddd;
        padding: 8px;
        border-collapse: separate;
        border-radius:6px;
        -moz-border-radius:6px;
      }

      #algo {
        background-color: #ff6100;
        color: white;
        font-weight: bold;
      }

      .numeroCirculo {
        background: red;
        border-radius: 0.8em;
        -moz-border-radius: 0.8em;
        -webkit-border-radius: 0.8em;
        color: #ffffff;
        display: inline-block;
        font-weight: bold;
        line-height: 1.6em;
        margin-right: 5px;
        text-align: center;
        width: 1.6em;
      }

    </style>
</head>

<body>

  <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="/index/">La tienda de Ivan</a>
          </div>
          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav">
                  <li>
                      <a href="/index/">Inicio</a>
                  </li>
                  <li>
                      <a href="/producto/">Productos</a>
                  </li>
              </ul>
              <?php
              if (isset($_SESSION['username'])){?>
                <ul class="nav navbar-nav navbar-right">
                  <li><a><?php echo $_SESSION['username'];?></a></li>
                  <li><a href='/logout.php?redirect=<?php echo  urlencode($_SERVER['REQUEST_URI'])?>'><span class="glyphicon glyphicon-log-out"></span> Cerrar sesión</a></li>
                  <li><a href="/carro.php?redirect=<?php echo urlencode($_SERVER['REQUEST_URI']);?>">Carrito <span class="fa fa-shopping-cart fa-lg fa-fw"></span> <sup><span class="numeroCirculo"><?php echo $carrito->howMany();?></span><sup></a></li>
                </ul>
              <?php
              }
              else{?>
                <ul class="nav navbar-nav navbar-right">
                  <li><a href='/register.php?redirect=<?php echo urlencode($_SERVER['REQUEST_URI'])?>'><span class="glyphicon glyphicon-user"></span> Registrate</a></li>
                  <li><a href='/login_completo.php?redirect=<?php echo  urlencode($_SERVER['REQUEST_URI'])?>'><span class="glyphicon glyphicon-log-in"></span> Iniciar sesión</a></li>
                  <li><a href="/carro.php?redirect=<?php echo urlencode($_SERVER['REQUEST_URI']);?>">Carrito <span class="fa fa-shopping-cart fa-lg fa-fw"></span> <sup><span class="numeroCirculo"><?php echo $carrito->howMany();?></span><sup></a></li>
                </ul>
              <?php
              }
              ?>
          </div>
      </div>
  </nav>
  <div class="container">
      <div class="row">
        <?php
        if ($conMenu==true){?>
          <div class="col-md-3">
              <!-- <p class="lead">La tienda de Ivan</p> -->
                <div class="list-group">
                  <a class="list-group-item text-center active" data-remote="true" href="#" id="categoria_0">
                    <b>Todas las Categorías</b>
                  </a>
                  <?php
                    $query = "SELECT * FROM categorias WHERE id_padre IS NULL";
                    $statement = $connect->prepare($query);
                    $statement->execute();
                    $count = $statement->rowCount();

                    if($count > 0){
                      $result = $statement->fetchAll();
                      foreach($result as $row){
                        $query = "SELECT * FROM categorias WHERE id_padre = " . $row['id'];
                        $statementPadre = $connect->prepare($query);
                        $statementPadre->execute();
                        $countPadre = $statementPadre->rowCount();

                        if ($countPadre > 0){?>
                          <a class="list-group-item" data-remote="true" href="#sub_<?php echo $row["id"];?>" id="<?php echo $row["id"];?>" data-toggle="collapse" data-parent="#sub_<?php echo $row["id"];?>" style="padding-left: 25px;">
                            <span class="fa <?php echo $row["icon"] ?> fa-lg fa-fw"></span>
                            <span><?php echo $row["nombre"] ?> </span>
                            <span class="menu-ico-collapse"><i class="fa fa-chevron-down"></i></span>
                          </a>

                          <div class="collapse list-group-submenu" id="sub_<?php echo $row["id"];?>">
                            <?php
                              $resultPadre = $statementPadre->fetchAll();
                              foreach($resultPadre as $row){?>
                                <a href="/categoria/<?php echo str_replace(' ', '-', $row["nombre"]) . "/" . $row["id"];?>" class="list-group-item sub-item" data-parent="#sub_<?php echo $row["id_padre"];?>" style="padding-left: 50px;">
                                  <span class="fa <?php echo $row["icon"] ?> fa-lg fa-fw"></span>
                                  <span><?php echo $row["nombre"] ?> </span>
                                </a>
                              <?php
                              }
                            ?>
                          </div>
                        <?php
                        }
                        else{?>
                          <a class="list-group-item" data-remote="true" href="/categoria/<?php echo str_replace(' ', '-', $row["nombre"]) . "/" . $row["id"];?>" id="<?php echo $row["id"];?>" style="padding-left: 25px;">
                            <span class="fa <?php echo $row["icon"] ?> fa-lg fa-fw"></span>
                            <span><?php echo $row["nombre"] ?> </span>
                          </a>
                        <?php
                        }
                      }
                    }
                    ?>
                </div>
          </div>
        <?php
        }
        ?>
