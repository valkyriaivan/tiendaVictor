<?php
  if (isset($_SESSION['username'])){
    header("location: index.php");
  }
  $connect = new PDO('mysql:host=localhost;dbname=mi_primera_web;charset=utf8', 'root', 'sa');
  require './include/ElCaminas/Carrito.php';
  require './include/ElCaminas/Producto.php';
  require './include/ElCaminas/Productos.php';
  use ElCaminas\Carrito;
  use ElCaminas\Productos;
  use ElCaminas\Producto;
  $productos = new Productos();
  $carrito = new Carrito();
  
  $nameTitle = "Login completo";
  include("./funciones/login_functions.php");
  include("./include/header.php");

  ?>
  <div class="col-md-12">
    <div class="panel panel-default col-md-4 col-md-offset-4">
      <div class="panel-body">
        <h4>Inicio de sesión</h4>
        <div class="row" style="padding: 15px; padding-bottom: 0px;">
          <?php
            if (count($errors) > 0){
              //Mostrar todos los mensajes de error
              for ($i = 0; $i < sizeOf($errors); $i++)
                echo "<div class='alert alert-danger' role='alert'>$errors[$i]</div>";
            }
            if (isset($_SESSION['msg'])){
              //Mostrar todos los mensajes de error
              echo "<div class='alert alert-danger' role='alert'>$_SESSION[msg]</div>";
              unset($_SESSION['msg']);
            }

            if (isset($_GET["redirect"])){
              $redirect =  htmlspecialchars($_SERVER['PHP_SELF']) . "?redirect=" . $_GET["redirect"];
            }
            else{
              $redirect = htmlspecialchars($_SERVER['PHP_SELF']);
            }
            ?>
              <form action="<?php echo $redirect;?>" method="post">
                <div class="form-group <?php if ($nombreErr) echo 'has-error';?>">
                  <label for="correo">Nombre de usuari@</label>
                  <input type="text" class="form-control" id="username" name="username" placeholder="Introduce tu usuario" value="<?php echo $username;?>">
                </div>
                <div class="form-group <?php if ($passErr) echo 'has-error';?>">
                  <label for="contra">Contraseña</label>
                  <input type="password" class="form-control" id="password" name="password" placeholder="Introduce tu contraseña">
                </div>
                <button type="submit" class="btn btn-success pull-right" name="login_user">Acceder</button>
              </form>
              <?php
              echo "<br><p>¿Todavía no eres miembro? <a href='register.php?redirect=" . (isset($_GET['redirect']) ? urlencode($_GET['redirect']) : "/index.php") ."'>Registrate</a></p>";
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
