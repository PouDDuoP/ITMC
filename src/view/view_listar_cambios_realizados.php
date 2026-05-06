<?php
session_start();
if (isset($_SESSION['cedula_empleado']) && !empty($_SESSION['cedula_empleado']) && $_SESSION['status'] === TRUE) {
  if ($_SESSION['perfil'] == 4 || $_SESSION['perfil'] == 3 ) {
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <?php include_once 'inc/head.php'; ?>
    <script type="text/javascript">
      function consultar(input){
        var form = input.rango.value;
        if (form != 0) {
          document.datos.method = "post";
          document.datos.action = "../controller/con_listar_cambios_realizados.php";
          document.datos.submit();
        } else {
          alert('Debe que escojer un valor');
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
      <form class="form" name='datos' action='#' method='post' autocomplete="off">
            <div class="empleado"> <h2>Consultar Cambios Realizados</h2> </div>
        <div class="empleado">
          <select name="rango">
            <option value="0">Seleccione el cantidad maxima que dese buscar:</option>
            <option value="10">10</option>
            <option value="50">50</option>
            <option value="100">100</option>
            <option value="200">200</option>
            <option value="300">300</option>
            <option value="ALL">Todos los registros</option>
          </select>
        </div>

        <button type="button" class="button button-block" onclick="javascript: consultar(document.datos);"/>Buscar</button>
      </form>
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
