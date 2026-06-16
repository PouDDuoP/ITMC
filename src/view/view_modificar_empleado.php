<?php
session_start();
require_once '../inc/auth.php';
require_auth();
require_perfil([4, 2]);
    if($_POST){
       //echo "recibo algo POST";

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
        var form = input.cedula;
        if (form.value.length === 0 || form == '') {
          return false;
        } else if (input.nombre.value.length === 0 || input.cedula.value.length === 0 ||
            input.apellido.value.length === 0 || input.cargo.value.length === 0 ||
            input.departamento.value.length === 0 || input.ext_telf.value.length === 0 ||
            input.nro_telf.value.length === 0 || input.sueldo.value.length === 0 || input.email.value.length === 0) {
          alert('Falto algun campo por rellenar');
          return (false);
        } else {
          var form = input.cedula;
            console.log(form.value);
            document.datos.method = "post";
            document.datos.action = "../controller/con_modificar_empleado.php";
            document.datos.submit();
        }
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
                  Nombres<input type="text" required autocomplete="off" onkeypress="return justLetters(event);"  id="nombre" name="nombre" title="Se Necesita los Nombres del Empleado" value="<?php echo $misDatosJSON->{'nombre'};?>" required />
              </div>
              <div class="empleado">
                  Apellidos<input type="text" required autocomplete="off" onkeypress="return justLetters(event);"  id="apellido" name="apellido" title="Se Necesita los Apellidos del Empleado" value="<?php echo $misDatosJSON->{'apellido'};?>" required/>
              </div>
              <!-- Verificar y hacer la relacion entre cargo y departamento -->
              <div class="contenedor">
                <div class="empleado">
                  <select name="cargo">
                    <option value="<?php echo $misDatosJSON->{'cargo'};?>">Cargo:</option>
                    <option value="1">DESARROLLADOR WEB</option>
                    <option value="2">ADMINISTRADOR CONTABLE</option>
                  </select>
                </div>

                <div class="empleado">
                  <select name="departamento">
                    <option value="<?php echo $misDatosJSON->{'departamento'};?>">Departamento:</option>
                    <option value="1">DESARROLLO WEB</option>
                    <option value="2">ADMINISTRACION</option>
                  </select>
                </div>
              </div>

              <div class="contenedor">
                <div class="empleado">
                    ext-telefonica<input type="text" required autocomplete="off" onkeypress="return justNumbers(event);" maxlength="4" id="ext_telf" name="ext_telf" title="Ingrese el Numero de Extesion del Empleado" value="<?php echo $misDatosJSON->{'ext_telefono'};?>" />
                </div>
                <div class="empleado">
                    nro-telefonico<input type="text" required autocomplete="off" onkeypress="return justNumbers(event);" maxlength="7" id="nro_telf" name="nro_telf" title="Ingrese el Numero Telefonico del Empleado" value="<?php echo $misDatosJSON->{'nro_telefono'};?>" required />
                </div>
              </div>

              <div class="empleado">
                  Sueldo<input type="text" required autocomplete="off" id="sueldo" name="sueldo" title="Suministre sueldo actual" onkeypress="return justNumbers(event);" value="<?php echo $misDatosJSON->{'sueldo'};?>" required />
              </div>

              <div class="empleado">
                Correo electronico<input type="email" required autocomplete="off" id="email" name="email" title="Ingrese el Correo Electronico del Empleado" value="<?php echo $misDatosJSON->{'email'};?>" required />
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

