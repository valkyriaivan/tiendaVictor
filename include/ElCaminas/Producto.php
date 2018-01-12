<?php

namespace ElCaminas;
use \PDO;
class Producto
{
    protected $connect;
    protected $id;
    protected $nombre;
    protected $descripcion;
    protected $id_categoria;
    protected $precio;
    protected $precioReal;
    protected $foto;
    protected $destacado;
    protected $descuento;
    protected $stock;
    protected $fecha;
    protected $carrusel;
    protected $url;
    public function __construct($params)
    {
        global $connect;
        $this->connect = $connect;
        if (is_array($params)){
          	foreach ($params as $key=>$param){
      				$this->$key = $param;
      			}
        }else{
          //sólo se pasa el id;
          $query = "SELECT * FROM productos WHERE id = :id";
          $statement = $this->connect->prepare($query);
          $statement->bindParam(':id', $params, PDO::PARAM_INT);
          $statement->execute();
          $producto = $statement->fetch(PDO::FETCH_ASSOC);
          foreach ($producto as $key=>$param){
            $this->$key = $param;
          }
        }
        $this->setPrecioReal();
        $this->setUrl();
    }

    public function getId(){
      return $this->id;
    }
    public function getIdCategoria(){
      return $this->id_categoria;
    }
    public function setUrl(){
      $this->url =  "/producto.php?id=" . $this->getId();
    }
    public function getUrl(){
      return $this->url;
    }
    public function setPrecioReal(){
      if ( $this->descuento > 0){
        $precioReal = $this->precio - ($this->precio * $this->descuento / 100);
      }else{
        $precioReal =  $this->precio;
      }
      $this->precioReal = $precioReal;
    }
    public function getPrecioReal(){
      return   $this->precioReal;
    }
    public function getNombre(){
      return   $this->nombre;
    }
    public function getHtmlPrecio(){
      $precioTexto = "";
      if ( $this->precio != $this->precioReal){
        $precioTexto = "<span class='text text-danger'><s>" . number_format($this->precio, 2, ',', ' ') . " €</s></span> <span class='text text-success'>" . number_format($this->precioReal , 2, ',', ' ') . "€</span>";
      }else{
        $precioTexto =  "<span class='text text-danger'>" .number_format($this->precio, 2, ',', ' ') . " €</span>";
      }
      return $precioTexto;
    }

    public function getHtml(){

      $str = "<div class='panel panel-default'>";
        $str .= "<div class='panel-body'>";
          $str .= "<div class='row'>";
      $str .= "<p class='h1 producto'><b>" . $this->nombre . "</b></p>";
      $str .= "<div class='col-md-4'>";
        $str .= "<img src='/basededatos/img/256_" . $this->foto . "' alt='' style='padding-top: 9px'>";
      $str .= "</div>";
      $str .= "<div class='col-md-8'>";
        $str .= "<p class='tituloProduc' style='margin-top: 15px;'>Precio: <span style='color:green;'>";
            if ($this->descuento > 0){
              $precio = $this->precio - (($this->precio*$this->descuento)/100);
              $str .= "<strike style='color:red;'>" . $this->precio . "€</strike><sup style='color:red;'>-" . $this->descuento . "%</sup>  " . $precio . "€";
            }
            else{
              $str .=  $this->precio . "€";
            }
        $str .= "</span></p>";
        $str .= "<p class='tituloProduc'>Descripción:</p>";
        $str .= "<p>" . $this->descripcion . "</p>";
        $str .= "<a href='/carro.php?action=add&id=" . $this->id . "&redirect=" . urlencode(str_replace("state=exclusive","state=normal",$_SERVER['REQUEST_URI'])) . "' class='btn btn-success pull-right'>Comprar</a>";
      $str .= "</div>";
          $str .= "</div>";
        $str .= "</div>";
      $str .= "</div>";
      return $str;
    }
    public function getHtmlPopup(){

      $str = "<p class='h1 producto'><b>" . $this->nombre . "</b></p>";
      $str .= "<div class='col-md-4'>";
        $str .= "<img src='/basededatos/img/256_" . $this->foto . "' alt='' style='display:block; margin:auto; height: 400px; margin-bottom: 50px;'>";
      $str .= "</div>";
      $str .= "<div class='col-md-8'>";
        // $str .= "<p class='tituloProduc' style='margin-top: 15px;'>Precio: <span style='color:green;'>";
        //     if ($this->descuento > 0){
        //       $precio = $this->precio - (($this->precio*$this->descuento)/100);
        //       $str .= "<strike style='color:red;'>" . $this->precio . "€</strike><sup style='color:red;'>-" . $this->descuento . "%</sup>  " . $precio . "€";
        //     }
        //     else{
        //       $str .=  $this->precio . "€";
        //     }
        // $str .= "</span></p>";
        // $str .= "<p class='tituloProduc'>Descripción:</p>";
        $str .= "<p style='font-size:large;'>" . $this->descripcion . "</p>";
      $str .= "</div>";
      return $str;
    }

    public function getThumbnailHtml(){
      $str = "<div class='col-sm-4 col-lg-4 col-md-4'>";
          $str .= "<div class='thumbnail'>";
              $str .= "<a href='" . $this->url . "'><img src='/basededatos/img/" . $this->foto . "' alt='' style='padding-top: 9px'></a>";
              $str .= "<div class='caption'>";
                  $str .= "<h4><a href='" . $this->url . "'>" . $this->nombre . " <a class='open-modal' href='" . $this->url . "'><span class='fa fa-external-link'></span></a></a></h4>";

                  $str .= "<p>" . $this->descripcion . "</p>";
              $str .= "</div>";
              $str .= "<div style='padding: 9px'>";
                $str .= "<a href='/carro.php?action=add&id=" . $this->id . "&redirect=" . urlencode($_SERVER['REQUEST_URI']) . "' class='btn btn-success pull-right'>Comprar</a>";
                  if ($this->descuento > 0){
                    $precioFinal = $this->precio - (($this->precio*$this->descuento)/100);
                    $str .= "<h4 style='color:green;'><strike style='color:red;'>" . $this->precio . "€</strike><sup style='color:red;'>-" . $this->descuento . "%</sup>  " . $precioFinal . "€</h4>";
                  }
                  else{
                    $str .= "<h4>" . $this->precio . "€</h4>";
                  }
              $str .= "</div>";
          $str .= "</div>";
      $str .= "</div>";
      return $str;
    }
}
