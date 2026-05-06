<?php
session_start();
if (isset($_SESSION['cedula_empleado']) && !empty($_SESSION['cedula_empleado']) && $_SESSION['status'] === TRUE) {
  if ($_SESSION['perfil'] == 4 || $_SESSION['perfil'] == 2) {
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <?php include_once 'inc/head.php'; ?>
    <script type="text/javascript">
    function enviar(input){
      form = input.cedula.value;
      if (input.cedula.value.length === 0 || form == '') {
        alert('No ha ingresado el numero de cedula a buscar');
        input.cedula.focus();
        return (false);
      }else if ( /[^A-Za-z\d]/.test(form)) {
        alert('Solo puede ingresar numeros en el numero de cedula');
        input.cedula.focus();
        return (false);
      } else {
        var form = input.cedula;
          console.log(form.value);
          document.datos.method = "post";
          document.datos.action = "../controller/con_consulta_empleado.php";
          document.datos.submit();
      }
  	}
    </script>
  </head>
  <body>
    <header id="header">
      <?php include_once 'inc/header.php'; ?>
    </header>
    <?php include_once 'inc/nav.php'; ?>
    <section>
      <!-- <form class="form" action= '../controller/con_consultar_empleado.php' method='post' autocomplete="off"> -->
      <form class="form" autocomplete="off" name="datos">
      <div class="empleado">  <h3 style="text-align: center;">Consulta empleado para registro de hijos</h3></div>
        <div class="empleado">
          <label>
              Introduzca la Cedula del Empleado<span class="req">*</span>
          </label>
          <input type="text" required autocomplete="off" name='cedula' id='cedula'  onkeypress="return justNumbers(event);" maxlength="8"/>
        </div>
        <button type="button" class="button button-block" id="envio" onclick="javascript: enviar(document.datos);"/>Buscar</button>
      </form>
    </section>
    <section id="resultado">
    </section>
    <?php include_once 'inc/script-lib.php'; ?>
  </body>
</html>
<?php

  }else {
    header('location: view_menu.php');
  }
}else {
  header('location: ../index.php');
  session_destroy();
}
?>
