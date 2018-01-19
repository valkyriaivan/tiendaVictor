<?php

namespace ElCaminas;
use \PDO;
use \ElCaminas\Producto;
class Carrito
{
    protected $connect;
    /** Sin parámetros. Sólo crea la variable de sesión
    */
    public function __construct()
    {
        global $connect;
        $this->connect = $connect;
        if (!isset($_SESSION['carrito'])){
            $_SESSION['carrito'] = array();
        }
    }
    public function addItem($id, $cantidad){
      // if (!isempty($id)){
        $_SESSION['carrito'][$id] = $cantidad;
      // }
    }
    public function deleteItem($id){
      unset($_SESSION['carrito'][$id]);
    }
    public function empty(){
      unset($_SESSION['carrito']);
      self::__construct();
    }
    public function getTotal(){
      $total = 0;
      if ($this->howMany() > 0){
        foreach($_SESSION['carrito'] as $key => $cantidad){
          $producto = new Producto($key);
          $subtotal = $producto->getPrecioReal() * $cantidad;
          $total += $subtotal;
        }
      }
      return $total;
    }
    public function howMany(){
      return count($_SESSION['carrito']);
    }
    public function toHtmlConObjetos(){
      $total = 0;
      $str = <<<heredoc
      <table class="table">
        <thead> <tr> <th>#</th> <th>Producto</th> <th>Cantidad</th> <th>Precio</th> <th>Total</th> <th> </th></tr> </thead>
        <tbody>
heredoc;
      if ($this->howMany() > 0){
        $i = 0;
        foreach($_SESSION['carrito'] as $key => $cantidad){
          $producto = new Producto($key);
          $i++;
          $subtotal = $producto->getPrecioReal() * $cantidad;
          $total += $subtotal;
          $subtotalTexto = number_format($subtotal , 2, ',', ' ') ;
          $redirect= "&redirect=" . urlencode($_GET['redirect']);
          $str .=  "<tr><th scope='row'>$i</th><td><a href='" .  $producto->getUrl() . "'>" . $producto->getNombre() . "</a>";
          $str .= "<a class='open-modal' title='Haga clic para ver el detalle del producto' href='" .  $producto->getUrl() . "'>";
          $str .=     "<span style='color:#000' class='fa fa-external-link'></span>";
          $str .= "</a>";
          $str .= "</td><td>$cantidad</td><td>" .  $producto->getPrecioReal() ." €</td><td>$subtotalTexto €</td><td><a href='./carro.php?action=delete&id=" . $producto->getId() . (isset($_GET['redirect']) ?  $redirect : '') . "'><span class='fa fa-times' style='color:red;'></span></td></tr>";
        }
      }
      $str .= <<<heredoc
        </tbody>
      </table>
heredoc;
      $str .= "<table id='total'><tr><td id='algo'>Total</td><td>" . $total . "€</td></tr></table>";
      $str .= <<<heredoc
      <div style="clear: both;"></div>
      <br>
      <a class="btn btn-danger" href='./carro.php?action=empty'>Vaciar carrito</a>
      <form style="float: right;">
heredoc;
      $str .= "<a href='" . (isset($_GET['redirect']) ? urldecode($_GET['redirect']) : "/index.php") . "' class='btn btn-primary'>Seguir comprando</a>";
      $str .= <<<heredoc
        <a href="checkout.php" class="btn btn-default" style="background-color: #ff6100; color: white;">Pagar</a>
      </form>
      <div style="clear: both;"></div>
      <div style="float: right;margin-top: 15px">
        <img src="/basededatos/img/bitcoin.jpg" height="50px">
        <img src="/basededatos/img/paypal.png" height="50px" >
      </div>
heredoc;
      return $str;
    }

    public function toHtml(){

      $str = <<<heredoc
      <table class="table">
        <thead> <tr> <th>#</th> <th>Producto</th> <th>Cantidad</th> <th>Precio</th> <th>Total</th> <th></th> </tr> </thead>
        <tbody>
heredoc;

      $total = 0;
      if ($this->howMany() > 0){
        $i = 0;

        foreach($_SESSION['carrito'] as $key => $cantidad){
          $i++;
          $query = "SELECT * FROM productos WHERE id = $key";
          $statement = $this->connect->prepare($query);
          $statement->execute();
          $producto = $statement->fetch(PDO::FETCH_ASSOC);

          if (is_array($producto)){
            if ( $producto["descuento"] > 0){
              $precioReal = $producto["precio"] - ($producto["precio"] * $producto["descuento"] / 100);
            }else{
              $precioReal =  $producto["precio"];
            }
            $precioTexto = number_format($precioReal , 2, ',', ' ') ;
            $subtotal = $precioReal * $cantidad;
            $total = $total + $subtotal;
            $subtotalTexto = number_format($subtotal , 2, ',', ' ') ;
            $str .=  "<tr><th scope='row'>$i</th><td>" . $producto["nombre"] . "</td><td>$cantidad</td><td>$precioTexto</td><td>$subtotalTexto</td><td><a href='./carro.php?action=delete&id=" . $producto["id"]  . (isset( $_GET["redirect"]) ? "&redirect=" . $_GET["redirect"]: '') . "'><span class='fa fa-times' style='color:red;'></span></td></tr>";
          }
        }
      }

      $str .= <<<heredoc
        </tbody>
      </table>
heredoc;
      $str .= "<table id='total'><tr><td id='algo'>Total</td><td>" . $total . "€</td></tr></table>";
      $str .= <<<heredoc
      <div style="clear: both;"></div>
      <br>
      <a class="btn btn-danger" href='./carro.php?action=empty'>Vaciar carrito</a>
      <form style="float: right;">
heredoc;
      $str .= "<a href='./carro.php?action=redirect" . ((isset($_GET['redirect'])) ?  "&redirect=" . $_GET['redirect'] : " ") . "' class='btn btn-primary'>Seguir comprando</a>";
      $str .= <<<heredoc
        <button type="submit" href="#" class="btn btn-default" style="background-color: #ff6100; color: white;">Pagar</button>
      </form>
      <div style="clear: both;"></div>
      <div style="float: right;margin-top: 15px">
        <img src="/basededatos/img/bitcoin.jpg" height="50px">
        <img src="/basededatos/img/paypal.png" height="50px" >
      </div>
heredoc;
      return $str;
    }
}
