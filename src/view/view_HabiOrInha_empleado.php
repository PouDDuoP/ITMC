<?php
session_start();
require_once '../inc/auth.php';
require_auth();
require_perfil([4, 3]);
    if($_POST){
       //echo "recibo algo POST";
       $id = '';
       //recibo los datos y los decodifico con PHP
       $misDatosJSON = json_decode($_POST["consulta"]);
       $cedula = $_POST["cedula"];
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <?php include_once 'inc/head.php'; ?>
  </head>
  <body>
    <header id="header">
      <?php include_once 'inc/header.php'; ?>
      <script type="text/javascript">
      function enviar(input){
        var form = input;
        if (form.cedula.value.length === 0 || form == '') {
          return false;
        } else if (input.cedula.value.length === 0 || input.status.value.length === 0) {
          alert('algun campo esta vacio');
          return (false);
        } else {
          var form = input.cedula;
            console.log(form.value);
            document.datos.method = "post";
            document.datos.action = "../controller/con_HabiOrInha_empleado.php";
            document.datos.submit();
        }
      }
      window.load = function(){

        document.datos.cedula.disabled = true;
        document.datos.nombre.disabled = true;
        document.datos.apellido.disabled = true;
      }
      </script>
    </header>
    <?php
      include_once 'inc/nav.php';
      ?>
      <section>
        <?php
        if(!empty($_POST['consulta']) && $cedula == $misDatosJSON->{'id'}) {
        ?>
        <form class="form" name="datos"autocomplete="off">
          <div class="empleado"><h2>Modificar de Empleado</h2></div>
            <input type="hidden" name="cedula" value="<?php echo $misDatosJSON->{'id'}; ?>">
              <div class="empleado">
                  Nro de Cedula<input type="text" readonly="readonly" required autocomplete="off" onkeypress="return justLetters(event);"  id="cedulan" name="cedulan" title="Se Necesita la cedula del empleado" value="<?php echo $misDatosJSON->{'id'};?>" required />
              </div>
              <!-- Verificar y hacer la relacion entre cargo y departamento -->
              <div class="empleado">
                  Nombres del empleado<input type="text" required autocomplete="off" onkeypress="return justLetters(event);"  id="nombre" name="nombre" value="<?php echo $misDatosJSON->{'nombre'};?>" readonly="readonly"  required />
              </div>
              <div class="empleado">
                  Apellidos del empleado<input type="text" required autocomplete="off" onkeypress="return justLetters(event);"  id="apellido" name="apellido" value="<?php echo $misDatosJSON->{'apellido'};?>" readonly="readonly"  required />
              </div>
              <div class="empleado">
                  Fecha de ingreso<input type="text" required autocomplete="off" onkeypress="return justLetters(event);"  id="fecha_ingreso" name="fecha_ingreso" value="<?php $fecha = date_create($misDatosJSON->{'fecha_ingreso'}); echo date_format($fecha,'Y-m-d'); ?>" readonly="readonly"  required />
              </div>

                <div class="empleado">
                  <select name="status">
                    <option value="<?php echo $misDatosJSON->{'status'};?>">Status:</option>
                    <option value="f">inhabilitar</option>
                    <option value="t">Habilitar</option>
                  </select>
                </div>

            <button type="button" class="button button-block" onclick="javascript: enviar(document.datos);"/>Modificar</button>
        </form>
        <?php
        } else {
        ?>
          <script type="text/javascript">
            alert('error al consultar el usuario');
            window.history.back();
          </script>
        <?php
        }
        ?>
      </section>
    <?php
      }else {
        header('location: view_menu.php');
      }
    ?>
  <?php include_once 'inc/script-lib.php'; ?>
  </body>
</html>
<?php

