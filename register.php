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
  
  $nameTitle = "Registro";
  include("./funciones/login_functions.php");
  include("./include/header.php");

?>
<div class="col-md-12">
  <div class="panel panel-default col-md-4 col-md-offset-4">
    <div class="panel-body">
      <h4>Registro de usuario</h4>
      <div class="row" style="padding: 15px; padding-bottom: 0px;">
        <?php
        if (count($errors) > 0){
          for ($i = 0; $i < sizeOf($errors); $i++)
            echo "<div class='alert alert-danger' role='alert'>$errors[$i]</div>";
        }
        if (isset($_SESSION['msg'])){
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
            <input type="text" class="form-control" id="username" name="username" placeholder="Introduce un username" value="<?php echo $username;?>">
          </div>
          <div class="form-group <?php if ($emailErr) echo 'has-error';?>">
            <label for="correo">Correo</label>
            <input type="text" class="form-control" id="email" name="email" placeholder="Introduce un correo electrónico" value="<?php echo $email;?>">
          </div>
          <div class="form-group <?php if ($passErr) echo 'has-error';?>">
            <label for="correo">Contraseña</label>
            <input type="password" class="form-control" id="password" name="password_1" placeholder="Introduce una contraseña">
          </div>
          <div class="form-group <?php if ($passErr) echo 'has-error';?>">
            <label for="contra">Confirmar contraseña</label>
            <input type="password" class="form-control" id="password_2" name="password_2" placeholder="Introduce una contraseña">
          </div>
          <button type="submit" class="btn btn-success pull-right" name="reg_user">Registrarse</button>
        </form>
        <?php
        echo "<br><p>¿Ya eres miembro?<br><a href='login_completo.php?redirect=" . (isset($_GET['redirect']) ? urlencode($_GET['redirect']) : "/index.php") . "'>Acceso usuari@s</a></p>";
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
