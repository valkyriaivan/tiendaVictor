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
