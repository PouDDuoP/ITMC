<?php
  session_start();
  $_SESSION = array();
  session_destroy();
  if (isset($_POST["consulta"]) && !empty($_POST["consulta"])) {
    $misDatosJSON = json_decode($_POST["consulta"]);
  } else {
    $misDatosJSON = '';
  }
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <title>ITMC</title>
    <link rel="stylesheet" href="view/styles/mensajes.css"/>
    <link rel="stylesheet" href="view/css/index.css" type="text/css" media="all" />
    <link rel="stylesheet" href="view/fonts/style.css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
    <link rel="stylesheet" type="text/css" href="styles.css" media="all" />
    <link rel="stylesheet" href="view/css/bootstrap.min.css">
    <script type="text/javascript">
      function restart(){
        var confimr = confirm('esta seguro de cerrar?');
        if (confimr == true) {
          window.location = 'index.php';
        } else {
          return false;
        }

      }

      window.load = function(){

        document.datos.cedula.disabled = true;
      }
    </script>
  </head>
  <body  <?php if (isset($misDatosJSON) && !empty($misDatosJSON)) { ?>class="modal-open" style="padding-right: 17px;"> <?php } else { ?> > <?php }?>
    <header id="header">
      <div class="menunav">
        <div class="logotipo">
          <img src="view/imagenes/logo.png" alt="logotipo chacao"/>
        </div>
        <nav>
          <a href="index.php"><span class="icon-home3"></span>INICIO</a>
          <a href="#" data-toggle="modal" data-target="#iniciar_sesion"><span class="icon-user"></span>INICIAR SESION</a>
        </nav>
      </div>
    </header>
    <div class="slider_container">
      <div class="flexslider">
          <ul class="slides">
          <li>
            <a href="http://www.freshdesignweb.com"><img src="view/imagenes/logoIMU.png" height="500"  width="900" alt="" title=""/></a>
            <div class="flex-caption">
              <div class="caption_title_line"><h1>Chacao&nbsp</h1><p>Chacao nos une</p></div>
            </div>
          </li>
          <!-- <li>
            <a href="http://www.freshdesignweb.com"><img src="view/images/slider/slide2.jpg" alt="" title=""/></a>
            <div class="flex-caption">
              <div class="caption_title_line"><h2>Beautiful Hairstyle</h2><p>The latest hairstyles and instructions on how to create them here. Total Beauty has your complete hairstyles guide</p></div>
            </div>
          </li>
          <li>
            <a href="http://www.freshdesignweb.com"><img src="view/images/slider/slide3.jpg" alt="" title=""/></a>
            <div class="flex-caption">
              <div class="caption_title_line"><h2>Party Dresses</h2><p>If you are looking for something a little special for your big night out, check out Rare London's collection of stunning party dresses</p></div>
            </div>
          </li>
          <li>
            <a href="http://www.freshdesignweb.com"><img src="view/images/slider/slide4.jpg" alt="" title=""/></a>
            <div class="flex-caption">
              <div class="caption_title_line"><h2>Bodycon Dresses</h2><p>The bodycon dress is a key silhouette for this season's party girl; from sleek colour-block panelling to geometric prints the bodycon.</p></div>
            </div>
          </li> -->
        </ul>
      </div>
    </div>
    <?php
      if (isset($misDatosJSON) && !empty($misDatosJSON)) {
    ?>
    <script type="text/javascript">
        alert('Usted posee mas de un perfil, seleccione cual desea utilizar');
    </script>
    <div id="iniciar_sesion" <?php if (isset($misDatosJSON) && !empty($misDatosJSON)) { ?>class="modal fade in" style="display: block;" <?php } else { ?> class="modal fade" style="display: none;"<?php } ?> tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" name="close" onclick="javascript: restart();">×</button>
                    <h2 class="text-center"><img src="view/images/userl.png" class="img-circle"><br>Iniciar Sesión</h2>
                </div>
                <div class="modal-body row">
                    <h6 class="text-center">Seleccione perfil e ingrese la clave del mismo</h6>
                    <form class="col-md-10 col-md-offset-1 col-xs-12 col-xs-offset-0"  name="datos" action="controller/con_autenticar_usuario.php" method="post"  autocomplete="off">
                        <div class="form-group">
                          <select class="form-control" name="perfil" required>
                      <?php
                      $cedula;
                      $i = 0;
                        foreach ($misDatosJSON as $key => $subArry[$i]) {
                          foreach ($subArry[$i] as $keyID => $valueID) {
                          }
                          $cedula = $subArry[$i]->{'cedula_empleado'};
                      ?>
                            <option value="<?php echo $subArry[$i]->{'perfil'};?>"><?php echo $subArry[$i]->{'nombre'};?></option>
                      <?php
                          $i++;
                        }
                      ?>
                          </select>
                        </div>
                        <div class="form-group">
                            <input value="<?php echo $cedula;?>" name="cedula" type="text" class="form-control input-lg" placeholder="Cédula de Identidad" required readonly="readonly" maxlength="8">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control input-lg" name="clave" placeholder="Contraseña">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-info btn-lg btn-block" style="background-color: #555; border-color: #cc720f;">Iniciar Sesión</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php if (isset($misDatosJSON) && !empty($misDatosJSON)) { ?> <div class="modal-backdrop fade in"></div> <?php } else { } ?>
    <?php
      } else {
    ?>
    <div id="iniciar_sesion" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" name="close">×</button>
                    <h2 class="text-center"><img src="view/images/userl.png" class="img-circle"><br>Iniciar Sesión</h2>
                </div>
                <div class="modal-body row">
                    <h6 class="text-center">Suministre sus datos para ingresar</h6>
                    <form class="col-md-10 col-md-offset-1 col-xs-12 col-xs-offset-0" action="controller/con_autenticar_usuario.php" method="post"  autocomplete="off">
                        <div class="form-group">
                            <input type="text" class="form-control input-lg" name="cedula" placeholder="Cédula de Identidad" required onkeypress="return justNumbers(event);" maxlength="8">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control input-lg" name="clave" placeholder="Contraseña">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-info btn-lg btn-block" style="background-color: #555; border-color: #cc720f;">Iniciar Sesión</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
      }
    ?>
    <footer style="text-align:center;">
      <p style="color:black;font-size:12px;text-align:center;margin-top:50px;">Mejorado por:</p>
      <div style="background-color:#F0F0F0;width:250px;text-align: center;margin:0 auto;height:30px;border-radius:5px 5px 5px     5px;margin-top:10px;">
        <img src="view/imagenes/powered.png" style="margin-top:4px;margin-left:4px;width:inherit;"/>
      </div>
    </footer>
    <script type="text/javascript" src="view/js/jquery.js"></script>
    <script type="text/javascript" src="view/js/jquery.flexslider-min.js"></script>
    <script type="text/javascript" src="view/js/sl.js"></script>
    <script type="text/javascript" src="view/js/just_input.js"></script>
    <script type="text/javascript" src="view/js/bootstrap.min.js"></script>
    <script type="text/javascript" charset="utf-8"></script>

  </body>
</html>
